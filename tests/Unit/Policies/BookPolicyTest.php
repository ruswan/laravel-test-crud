<?php

namespace Tests\Unit\Policies;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class BookPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_book()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Book));
    }

    /** @test */
    public function user_can_view_book()
    {
        $user = $this->createUser();
        $book = Book::factory()->create();
        $this->assertTrue($user->can('view', $book));
    }

    /** @test */
    public function user_can_update_book()
    {
        $user = $this->createUser();
        $book = Book::factory()->create();
        $this->assertTrue($user->can('update', $book));
    }

    /** @test */
    public function user_can_delete_book()
    {
        $user = $this->createUser();
        $book = Book::factory()->create();
        $this->assertTrue($user->can('delete', $book));
    }
}
