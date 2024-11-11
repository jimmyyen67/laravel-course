<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Hello World';
})->name('hello');

Route::get('/hallo', function () {
    return redirect('/hello');
});