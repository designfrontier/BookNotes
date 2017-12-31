<?php

namespace App\Http\Controllers\Api;

use App\Data\Book;
use App\Data\Category;
use App\Models\BooksModel;
use App\Models\CategoriesModel;
use Illuminate\Http\JsonResponse;

class BooksController extends EntityController
{
	protected $valueObjectClassName = Book::class;

	protected $valueObjectModelName = BooksModel::class;

	public function getBooksFromCategoryId($id = null): JsonResponse
	{
		return $this->lookupCurrentValueObjectFromRetrievalValueObjectId((int) $id, new CategoriesModel(), 'fetchCategoryBooks');
	}
}
