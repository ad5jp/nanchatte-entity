<?php

namespace App\UseCases;

use App\Entities\Book;
use App\Entities\Chapter;
use App\Entities\Paragraph;
use App\Repositories\BookRepository;
use Illuminate\Support\Carbon;

class AddBook
{
    public function __construct(
        private BookRepository $repository
    ) {

    }

    public function __invoke(array $input) : Book
    {
        // @question
        // 本家ではRepository内でエンティティを作成していたが、
        // 流石にネストデータを連想配列のままレポジトリまで持っていくわけにはいかないと思うので、
        // ここでエンティティに詰め替え。
        // むしろコントローラでやるべき？
        // もしくは、一旦別のDTOを噛ますべき？
        $book = new Book();
        $book->setBookTitle($input['book_title']);
        $book->setAuthorName($input['author_name']);
        $book->setTotalPages($input['total_pages']);
        $book->setPublishedDate(Carbon::parse($input['published_date']));

        if (isset($input['chapters'])) {
            foreach ($input['chapters'] as $chapter_index => $input_chapter) {
                $chapter = new Chapter();
                $chapter->setChapterTitle($input_chapter['chapter_title']);
                $chapter->setStartPage($input_chapter['start_page']);
                $chapter->setSequence($chapter_index + 1);

                if (isset($input_chapter['paragraphs'])) {
                    foreach ($input_chapter['paragraphs'] as $paragraph_index => $input_paragraph) {
                        $paragraph = new Paragraph();
                        $paragraph->setContent($input_paragraph['content']);
                        $paragraph->setStartPage($input_paragraph['start_page']);
                        $paragraph->setSequence($paragraph_index + 1);

                        $chapter->addParagraph($paragraph);
                    }
                }

                $book->addChapter($chapter);
            }
        }

        $book = $this->repository->add($book);

        return $book;
    }
}