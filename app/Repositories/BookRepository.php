<?php

namespace App\Repositories;

use App\Entities\Book;
use App\Models\Book as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class BookRepository
{
    /**
     * 1件取得（Chapter, Paragraph まで含む）
     *
     * @param integer $book_id
     * @return Book|null
     */
    public function find(int $book_id) : ?Book
    {
        /** @var Model $book */
        $book = Model::with([
            'chapters',
            'chapters.paragraphs'
        ])->find($book_id);

        return $book ? $book->toEntity() : null;
    }

    /**
     * 検索
     *
     * @param array $conditions
     * @param ?int $limit
     * @return Book[]
     */
    public function search(array $conditions = [], int $limit = 10, $page) : array
    {
        $builder = $this->buildSearchQuery($conditions);

        // ソート順
        if (isset($conditions['orderby'])) {
            if ($conditions['orderby'] === 'published_date_asc') {
                $builder->orderBy('published_date', 'asc');
            } elseif ($conditions['orderby'] === 'published_date_desc') {
                $builder->orderBy('published_date', 'desc');
            }
        } else {
            $builder->orderBy('published_date', 'desc');
        }

        // ページング
        $builder->offset($limit * ($page - 1));
        $builder->limit($limit);

        // モデル取得
        /** @var Collection<Model> $models */
        $models = $builder->get();

        // エンティティの配列に変換
        return $models->map(function (Model $model) {
            return $model->toEntity();
        })->all();
    }

    /**
     * 件数取得
     *
     * @param array $conditions
     * @return int
     */
    public function count(array $conditions) : int
    {
        return $this->buildSearchQuery($conditions)->count();
    }

    /**
     * @param array $conditions
     * @return Builder
     */
    private function buildSearchQuery(array $conditions = []) : Builder
    {
        $builder = Model::query();

        // キーワード（タイトル・著者名）
        if (isset($conditions['keyword'])) {
            // スペース（全半角）で分割
            $keywords = explode(' ', str_replace('　', ' ', $conditions['keyword']));
            // AND検索
            foreach ($keywords as $keyword) {
                $builder->where(function ($or) use ($keyword) {
                    $or->where('book_title', 'like', "%{$keyword}%");
                    $or->orWhere('author_name', 'like', "%{$keyword}%");
                });
            }
        }

        // 発刊日
        if (isset($conditions['published_date_from'])) {
            $builder->where('published_date', '>=', Carbon::parse($conditions['published_date_from']));
        }
        if (isset($conditions['published_date_to'])) {
            $builder->where('published_date', '<=', Carbon::parse($conditions['published_date_to']));
        }

        return $builder;
    }

    /**
     * 新規登録
     *
     * @param Book $book
     * @return Book
     */
    public function add(Book $book) : Book
    {
        // @todo トランザクション

        $book->save();

        foreach ($book->chapters() as $chapter) {
            $chapter->setBookId($book->book_id());
            $chapter->save();

            foreach ($chapter->paragraphs() as $paragraph) {
                $paragraph->setChapterId($chapter->chapter_id());
                $paragraph->save();
            }
        }

        return $book;
    }
}
