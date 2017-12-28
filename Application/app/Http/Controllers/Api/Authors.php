<?php

namespace App\Http\Controllers\Api;

use App\Data\Author;
use App\Data\Category;
use App\Models\Authors as AuthorModel;
use App\Models\Categories as CategoryModel;
use Illuminate\Http\JsonResponse;

class Authors extends EntityController
{
	protected $entityClassName = Author::class;

	protected $entityModelName = AuthorModel::class;

	public function getAuthorsFromCategoryId($id = null): JsonResponse
	{
		// @todo Need Validation of ID Field

		$category = (new CategoryModel())->fetchById($id);
		if ($category instanceof Category) { // Check Category Retrieval
			$retrieved = (new AuthorModel())->fetchCategoryAuthors($category);
			if (is_array($retrieved) && count($retrieved)) { // Check Retrieved Authors
				$return = $this->entityOnlyDataResponse($this->convertArrayOfEntitiesToArrayOfArrays($retrieved));
			} else { // Middle of Check Retrieved Authors
				$return = $this->notFoundResponse();
			} // End of Check Retrieved Authors
		} else { // Middle of Check Category Retrieval
			$return = $this->notFoundResponse(Category::class);
		} // End of Check Category Retrieval
		return $return;
	}
}
