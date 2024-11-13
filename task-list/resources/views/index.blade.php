@extends('layouts.app')

@section('title', 'The list of tasks')

@section('content')
    <nav class="mb-4">
        <a href="{{ route('tasks.create') }}"
        class="link">Create a new task</a>
    </nav>

    <div>
        {{-- @if (count($tasks)) --}}
        @forelse ($tasks as $task)
        <div>
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}"
                @class(['font-bold', 'line-through' => $task->completed])>
                {{ $task->title }}
            </a>
        </div>
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
