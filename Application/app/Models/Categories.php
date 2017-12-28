<?php

namespace App\Models;

use App\Data\Book;
use App\Data\Category;
use Illuminate\Database\Eloquent\Collection;

class Categories extends ValueObjectWithIdAndNameModel
{
	protected $valueObjectClassName = Category::class;

	public function fetchBookCategories(Book $book): array
	{
		$return = array();
		$retrieved = $this->select('categories.*')
			->join('book_categories', 'book_categories.category_id', '=', 'categories.id')
			->where('book_categories.book_id', $book->id)
			->get();
		if ($retrieved instanceof Collection) { // Check for DB Results
			foreach ($retrieved as $currentCategory) { // Loop through DB Results
				$currentCategoryObject = Category::getFromArray($currentCategory->toArray());
				if ($currentCategoryObject instanceof Category) { // Check Object Creation
					$return[] = $currentCategoryObject;
				} // End of Check Object Creation
			} // End of Loop through DB Results
		} // End of Check for DB Results
		return $return;
	}
}
