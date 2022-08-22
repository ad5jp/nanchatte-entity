<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Models\Paragraph as Model;

class Paragraph
{
    public function __construct(
        private Model $model
    ) {
        assert($this->model->exists);
    }

    public function paragraph_id(): ParagraphId
    {
        return ParagraphId::create($this->model->paragraph_id);
    }

    public function chapter_id(): int
    {
        return $this->model->chapter_id;
    }

    public function content(): string
    {
        return $this->model->content;
    }

    public function sequence(): int
    {
        return $this->model->sequence;
    }

    public function start_page(): int
    {
        return $this->model->start_page;
    }
}
