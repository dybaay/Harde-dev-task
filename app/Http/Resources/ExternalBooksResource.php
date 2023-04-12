<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

class ExternalBooksResource extends ResourceCollection
{
    public function toArray(Request $request): object
    {
        return $this->collection->map(function ($book) {
            return [
                'name' => $book['name'],
                'isbn' => $book['isbn'],
                'authors' => $book['authors'],
                'number_of_pages' => $book['numberOfPages'],
                'publisher' => $book['publisher'],
                'country' => $book['country'],
                'release_date' => Carbon::parse($book['released'])->format('Y-m-d'),
            ];
        });
    }
}
