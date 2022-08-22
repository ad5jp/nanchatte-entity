<?php

namespace App\UseCases\Book;

use App\Domain\Book\BookRepository;

class SearchAction
{
    const ITEMS_PER_PAGE = 5;

    public function __construct(
        private BookRepository $repository
    ) {

    }
}
