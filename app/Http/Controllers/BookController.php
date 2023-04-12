<?php

namespace App\Http\Controllers;

use App\Exceptions\BookError;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class BookController extends Controller
{
    public function index(BookService $bookService): Application|View|Factory
    {
        $books = $bookService->fetchBooks(10);

        return view('index', [
            'books' => $books,
        ]);
    }

    public function show(Book $book, BookService $bookService): View|Factory|Application
    {
        $book = $bookService->fetchBook($book);

        return view('show', [
            'book' => $book,
        ]);
    }

    public function edit(Book $book, BookService $bookService): View|Factory|Application
    {
        $book = $bookService->fetchBook($book);

        return view('edit', [
            'book' => $book,
        ]);
    }

    /**
     * @throws BookError
     */
    public function update(
        BookRequest $request,
        Book $book,
        BookService $bookService
    ): Application|Redirector|RedirectResponse {
        $bookService->updateBook($request, $book);

        return redirect(route('book.show', $book->id))->with('success', 'Book updated successfully');
    }

    /**
     * @throws BookError
     */
    public function delete(Book $book, BookService $bookService): Redirector|RedirectResponse|Application
    {
        $bookService->deleteBook($book);

        return redirect('/')->with('success', 'Book deleted successfully');
    }
}
