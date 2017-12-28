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

Route::get('/books', 'Api\Books@index');
Route::get('/books/{id}', 'Api\Books@single');

Route::get('/authors', 'Api\Authors@index');
Route::get('/authors/{id}', 'Api\Authors@single');

Route::get('/categories', 'Api\Categories@index');
Route::get('/categories/{id}', 'Api\Categories@single');
