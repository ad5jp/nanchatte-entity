<?php
namespace App\Entities;

use App\Models\Book as Model;
use App\Models\Chapter as ChapterModel;
use Illuminate\Support\Carbon;
use JsonSerializable;

class Book implements JsonSerializable
{
    private Model $model;

    /**
     * @var Chapter[]|null
     *
     * @comment
     * リレーション未ロードと、ロード済だが空なのとを区別できるよう、初期値は null にしている
     */
    private ?array $chapters = null;

    // @question
    // 本家では $model がコンストラクタプロモーションで実装されていたが、
    // UseCase (AddBook) で new Model() とかするわけにはいかないので、
    // この実装で良いだろうか・・・
    public function __construct(
        Model $model = null
    ) {
        if ($model) {
            $this->model = $model;
        } else {
            $this->model = new Model();
        }
    }

    public function book_id(): int
    {
        return $this->model->book_id;
    }

    public function book_title(): string
    {
        return $this->model->book_title;
    }

    public function author_name(): string
    {
        return $this->model->author_name;
    }

    public function total_pages(): int
    {
        return $this->model->total_pages;
    }

    public function published_date(): Carbon
    {
        return $this->model->published_date;
    }

    /**
     * @return Chapter[]
     */
    public function chapters(): array
    {
        // リレーションが未ロードなら、ロードする
        if ($this->chapters === null) {
            $this->chapters = $this->model->chapters->map(function (ChapterModel $chapter_model) {
                return $chapter_model->toEntity();
            })->all();
        }

        return $this->chapters;
    }

    public function setBookTitle(string $value): static
    {
        $this->model->book_title = $value;
        return $this;
    }

    public function setAuthorName(string $value): static
    {
        $this->model->author_name = $value;
        return $this;
    }

    public function setTotalPages(int $value): static
    {
        $this->model->total_pages = $value;
        return $this;
    }

    public function setPublishedDate(Carbon $value): static
    {
        $this->model->published_date = $value;
        return $this;
    }

    public function addChapter(Chapter $chapter): static
    {
        // リレーションが未ロードなら、まずロードする
        if ($this->chapters === null) {
            $this->chapters = $this->model->chapters->map(function (ChapterModel $chapter_model) {
                return $chapter_model->toEntity();
            })->all();
        }

        $this->chapters[] = $chapter;

        return $this;
    }

    public function save(): static
    {
        $this->model->save();
        return $this;
    }

    // @comment
    // コントローラで JsonResource に詰め替えてもよいが、
    // 結局 Model::whenLoaded() が使えず、
    // リレーション返却の必要/不要を制御できないため、
    // いっそ Entity にリソースの機能まで持たせるのがベターか。
    public function jsonSerialize(): array
    {
        return [
            'book_id' => $this->book_id(),
            'book_title' => $this->book_title(),
            'author_name' => $this->author_name(),
            'total_pages' => $this->total_pages(),
            'published_date' => $this->published_date()->format('Y-m-d'),
            'chapters' => $this->model->relationLoaded('chapters') ? $this->chapters() : [],
        ];
    }
}
