<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('catalog.blade.php'); // o tu vista real
});