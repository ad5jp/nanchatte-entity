<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Models\Book as BookModel;
use App\Models\Chapter as ChapterModel;
use Carbon\CarbonImmutable;

class Book
{
    public function __construct(
        private BookModel $model
    ) {
        assert($this->model->exists);
    }

    public function book_id(): BookId
    {
        return BookId::create($this->model->book_id);
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

    public function published_date(): CarbonImmutable
    {
        return $this->model->published_date->toImmutable();
    }

    /**
     * @return Chapter[]|null
     */
    public function chapters(): ?array
    {
        return $this->model
            ->chapters
            ?->map(fn (ChapterModel $chapter) => $chapter->toEntity())
            ->all();
    }
}
