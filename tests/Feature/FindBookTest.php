<?php

namespace Tests\Feature;

use App\Repositories\BookRepository;
use App\UseCases\FindBook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindBookTest extends TestCase
{
    public function test_simple()
    {
        $repository = new BookRepository();
        $action = new FindBook($repository);
        $book = $action(1);

        dump(json_encode($book, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));

        $this->assertTrue(true);
    }
}
