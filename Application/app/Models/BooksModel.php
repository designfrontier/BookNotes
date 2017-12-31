<?php

namespace App\Models;

use App\Data\Author;
use App\Data\Book;
use App\Data\Category;
use App\Data\ValueObjectWithId;
use App\Models\AuthorsModel;
use App\Models\CategoriesModel;

class BooksModel extends EntityModel
{
	protected $table = 'books';

	protected $valueObjectClassName = Book::class;

	protected function populateValueObjectWithId(ValueObjectWithId $bookToPopulate): ValueObjectWithId
	{
		// @todo Consider Moving this Functionality to Entity Object Itself
		if ($bookToPopulate instanceof Book) { // Validate Passed Book Parameter
			$bookToPopulate->addCategories((new CategoriesModel())->fetchBookCategories($bookToPopulate));
			$bookToPopulate->addAuthors((new AuthorsModel())->fetchBookAuthors($bookToPopulate));
			$bookToPopulate->addNotes((new NotesModel())->fetchBookNotes($bookToPopulate));
		} // End of Validate Passed Book Parameter
		return $bookToPopulate;
	}

	public function fetchAuthorBooks(Author $author):array
	{
		return $this->fetchValueObjectsWithIdFromBuilder(
			$this->select('books.*')
				->join('book_authors', 'book_authors.book_id', '=', 'books.id')
				->where('book_authors.author_id', $author->id)
		);
	}

	public function fetchCategoryBooks(Category $category):array
	{
		return $this->fetchValueObjectsWithIdFromBuilder(
			$this->select('books.*')
				->join('book_categories', 'book_categories.book_id', '=', 'books.id')
				->where('book_categories.category_id', $category->id)
		);
	}
}
