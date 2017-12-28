<?php

namespace App\Models;

use App\Data\Author;
use App\Data\Book;
use App\Data\Category;
use App\Data\EntityObject;
use App\Models\Authors as AuthorModel;
use App\Models\Categories as CategoryModel;
use Illuminate\Database\Eloquent\Collection;

class Books extends EntityModel
{
	protected $entityClassName = Book::class;

	protected function populateEntity(EntityObject $bookToPopulate): EntityObject
	{
		// @todo Consider Moving this Functionality to Entity Object Itself
		if ($bookToPopulate instanceof Book) { // Validate Passed Book Parameter
			$bookToPopulate->addCategories((new CategoryModel())->fetchBookCategories($bookToPopulate));
			$bookToPopulate->addAuthors((new AuthorModel())->fetchBookAuthors($bookToPopulate));

			// @todo Add Notes

		} // End of Validate Passed Book Parameter
		return $bookToPopulate;
	}

	public function fetchAuthorBooks(Author $author):array
	{
		$return = array();
		$retrieved = $this->select('books.*')
			->join('book_authors', 'book_authors.book_id', '=', 'books.id')
			->where('book_authors.author_id', $author->id)
			->get();
		if ($retrieved instanceof Collection) { // Check for DB Results
			foreach ($retrieved as $currentBook) { // Loop through DB Results
				$currentBookObject = Book::getFromArray($currentBook->toArray());
				if ($currentBookObject instanceof Book) { // Check Object Creation
					$return[] = $currentBookObject;
				} // End of Check Object Creation
			} // End of Loop through DB Results
		} // End of Check for DB Results
		return $return;
	}

	public function fetchCategoryBooks(Category $category):array
	{
		$return = array();
		// @todo Look Up Books by Category
		return $return;
	}
}
