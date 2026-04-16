<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index.blade.php'); // o tu vista real
});