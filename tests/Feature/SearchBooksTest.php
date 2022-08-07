<?php

namespace Tests\Feature;

use App\Repositories\BookRepository;
use App\UseCases\SearchBooks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchBooksTest extends TestCase
{
    public function test_simple()
    {
        $repository = new BookRepository();
        $action = new SearchBooks($repository);
        $books = $action(
            conditions: [
                'keyword' => 'オブジェクト',
            ],
            page: 1
        );

        //dump(json_encode($books, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));

        $this->assertTrue(true);
    }

    public function test_multiple()
    {
        $repository = new BookRepository();
        $action = new SearchBooks($repository);
        $books = $action(
            conditions: [
                'keyword' => 'オブジェクト 平澤',
                'published_date_from' => '2020-01-01',
                'published_date_to' => '2021-12-31',
            ],
            page: 2
        );

        //dump(json_encode($books, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));

        $this->assertTrue(true);
    }
}
