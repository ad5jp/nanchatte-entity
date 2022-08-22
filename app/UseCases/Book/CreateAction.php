<?php

namespace App\UseCases\Book;

use App\Domain\Book\Book;
use App\Domain\Book\BookRepository;
use Carbon\CarbonImmutable;
use Illuminate\Database\DatabaseManager;
use Throwable;

class CreateAction
{
    public function __construct(
        private BookRepository $repository,
        private DatabaseManager $db,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function __invoke(array $input): Book
    {
        return $this->db->transaction(function () use ($input): Book {
            $book = $this->repository
                ->create(
                    bookTitle: $input['book_title'],
                    authorName: $input['author_name'],
                    totalPages: (int)$input['total_pages'],
                    publishDate: CarbonImmutable::parse($input['published_date']),
                );

            if (isset($input['chapters'])) {
                foreach ($input['chapters'] as $chapterIndex => $chapter) {
                    $chapterRecord = $this->repository
                        ->addChapter(
                            bookId: $book->book_id(),
                            chapterTitle: $chapter['chapter_title'],
                            startPage: (int)$chapter['start_page'],
                            sequence: $chapterIndex + 1,
                        );
                    if (isset($chapter['paragraphs'])) {
                        foreach ($chapter['paragraphs'] as $paragraphIndex => $paragraph) {
                            $this->repository
                                ->addParagraph(
                                    chapterId: $chapterRecord->chapter_id(),
                                    content: $paragraph['content'],
                                    startPage: $paragraph['start_page'],
                                    sequence: $paragraphIndex + 1,
                                );
                        }
                    }
                }
            }

            return $this->repository
                ->retrieveByIdWith($book->book_id());
        });
    }
}
