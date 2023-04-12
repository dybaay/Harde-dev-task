<?php

namespace App\Services;

use App\Exceptions\BookError;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BooksResource;
use App\Http\Resources\ExternalBooksResource;
use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookService
{
    public function createBook(BookRequest $request): BookResource
    {
        $data = $request->all();

        $book = Book::query()->create([
            'name' => $data['name'],
            'isbn' => $data['isbn'],
            'authors' => $data['authors'],
            'country' => $data['country'],
            'number_of_pages' => $data['number_of_pages'],
            'publisher' => $data['publisher'],
            'release_date' => Carbon::parse($data['release_date'])->format('Y-m-d'),
        ]);

        return new BookResource($book);
    }

    /**
     * @throws BookError
     */
    public function updateBook(BookRequest $request, Book $book): BookResource
    {
        $data = $request->all();
        try {
            /**
             * Here, the model is only updated with
             * the filled request field
             */
            $book->update(array_filter(
                $data,
                function ($x) {
                    return ! is_null($x);
                }
            ));
        } catch (Exception $exception) {
            $this->logError($exception);
        }

        return new BookResource($book);
    }

    public function fetchExternalBooks(Request $request): ExternalBooksResource
    {
        $query = '';
        if ($request->get('name')) {
            $query = 'name='.urlencode($request->get('name'));
        }
        $res = Http::get('https://www.anapioficeandfire.com/api/books', $query);
        $books_from_api = json_decode($res, true);

        return new ExternalBooksResource($books_from_api);
    }

    public function fetchBooks(int $take = 0): BooksResource
    {
        if ($take > 0) {
            $books = Book::query()
                ->filter(\request(['name', 'country', 'publisher', 'release_date',  'year']))
                ->take($take)->get()->toArray();
        } else {
            $books = Book::query()
                ->filter(\request(['name', 'country', 'publisher', 'release_date',  'year']))
                ->get()->toArray();
        }

        return new BooksResource($books);
    }

    public function fetchBook(Book $book): BookResource
    {
        return new BookResource($book);
    }

    /**
     * @throws BookError
     */
    public function deleteBook(Book $book): void
    {
        try {
            $book->delete();
        } catch (Exception $exception) {
            $this->logError($exception);
        }
    }

    /**
     * @throws BookError
     */
    protected function logError(Exception $exception): void
    {
        Log::error($exception);
        throw new BookError('An unexpected error was encountered', 500);
    }
}
