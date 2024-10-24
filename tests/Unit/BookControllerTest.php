<?php

namespace Tests\Unit;

use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    // use DatabaseTransactions;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->markTestSkipped('Temporary skipped');
    }

    public function test_index_returns_all_books(): void
    {
        Book::factory()->count(3)->create();
        $response = $this->get('/api/books');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
    public function test_show_return_single_book(){
        $book = Book::factory()->create();
        $response = $this->get('/api/books/'.$book->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $book->id,
            'title' => $book->title,
        ]);
    }
    public function test_store_create_new_book(){
        $bookData = [
            'title' => 'Test title',
            'author' => 'Test author',
            'price' => 10.5
        ];
        $response = $this->post('/api/books', $bookData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $bookData);
    }
    public function test_update_edits_existing_book () {
        $book = Book::factory()->create();
        $updateData = [
            'title' => 'Update title',
            'author' => 'Update author',
            'price' => 20.5
        ];
        $response = $this->put('/api/books/'.$book->id, $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $updateData);
    }
    public function test_destroy_delete_book(){
        $book = Book::factory()->create();
        $response = $this->delete('/api/books/'.$book->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
    public function test_search_finds_books_by_title(){
        $book1 = Book::factory()->create(['title' => 'Laravel Book']);
        $book2 = Book::factory()->create(['title' => 'C Program Book']);
        $response = $this->get('/api/books/search/Laravel');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJson([
            ['title' => $book1->title]
        ]);
    }

        public function test_filters_finds_books_by_title(){
            // $this->markTestSkipped('Temporary skipped');
        $book1 = Book::factory()->create(['author' => 'Jonathan']);
        $book2 = Book::factory()->create(['author' => 'Potter']);
        $response = $this->get('/api/books/filters/Jonathan');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJson([
            ['author' => 'Jonathan']
        ]);
    }
}
