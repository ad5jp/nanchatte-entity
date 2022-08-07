<?php
namespace App\Entities;

use App\Models\Paragraph as Model;
use Illuminate\Support\Carbon;
use JsonSerializable;

class Paragraph implements JsonSerializable
{
    private Model $model;

    public function __construct(
        Model $model = null
    ) {
        if ($model) {
            $this->model = $model;
        } else {
            $this->model = new Model();
        }
    }

    public function paragraph_id(): int
    {
        return $this->model->paragraph_id;
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

    public function setChapterId(int $value): static
    {
        $this->model->chapter_id = $value;
        return $this;
    }

    public function setContent(string $value): static
    {
        $this->model->content = $value;
        return $this;
    }

    public function setSequence(int $value): static
    {
        $this->model->sequence = $value;
        return $this;
    }

    public function setStartPage(int $value): static
    {
        $this->model->start_page = $value;
        return $this;
    }

    public function save(): static
    {
        $this->model->save();
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'paragraph_id' => $this->paragraph_id(),
            'chapter_id' => $this->chapter_id(),
            'content' => $this->content(),
            'sequence' => $this->sequence(),
            'start_page' => $this->start_page(),
        ];
    }
}
