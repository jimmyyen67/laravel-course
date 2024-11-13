@extends('layouts.app')

@section('title', 'The list of tasks')

@section('content')
    <div>
        <a href="{{ route('tasks.create') }}">Create a new task</a>
    </div>

    <div>
        {{-- @if (count($tasks)) --}}
        @forelse ($tasks as $task)
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->title }}</a><br>
        @empty
            <p>There is no tasks!</p>
        @endforelse
        {{-- @endif --}}
    </div>

    @if ($tasks->count())
    <nav>
        {{ $tasks->links() }}
    </nav>
    @endif
@endsection
