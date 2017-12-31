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
		// @todo Need Validation of ID Field
		// @todo Need to Properly Index Payload with Entity Name

		$author = (new AuthorsModel())->fetchById($id);
		if ($author instanceof Author) { // Check Author Retrieval
			$return = '<ul>';
			foreach ((new CategoriesModel())->fetchAuthorCategories($author) as $currentCategory) { // Loop through Categories from Model
				$return .= sprintf('<li>(%d) %s </li>', $currentCategory->id, $currentCategory);
			} // End of Loop through Categories from Model
			$return .= '</ul>';
		} else { // Middle of Check Author Retrieval
			$return = '<p>Not Found</p>';
		} // End of Check Author Retrieval
		return $return;
	}
}
