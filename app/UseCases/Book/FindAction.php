<?php

namespace App\UseCases\Book;

use App\Domain\Book\Book;
use App\Domain\Book\BookId;
use App\Domain\Book\BookRepository;

class FindAction
{
    public function __construct(
        private BookRepository $repository
    ) {
    }

    public function __invoke(BookId $id): ?Book
    {
        return $this->repository->retrieveByIdWith($id);
    }
}
