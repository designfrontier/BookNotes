<?php

namespace App\Http\Controllers\Api;

use App\Data\Author;
use App\Data\Category;
use App\Models\AuthorsModel;
use App\Models\CategoriesModel;

class CategoriesController extends ValueObjectWithIdAndNameController
{
	protected $valueObjectClassName = Category::class;

	protected $valueObjectModelName = CategoriesModel::class;

	public function getCategoriesFromAuthorId($id = null)
	{
		return $this->lookupCurrentValueObjectFromRetrievalValueObjectId((int) $id, new AuthorsModel(), 'fetchAuthorCategories');
	}
}
