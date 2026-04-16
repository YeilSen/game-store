<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // o tu vista real
});