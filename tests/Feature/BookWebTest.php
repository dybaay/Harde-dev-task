<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_visit_home_page(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_can_view_a_book(): void
    {
        $book = Book::factory()->create();
        $response = $this->get('/books/'.$book->id);
        $response->assertSee('Book Details');
        $response->assertSee($book->name);
    }

    public function test_can_view_edit_book_page(): void
    {
        $book = Book::factory()->create();
        $response = $this->get('/books/edit/'.$book->id);
        $response->assertSee('Edit Book');
        $response->assertSee($book->name);
    }

    public function test_can_view_update_a_book(): void
    {
        $book = Book::factory()->create();
        $newName = $book->name.' '.'updated';
        $data = [
            'name' => $newName,
        ];

        $response = $this->patch('/books/'.$book->id, $data);
        $response->assertRedirect('/books/'.$book->id);
    }

    public function test_can_view_delete_a_book(): void
    {
        $book = Book::factory()->create();
        $response = $this->delete('/books/'.$book->id);
        $response->assertRedirect('/');
        $response->assertDontSee($book->name);
    }
}
