<?php

namespace Tests\Feature;

use App\Repositories\BookRepository;
use App\UseCases\AddBook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddBookTest extends TestCase
{
    public function test_simple()
    {
        $repository = new BookRepository();
        $action = new AddBook($repository);
        $action([
            'book_title' => 'オブジェクト指向でなぜつくるのか 第3版',
            'author_name' => '平澤章',
            'total_pages' => 410,
            'published_date' => '2021-04-05',
        ]);

        $this->assertTrue(true);
    }

    public function test_nested()
    {
        $repository = new BookRepository();
        $action = new AddBook($repository);
        $action([
            'book_title' => 'オブジェクト指向でなぜつくるのか 第3版',
            'author_name' => '平澤章',
            'total_pages' => 410,
            'published_date' => '2021-04-05',
            'chapters' => [
                [
                    'chapter_title' => 'オブジェクト指向はソフトウェア開発を楽にする技術',
                    'start_page' => 24,
                    'paragraphs' => [
                        [
                            'content' => '本文を読む前に、ウォーミングアップとして・・・',
                            'start_page' => 24,
                        ],
                        [
                            'content' => 'まずはこの本のタイトルにもなっている素朴な疑問から始めましょう。',
                            'start_page' => 26,
                        ],
                    ]
                ],
                [
                    'chapter_title' => 'オブジェクト指向と現実世界は似て非なるもの',
                    'start_page' => 41,
                    'paragraphs' => [
                        [
                            'content' => '本文を読む前に、ウォーミングアップとして・・・',
                            'start_page' => 41,
                        ],
                        [
                            'content' => '以降ではまず、オブジェクト指向プログラミングの三大要素とよばれる・・・',
                            'start_page' => 44,
                        ],
                    ]
                ],
                [
                    'chapter_title' => 'OOPを理解する近道はプログラミング言語の歴史にあり',
                    'start_page' => 62,
                ],
            ],
        ]);

        $this->assertTrue(true);
    }
}
