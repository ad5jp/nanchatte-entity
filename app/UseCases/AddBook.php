<?php

namespace App\UseCases;

use App\Entities\Book;
use App\Entities\Chapter;
use App\Entities\Paragraph;
use App\Repositories\BookRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Carbon;

class AddBook
{
    public function __construct(
        private BookRepository $repository
    ) {

    }

    public function __invoke(array $input) : Book
    {
        //@todo トランザクション

        $book = new Book();
        $book->setBookTitle($input['book_title']);
        $book->setAuthorName($input['author_name']);
        $book->setTotalPages($input['total_pages']);
        $book->setPublishedDate(Carbon::parse($input['published_date']));
        $book->save();

        if (isset($input['chapters'])) {
            foreach ($input['chapters'] as $chapter_index => $input_chapter) {
                $chapter = new Chapter();
                $chapter->setBookId($book->book_id());
                $chapter->setChapterTitle($input_chapter['chapter_title']);
                $chapter->setStartPage($input_chapter['start_page']);
                $chapter->setSequence($chapter_index + 1);
                $chapter->save();

                if (isset($input_chapter['paragraphs'])) {
                    foreach ($input_chapter['paragraphs'] as $paragraph_index => $input_paragraph) {
                        $paragraph = new Paragraph();
                        $paragraph->setChapterId($chapter->chapter_id());
                        $paragraph->setContent($input_paragraph['content']);
                        $paragraph->setStartPage($input_paragraph['start_page']);
                        $paragraph->setSequence($paragraph_index + 1);
                        $paragraph->save();

                        $chapter->addParagraph($paragraph);
                    }
                }

                $book->addChapter($chapter);
            }
        }

        return $book;
    }
}