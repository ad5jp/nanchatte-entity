<?php

namespace App\Repositories;

use App\Entities\Book;

class BookRepository
{
    /**
     * 新規登録
     *
     * @param Book $book
     * @return Book
     */
    public function add(Book $book) : Book
    {
        // @todo トランザクション

        $book->save();

        foreach ($book->chapters() as $chapter) {
            $chapter->setBookId($book->book_id());
            $chapter->save();

            foreach ($chapter->paragraphs() as $paragraph) {
                $paragraph->setChapterId($chapter->chapter_id());
                $paragraph->save();
            }
        }

        return $book;
    }
}
