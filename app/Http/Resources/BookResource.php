<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'isbn' => $this['isbn'],
            'authors' => [
                $this['authors'],
            ],
            'number_of_pages' => $this['number_of_pages'],
            'publisher' => $this['publisher'],
            'country' => $this['country'],
            'release_date' => Carbon::parse($this['release_date'])->format('Y-m-d'),
        ];
    }
}
