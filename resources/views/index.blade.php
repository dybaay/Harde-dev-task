@extends('layouts.app')
@section('content')
<div class="flex flex-col space-y-4 justify-center outline-none focus:outline-none p-8">
    @if (session('success'))
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <h1 class="text-center mb-4 text-2xl font-extrabold">List of Books</h1>
    @foreach($books as $book)
        <div class="flex flex-col p-8 bg-white shadow-md hover:shadow-lg rounded-2xl w-1/2 ml-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                   <a href="{{ route('book.show', [$book['id']]) }}">
                       <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-16 h-16 rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                       </svg>
                   </a>
                    <div class="flex flex-col ml-3">
                        <div class="font-medium leading-none">{{ $book['name'] }}</div>
                        <div class="flex justify-between">
                            <p class="text-sm text-gray-600 leading-none mt-1">By <span class="font-bold">{{ $book['authors'] }}</span>
                            </p>
                            <p class="text-sm text-gray-600 leading-none mt-1 ml-4"><span class="font-bold">{{ $book['number_of_pages'] }}</span> Pages
                            </p>
                            <p class="text-sm text-gray-600 leading-none mt-1 ml-4">Released <span class="font-bold">{{ $book['release_date'] }}</span>
                            </p>
                        </div>

                    </div>
                </div>
                <div class="flex">
                    <a href="{{ route('book.edit', [$book['id']]) }}">
                        <button  class="flex-no-shrink bg-green-500 px-5 ml-4 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-green-500 text-white rounded-full">Edit</button>

                    </a>
                    <form action="{{ route('book.delete', [$book['id']]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this book?')"
                                class="flex-no-shrink bg-red-500 px-5 ml-4 py-2
                                text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2
                                 border-red-500 text-white rounded-full">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
