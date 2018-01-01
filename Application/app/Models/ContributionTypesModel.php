<?php

namespace App\Models;

use App\Data\Author;
use App\Data\Book;
use App\Data\ContributionType;

class ContributionTypesModel extends ValueObjectWithIdAndNameModel
{
	protected $table = 'contribution_types';

	protected $valueObjectClassName = ContributionType::class;

	public function fetchBookAuthorContributionType(Book $book, Author $author)
	{
		return $this->fetchValueObjectsWithIdFromBuilder(
			$this->select('contribution_types.*')
				->join('book_authors', 'book_authors.contribution_id', '=', 'contribution_types.id')
				->where('book_authors.book_id', $book->id)
				->where('book_authors.author_id', $author->id)
		);
	}
}
