<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return file_get_contents(storage_path('logs/laravel.log'));
});