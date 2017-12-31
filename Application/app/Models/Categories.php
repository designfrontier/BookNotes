<?php

namespace App\Models;

use App\Data\Author;
use App\Data\Book;
use App\Data\Category;

class Categories extends ValueObjectWithIdAndNameModel
{
	protected $valueObjectClassName = Category::class;

	public function fetchBookCategories(Book $book): array
	{
		return $this->fetchValueObjectsWithIdFromBuilder(
			$this->select('categories.*')
				->join('book_categories', 'book_categories.category_id', '=', 'categories.id')
				->where('book_categories.book_id', $book->id),
			Category::class
		);
	}

	public function fetchAuthorCategories(Author $author): array
	{
		return $this->fetchValueObjectsWithIdFromBuilder(
			$this->select('categories.*')
				->distinct()
				->join('book_categories', 'book_categories.category_id', '=', 'categories.id')
				->join('book_authors', 'book_authors.book_id', '=', 'book_categories.book_id')
				->where('book_authors.author_id', $author->id),
			Category::class
		);
	}
}
