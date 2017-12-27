<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', 'Books@index');
Route::get('/books/{id}', 'Books@single');

Route::get('/authors', 'Authors@index');
Route::get('/authors/{id}', 'Authors@single');

Route::get('/categories', 'Categories@index');
Route::get('/categories/{id}', 'Categories@single');
