<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', 'admin');


Route::get('/sanctum/csrf-cookie', function() {
    return response()->json([
        'csrf_token' => csrf_token(),
    ]);
});
