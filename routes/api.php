<?php

use App\Http\Controllers\API\BookController;
use Illuminate\Support\Facades\Route;

Route::get('external-books', [BookController::class, 'getExternalBooks']);

Route::prefix('v1')->group(function () {
    Route::post('books', [BookController::class, 'createBook'])
        ->name('book.create');
    Route::get('books', [BookController::class, 'getBooks']);
    Route::patch('books/{book}', [BookController::class, 'updateBook'])
        ->name('book.update');
    Route::delete('books/{book}', [BookController::class, 'deleteBook']);
    Route::get('books/{book}', [BookController::class, 'getBook']);
});
