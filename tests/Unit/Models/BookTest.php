<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_has_title_link_attribute()
    {
        $book = Book::factory()->create();

        $title = __('app.show_detail_title', [
            'title' => $book->title, 'type' => __('book.book'),
        ]);
        $link = '<a href="'.route('books.show', $book).'"';
        $link .= ' title="'.$title.'">';
        $link .= $book->title;
        $link .= '</a>';

        $this->assertEquals($link, $book->title_link);
    }

    /** @test */
    public function a_book_has_belongs_to_creator_relation()
    {
        $book = Book::factory()->make();

        $this->assertInstanceOf(User::class, $book->creator);
        $this->assertEquals($book->creator_id, $book->creator->id);
    }
}
