<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App/Models/Book
 *
 * @property string $name
 * @property string $isbn
 * @property string $authors
 * @property string $country
 * @property int $number_of_pages
 * @property string $publisher
 * @property DateTime $release_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isbn',
        'authors',
        'country',
        'number_of_pages',
        'publisher',
        'release_date',
    ];

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['name'] ?? false,
            fn ($query, $name) => $query
                ->where('name', 'like', $name.'%')
        );

        $query->when(
            $filters['country'] ?? false,
            fn ($query, $country) => $query
                ->where('country', 'like', $country.'%')
        );

        $query->when(
            $filters['publisher'] ?? false,
            fn ($query, $publisher) => $query
                ->where('publisher', 'like', $publisher.'%')
        );

        $query->when(
            $filters['release_date'] ?? false,
            fn ($query, $release_date) => $query
                ->whereYear('release_date', $release_date)
        );

        $query->when(
            $filters['year'] ?? false,
            fn ($query, $year) => $query
                ->whereYear('release_date', $year)
        );
    }
}
