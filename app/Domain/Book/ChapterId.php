<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Common\ComparableInt;

class ChapterId
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
