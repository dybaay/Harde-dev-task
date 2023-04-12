<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookAPITest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_can_get_external_books(): void
    {
        $response = $this->getJson('/api/external-books');
        $response->assertStatus(200);
        $response->assertJson([
            'status_code' => 200,
            'status' => 'success',
            'data' => [
                [
                    'name' => true,
                    'isbn' => true,
                    'authors' => [
                        true,
                    ],
                    'country' => true,
                    'number_of_pages' => true,
                    'publisher' => true,
                    'release_date' => true,
                ],
            ],
        ]);
    }

    public function test_the_application_can_get_books(): void
    {
        Book::factory(20)->create();

        $response = $this->getJson('/api/v1/books');
        $response->assertStatus(200);
        $response->assertJson([
            'status_code' => 200,
            'status' => 'success',
            'data' => [
                [
                    'id' => true,
                    'name' => true,
                    'isbn' => true,
                    'authors' => [
                        true,
                    ],
                    'country' => true,
                    'number_of_pages' => true,
                    'publisher' => true,
                    'release_date' => true,
                ],
            ],
        ]);
    }

    public function test_the_application_can_create_a_book(): void
    {
        $data = [
            'name' => fake()->sentence('3'),
            'isbn' => fake()->isbn13(),
            'authors' => fake()->name,
            'country' => fake()->country,
            'number_of_pages' => fake()->numberBetween(100, 400),
            'publisher' => fake()->company,
            'release_date' => fake()->date,
        ];
        $response = $this->postJson('/api/v1/books', $data);
        $response->assertStatus(201);
        $response->assertJson([
            'status_code' => 201,
            'status' => 'success',
            'data' => [
                'book' => [
                    'name' => true,
                    'isbn' => true,
                    'authors' => [
                        true,
                    ],
                    'country' => true,
                    'number_of_pages' => true,
                    'publisher' => true,
                    'release_date' => true,
                ],
            ],
        ]);
    }

    public function test_the_application_can_update_a_book(): void
    {
        $book = Book::factory()->create();
        $name = $book->name;

        $data = [
            'name' => $name.' '.'Updated',
        ];

        $response = $this->patchJson("/api/v1/books/{$book->id}", $data);
        $response->assertStatus(200);
        $response->assertJson([
            'status_code' => 200,
            'status' => 'success',
            'message' => "The book {$name} was updated successfully",
            'data' => [
                'name' => $name.' '.'Updated',
            ],
        ]);

    }

    public function test_the_application_can_show_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/v1/books/{$book->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'status_code' => 200,
            'status' => 'success',
            'data' => [
                'id' => true,
                'name' => true,
                'isbn' => true,
                'authors' => [
                    true,
                ],
                'country' => true,
                'number_of_pages' => true,
                'publisher' => true,
                'release_date' => true,
            ],
        ]);
    }

    public function test_the_application_can_delete_a_book(): void
    {
        $book = Book::factory()->create();
        $name = $book->name;

        $response = $this->deleteJson("/api/v1/books/{$book->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'status_code' => 200,
            'status' => 'success',
            'message' => "The book {$name} was deleted successfully",
            'data' => false,
        ]);
}
}
