<?php

namespace App\Http\Controllers\Api;

use App\Data\Book;
use App\Data\Category;
use App\Models\Books as BookModel;
use App\Models\Categories as CategoryModel;
use Illuminate\Http\JsonResponse;

class Books extends EntityController
{
	protected $valueObjectClassName = Book::class;

	protected $valueObjectModelName = BookModel::class;

	public function getBooksFromCategoryId($id = null): JsonResponse
	{
		if ((bool) $filteredId = static::validateNonZeroPositiveInteger((int) $id)) { // Validate Passed ID Parameter
			$category = (new CategoryModel())->fetchById($filteredId);
			if ($category instanceof Category) { // Check Category Retrieval
				$retrieved = (new BookModel())->fetchCategoryBooks($category);
				if (is_array($retrieved) && count($retrieved)) { // Check Retrieved Authors
					$return = $this->valueObjectOnlyDataResponse($this->convertArrayOfValueObjectsToArrayOfArrays($retrieved));
				} else { // Middle of Check Retrieved Authors
					$return = $this->notFoundResponse();
				} // End of Check Retrieved Authors
			} else { // Middle of Check Category Retrieval
				$return = $this->notFoundResponse(Category::class);
			} // End of Check Category Retrieval
		} else { // Middle of Validate Passed ID Parameter
			$return = $this->invalidIdResponse($id, $this->getClassNameWithoutNamespace(Category::class));
		} // End of Validate Passed ID Parameter
		return $return;
	}
}
