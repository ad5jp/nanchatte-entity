<?php

namespace App\UseCases;

use App\Entities\Book;
use App\Repositories\BookRepository;

class FindBook
{
    public function __construct(
        private BookRepository $repository
    ) {

    }

    public function __invoke(int $book_id) : Book
    {
        return $this->repository->find($book_id);
    }
}