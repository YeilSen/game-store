<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome.blade.php'); // o tu vista real
});