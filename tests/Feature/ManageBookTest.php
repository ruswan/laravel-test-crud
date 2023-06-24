<?php

namespace Tests\Feature;

use App\Models\Book;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageBookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_book_list_in_book_index_page()
    {
        $book = Book::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('books.index');
        $this->see($book->title);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Book 1 title',
            'description' => 'Book 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_book()
    {
        $this->loginAsUser();
        $this->visitRoute('books.index');

        $this->click(__('book.create'));
        $this->seeRouteIs('books.create');

        $this->submitForm(__('app.create'), $this->getCreateFields());

        $this->seeRouteIs('books.show', Book::first());

        $this->seeInDatabase('books', $this->getCreateFields());
    }

    /** @test */
    public function validate_book_title_is_required()
    {
        $this->loginAsUser();

        // title empty
        $this->post(route('books.store'), $this->getCreateFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_book_title_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // title 70 characters
        $this->post(route('books.store'), $this->getCreateFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_book_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('books.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Book 1 title',
            'description' => 'Book 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_book()
    {
        $this->loginAsUser();
        $book = Book::factory()->create(['title' => 'Testing 123']);

        $this->visitRoute('books.show', $book);
        $this->click('edit-book-'.$book->id);
        $this->seeRouteIs('books.edit', $book);

        $this->submitForm(__('book.update'), $this->getEditFields());

        $this->seeRouteIs('books.show', $book);

        $this->seeInDatabase('books', $this->getEditFields([
            'id' => $book->id,
        ]));
    }

    /** @test */
    public function validate_book_title_update_is_required()
    {
        $this->loginAsUser();
        $book = Book::factory()->create(['title' => 'Testing 123']);

        // title empty
        $this->patch(route('books.update', $book), $this->getEditFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_book_title_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $book = Book::factory()->create(['title' => 'Testing 123']);

        // title 70 characters
        $this->patch(route('books.update', $book), $this->getEditFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_book_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $book = Book::factory()->create(['title' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('books.update', $book), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_book()
    {
        $this->loginAsUser();
        $book = Book::factory()->create();
        Book::factory()->create();

        $this->visitRoute('books.edit', $book);
        $this->click('del-book-'.$book->id);
        $this->seeRouteIs('books.edit', [$book, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('books', [
            'id' => $book->id,
        ]);
    }
}
