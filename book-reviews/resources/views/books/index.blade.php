@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text2xl">Books</h1>

    <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
        <label for="title">
            <input type="text" name="title" placeholder="Search by title" value="{{ request('title') }}" class="input h-10" />
        </label>
        <button type="submit" class="btn h-10">Search</button>
        <a href="{{ route('books.index') }}" class="link">Clear</a>
    </form>

    <ui>
        @forelse ($books as $book)
            <li class="mb-4 list-none">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">{{ $book->author }}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                {{ number_format($book->reviews_avg_rating, 1) }}
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4 list-none">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ui>
@endsection