<?php

namespace App\Models;

use App\Data\Author;
use App\Data\Book;
use App\Data\Category;
use App\Data\EntityObject;
use App\Models\Books as BookModel;

class Authors extends EntityModel
{
	protected $entityClassName = Author::class;

	protected function populateEntity(EntityObject $authorToPopulate): EntityObject
	{
		// @todo Consider Moving this Functionality to Entity Object Itself
		if ($authorToPopulate instanceof Author) { // Validate Passed Book Parameter
			$authorToPopulate->addBooks((new BookModel())->fetchAuthorBooks($authorToPopulate));

			// @todo Add Pseudonyms

		} // End of Validate Passed Book Parameter
		return $authorToPopulate;
	}

	public function fetchBookAuthors(Book $book): array
	{
		return $this->fetchValueObjectsWithIdAndNameFromBuilder(
			$this->select('authors.*')
				->join('book_authors', 'book_authors.author_id', '=', 'authors.id')
				->where('book_authors.book_id', $book->id),
			Author::class
		);
	}

	public function fetchCategoryAuthors(Category $category): array
	{
		return $this->fetchValueObjectsWithIdAndNameFromBuilder(
			$this->select('authors.*')
				->distinct()
				->join('book_authors', 'book_authors.author_id', '=', 'authors.id')
				->join('book_categories', 'book_categories.book_id', '=', 'book_authors.book_id')
				->where('book_categories.category_id', $category->id),
			Author::class
		);
	}
}
