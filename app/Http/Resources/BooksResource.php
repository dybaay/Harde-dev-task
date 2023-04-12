<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

class BooksResource extends ResourceCollection
{
    public function toArray(Request $request): object
    {
        return $this->collection->map(function ($book) {
            return [
                'id' => $book['id'],
                'name' => $book['name'],
                'isbn' => $book['isbn'],
                'authors' => [
                    $book['authors'],
                ],
                'number_of_pages' => $book['number_of_pages'],
                'publisher' => $book['publisher'],
                'country' => $book['country'],
                'release_date' => Carbon::parse($book['release_date'])->format('Y-m-d'),
            ];
        });
    }
}
