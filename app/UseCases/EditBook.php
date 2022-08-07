<?php

namespace App\UseCases;

use App\Entities\Book;
use App\Entities\Chapter;
use App\Entities\Paragraph;
use App\Repositories\BookRepository;
use Illuminate\Support\Carbon;

class EditBook
{
    public function __construct(
        private BookRepository $repository
    ) {

    }

    public function __invoke(int $book_id, array $input) : Book
    {
        $book = $this->repository->find($book_id);

        $book->setBookTitle($input['book_title']);
        $book->setAuthorName($input['author_name']);
        $book->setTotalPages($input['total_pages']);
        $book->setPublishedDate(Carbon::parse($input['published_date']));

        // @todo

        return $book;
    }
}