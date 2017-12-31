<?php

namespace App\Http\Controllers\Api;

use App\Data\Author;
use App\Data\Category;
use App\Models\AuthorsModel;
use App\Models\CategoriesModel;
use Illuminate\Http\JsonResponse;

class AuthorsController extends EntityController
{
	protected $valueObjectClassName = Author::class;

	protected $valueObjectModelName = AuthorsModel::class;

	public function getAuthorsFromCategoryId($id = null): JsonResponse
	{
		return $this->lookupCurrentValueObjectFromRetrievalValueObjectId((int) $id, new CategoriesModel(), 'fetchCategoryAuthors');
	}
}
