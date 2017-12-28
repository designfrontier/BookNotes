<?php

namespace App\Models;

use App\Data\Author;
use App\Data\Book;
use App\Data\Category;
use App\Data\EntityObject;
use App\Models\Authors as AuthorModel;
use App\Models\Categories as CategoryModel;

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
		return $this->fetchValueObjectsWithIdAndNameFromBuilder(
			$this->select('books.*')
				->join('book_authors', 'book_authors.book_id', '=', 'books.id')
				->where('book_authors.author_id', $author->id),
			Book::class
		);
	}

	public function fetchCategoryBooks(Category $category):array
	{
		return $this->fetchValueObjectsWithIdAndNameFromBuilder(
			$this->select('books.*')
				->join('book_categories', 'book_categories.book_id', '=', 'books.id')
				->where('book_categories.category_id', $category->id),
			Book::class
		);
	}
}
