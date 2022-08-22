<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Models\Chapter as ChapterModel;
use  App\Models\Paragraph as ParagraphModel;

class Chapter
{
    public function __construct(
        private ChapterModel $model
    ) {
        assert($this->model->exists);
    }

    public function chapter_id(): ChapterId
    {
        return ChapterId::create($this->model->chapter_id);
    }

    public function book_id(): BookId
    {
        return BookId::create($this->model->book_id);
    }

    public function chapter_title(): string
    {
        return $this->model->chapter_title;
    }

    public function sequence(): int
    {
        return $this->model->sequence;
    }

    public function start_page(): int
    {
        return $this->model->start_page;
    }

    /**
     * @return Paragraph[]|null
     */
    public function paragraph(): ?array
    {
        return $this->model
            ->paragraphs
            ?->map(fn (ParagraphModel $paragraph) => $paragraph->toEntity())
            ->all();
    }
}
