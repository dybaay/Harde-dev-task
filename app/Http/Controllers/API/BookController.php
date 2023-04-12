<?php

namespace App\Http\Controllers\API;

use App\Exceptions\BookError;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookService;
use App\Services\Helpers\ApiResponseHelper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function getExternalBooks(Request $request, BookService $bookService): JsonResponse
    {
        $response = $bookService->fetchExternalBooks($request);

        return ApiResponseHelper::success(data: $response);
    }

    public function createBook(BookRequest $request, BookService $bookService): JsonResponse
    {
        try {
            $book = $bookService->createBook($request);
        } catch (Exception $exception) {
            Log::error($exception);

            return ApiResponseHelper::failed('An unexpected error was encountered.', 500);
        }

        return ApiResponseHelper::success(201, data: ['book' => $book]);
    }

    public function getBooks(BookService $bookService): JsonResponse
    {
        $response = $bookService->fetchBooks();

        return ApiResponseHelper::success(data: $response);
    }

    /**
     * @throws BookError
     */
    public function updateBook(BookRequest $request, Book $book, BookService $bookService): JsonResponse
    {
        $name = $book->name;
        $bookService->updateBook($request, $book);
        $book = new BookResource($book);

        return ApiResponseHelper::success(message: "The book {$name} was updated successfully", data: $book);
    }

    /**
     * @throws BookError
     */
    public function deleteBook(Book $book, BookService $bookService): JsonResponse
    {
        $name = $book->name;
        $bookService->deleteBook($book);

        return ApiResponseHelper::success(message: "The book {$name} was deleted successfully");
    }

    public function getBook(Book $book, BookService $bookService): JsonResponse
    {
        $book = $bookService->fetchBook($book);

        return ApiResponseHelper::success(data: $book);
    }
}
