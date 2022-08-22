<?php

namespace App\Domain\Book;

use App\Common\ComparableInt;

class ParagraphId
{
    use ComparableInt;

    public function value(): int
    {
        return $this->value;
    }

    public static function create(int $id): static
    {
        return new self($id);
    }
}
