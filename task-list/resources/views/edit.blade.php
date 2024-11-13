@extends('layouts.app')

@section('title', 'Add Task')

@section('content')
    @include('form', ['task' => $task])
@endsection
