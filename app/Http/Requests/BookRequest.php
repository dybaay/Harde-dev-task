<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return match (true) {
            $this->routeIs('book.create') => $this->createBookRules(),
            $this->routeIs('book.update') => $this->updateBookRules(),
            default => []
        };
    }

    /**
     * validation rules for creating a book.
     */
    public function createBookRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255'],
            'authors' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'number_of_pages' => ['required', 'integer'],
            'publisher' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date', 'max:255'],
        ];
    }

    /**
     * validation rules for updating a book.
     */
    public function updateBookRules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:255'],
            'authors' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'number_of_pages' => ['nullable', 'integer', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'release_date' => ['nullable', 'date', 'max:255'],
        ];
    }
}
