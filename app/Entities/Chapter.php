<?php
namespace App\Entities;

use App\Models\Chapter as Model;
use App\Models\Paragraph as ParagraphModel;
use Illuminate\Support\Carbon;
use JsonSerializable;

class Chapter implements JsonSerializable
{
    private Model $model;

    /**
     * @var Paragraph[]|null
     */
    private ?array $paragraphs = null;

    public function __construct(
        Model $model = null
    ) {
        if ($model) {
            $this->model = $model;
        } else {
            $this->model = new Model();
        }
    }

    public function chapter_id(): int
    {
        return $this->model->chapter_id;
    }

    public function book_id(): int
    {
        return $this->model->book_id;
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
     * @return Paragraph[]
     */
    public function paragraphs(): array
    {
        // リレーションが未ロードなら、まずロードする
        if ($this->paragraphs === null) {
            $this->paragraphs = $this->model->paragraphs->map(function (ParagraphModel $chapter_model) {
                return $chapter_model->toEntity();
            })->all();
        }

        return $this->paragraphs;
    }

    public function setBookId(int $value): static
    {
        $this->model->book_id = $value;
        return $this;
    }

    public function setChapterTitle(string $value): static
    {
        $this->model->chapter_title = $value;
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

    public function addParagraph(Paragraph $paragraph): static
    {
        // リレーションが未ロードなら、まずロードする
        if ($this->paragraphs === null) {
            $this->paragraphs = $this->model->paragraphs->map(function (ParagraphModel $paragraph_model) {
                return $paragraph_model->toEntity();
            })->all();
        }

        $this->paragraphs[] = $paragraph;

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
            'chapter_id' => $this->chapter_id(),
            'book_id' => $this->book_id(),
            'chapter_title' => $this->chapter_title(),
            'sequence' => $this->sequence(),
            'start_page' => $this->start_page(),
            'paragraphs' => $this->model->relationLoaded('paragraphs') ? $this->paragraphs() : [],
        ];
    }
}
