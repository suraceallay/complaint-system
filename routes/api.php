<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test-middleware', function (Request $request) {
    return response()->json([
        'message' => 'Middleware test',
        'user' => $request->user() ? $request->user()->only(['id', 'user_id', 'name']) : null
    ]);
})->middleware('auth.sanctum');

Route::get('/public-test', function () {
    return response()->json(['message' => 'Public route']);
});