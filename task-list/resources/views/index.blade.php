@extends('layouts.app')

@section('title', 'The list of tasks')

@section('content')

    <div>
        {{-- @if (count($tasks)) --}}
        @forelse ($tasks as $task)
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->title }}</a><br>
        @empty
            <p>There is no tasks!</p>
        @endforelse
        {{-- @endif --}}
    </div>

@endsection
