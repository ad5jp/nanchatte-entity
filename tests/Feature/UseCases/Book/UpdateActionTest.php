<?php

namespace Tests\Feature\UseCases\Book;

use App\Domain\Book\BookRepository;
use App\Models\Book as BookModel;
use App\Models\Chapter;
use App\Models\Paragraph;
use App\UseCases\Book\UpdateAction;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateActionTest extends TestCase
{
    use RefreshDatabase;

    private UpdateAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $repository = $this->app->make(BookRepository::class);
        $db = $this->app->make(DatabaseManager::class);

        $this->action = new UpdateAction($repository, $db);
    }

    private function prepareBookEntity(): void
    {
        /**
         * Factory 作るのめんどくさいので普通に挿入
         */
        BookModel::find()

        $book = BookModel::query()->forceCreate([
            'book_title' => 'オブジェクト指向でなぜつくるのか 第3版',
            'author_name' => '平澤章',
            'total_pages' => 410,
            'published_date' => '2021-04-05',
        ]);
        assert($book instanceof BookModel);

        $chapter1 = Chapter::query()->forceCreate([
            'book_id' => $book->book_id,
            'chapter_title' => 'オブジェクト指向はソフトウェア開発を楽にする技術',
            'start_page' => 24,
        ]);
        assert($chapter1 instanceof Chapter);
        Paragraph::query()->forceCreate([
            'chapter_id' => $chapter1->chapter_id,
            'content' => '本文を読む前に、ウォーミングアップとして・・・',
            'start_page' => 24,
        ]);
        Paragraph::query()->forceCreate([
            'chapter_id' => $chapter1->chapter_id,
            'content' => 'まずはこの本のタイトルにもなっている素朴な疑問から始めましょう。',
            'start_page' => 26,
        ]);

        $chapter2 = Chapter::query()->forceCreate([
            'book_id' => $book->book_id,
            'chapter_title' => 'オブジェクト指向と現実世界は似て非なるもの',
            'start_page' => 41,
        ]);
        assert($chapter2 instanceof Chapter);
        Paragraph::query()->forceCreate([
            'chapter_id' => $chapter2->chapter_id,
            'content' => '本文を読む前に、ウォーミングアップとして・・・',
            'start_page' => 41,
        ]);
        Paragraph::query()->forceCreate([
            'chapter_id' => $chapter2->chapter_id,
            'content' => '以降ではまず、オブジェクト指向プログラミングの三大要素とよばれる・・・',
            'start_page' => 44,
        ]);

        $chapter3 = Chapter::query()->forceCreate([
            'book_id' => $book->book_id,
            'chapter_title' => 'OOPを理解する近道はプログラミング言語の歴史にあり',
            'start_page' => 62,
        ]);
    }
}
