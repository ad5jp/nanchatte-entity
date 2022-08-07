<?php

namespace Tests\Feature;

use App\Repositories\BookRepository;
use App\UseCases\AddBook;
use App\UseCases\EditBook;
use App\UseCases\FindBook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditBookTest extends TestCase
{
    public function test_nested()
    {
        $repository = new BookRepository();

        // まず追加
        $action = new AddBook($repository);
        $created = $action([
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

        // 取得
        $action = new FindBook($repository);
        $book = $action($created->book_id());

        $data = json_decode(json_encode($book), true);

        // Bookの変更
        $data['book_title'] = 'オブジェクト指向でなぜつくるのか 第4版';
        $data['published_date'] = '2022-07-01';
        // Chapterの追加
        $data['chapters'][] = [
            'chapter_title' => 'OOPは無駄を省いて整理整頓するプログラミング技術',
            'start_page' => 87,
            'paragraphs' => [
                [
                    'content' => '本文を読む前に、ウォーミングアップとして・・・',
                    'start_page' => 87,
                ],
                [
                    'content' => 'この章ではOOPの基本的な仕組みを説明します。',
                    'start_page' => 89,
                ],
            ]
        ];
        // Chapterの変更
        $data['chapters'][1]['chapter_title'] = 'オブジェクト指向 (OOP) と現実世界は似て非なるもの';
        // Paragraphの追加
        $data['chapters'][1]['paragraphs'][] = [
            'content' => 'クラスは種類、インスタンスは具体的なもの',
            'start_page' => 47,
        ];
        // Paragraph の変更
        $data['chapters'][1]['paragraphs'][1]['start_page'] = 41;
        // Paragraph の削除
        unset($data['chapters'][1]['paragraphs'][0]);
        // Chapterの削除
        unset($data['chapters'][0]);

        $action = new EditBook($repository);
        $created = $action($created->book_id(), $data);

        $this->assertTrue(true);
    }
}
