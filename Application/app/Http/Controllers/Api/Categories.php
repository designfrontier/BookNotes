<?php

namespace App\Http\Controllers\Api;

use App\Data\Author;
use App\Data\Category;
use App\Models\Authors as AuthorModel;
use App\Models\Categories as CategoriesModel;

class Categories extends BaseController
{
	public function index()
	{
		$return = '<ul>';
		foreach ((new CategoriesModel())->fetchAll() as $currentCategory) { // Loop through Categories from Model
			$return .= sprintf('<li>(%d) %s </li>', $currentCategory->id, $currentCategory);
		} // End of Loop through Categories from Model
		$return .= '</ul>';
		return $return;
	}

	public function single($id = null)
	{
		// @todo Need Validation of ID Field

		$return = (new CategoriesModel())->fetchById($id);
		return '<pre>' . ($return instanceof Category ? print_r($return, true) : 'Not Found') . '</pre>';
	}

	public function getCategoriesFromAuthorId($id = null)
	{
		// @todo Need Validation of ID Field
		// @todo Need to Properly Index Payload with Entity Name

		$author = (new AuthorModel())->fetchById($id);
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
