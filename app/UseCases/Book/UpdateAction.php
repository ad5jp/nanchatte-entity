<?php

namespace App\UseCases\Book;

use App\Domain\Book\Book;
use App\Domain\Book\BookId;
use App\Domain\Book\BookRepository;
use Carbon\CarbonImmutable;
use Illuminate\Database\DatabaseManager;
use Throwable;

class UpdateAction
{
    public function __construct(
        private BookRepository $repository,
        private DatabaseManager $db,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function __invoke(BookId $bookId, array $input): ?Book
    {
        return $this->db->transaction(function () use ($bookId, $input): ?Book {
            $book = $this->repository
                ->retrieveByIdWith($bookId);
            if ($book === null) {
                // この辺のハンドリングは要検討，retrieveByIdWithOrFail() を実装するのもアリ
                return null;
            }

            return $this->repository
                ->updateOrCreate(
                    bookId: $bookId,
                    bookTitle: $input['book_title'],
                    authorName: $input['author_name'],
                    totalPages: (int)$input['total_pages'],
                    publishDate: CarbonImmutable::parse($input['published_date']),
                );
        });
    }
}
