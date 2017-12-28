<?php

namespace App\Http\Controllers\Api;

use App\Data\Category;
use App\Models\Categories as CategoriesModel;
use App\Http\Controllers\Controller; // @todo Remove This

class Categories extends Controller // @todo Change Parent Class
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
		$return = (new CategoriesModel())->fetchById($id);
		return '<pre>' . ($return instanceof Category ? print_r($return, true) : 'Not Found') . '</pre>';
	}
}
