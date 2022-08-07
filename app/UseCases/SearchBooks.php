<?php

namespace App\UseCases;

use App\Entities\Book;
use App\Entities\Chapter;
use App\Entities\Paragraph;
use App\Repositories\BookRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class SearchBooks
{
    const ITEMS_PER_PAGE = 5;

    public function __construct(
        private BookRepository $repository
    ) {

    }

    /**
     * @param array $conditions
     * @param integer $page
     * @return new LengthAwarePaginator<Book>
     */
    public function __invoke(array $conditions, int $page = 1) : LengthAwarePaginator
    {
        $books = $this->repository->search(
            conditions: $conditions,
            limit: self::ITEMS_PER_PAGE,
            page: $page
        );
        $count = $this->repository->count($conditions);

        return new LengthAwarePaginator(
            items: $books,
            total: $count,
            perPage: self::ITEMS_PER_PAGE,
            currentPage: $page
        );
    }
}