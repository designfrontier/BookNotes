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

Route::get('/authors', 'Api\AuthorsController@index');
Route::get('/authors/{id}', 'Api\AuthorsController@single');
Route::get('/authors/category/{id}', 'Api\AuthorsController@getAuthorsFromCategoryId');

Route::get('/books', 'Api\BooksController@index');
Route::get('/books/{id}', 'Api\BooksController@single');
Route::get('/books/category/{id}', 'Api\BooksController@getBooksFromCategoryId');

Route::get('/categories', 'Api\CategoriesController@index');
Route::get('/categories/{id}', 'Api\CategoriesController@single');
Route::get('/categories/author/{id}', 'Api\CategoriesController@getCategoriesFromAuthorId');

Route::get('/contributionTypes', 'Api\ContributionTypesController@index');
Route::get('/contributionTypes/{id}', 'Api\ContributionTypesController@single');

Route::get('/readingLists', 'Api\ReadingListsController@index');
Route::get('/readingLists/{id}', 'Api\ReadingListsController@single');
Route::get('/readingLists/book/{id}', 'Api\ReadingListsController@getReadingListsFromBookId');
