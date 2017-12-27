<?php

namespace App\Http\Controllers;

use App\Data\Category;
use App\Models\Categories as CategoriesModel;

class Categories extends Controller
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
