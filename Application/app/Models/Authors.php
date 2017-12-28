<?php

namespace App\Models;

use App\Data\Author;
use App\Data\Book;
use App\Data\EntityObject;
use App\Models\Books as BookModel;
use Illuminate\Database\Eloquent\Collection;

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
		$return = array();
		$retrieved = $this->select('authors.*')
			->join('book_authors', 'book_authors.author_id', '=', 'authors.id')
			->where('book_authors.book_id', $book->id)
			->get();
		if ($retrieved instanceof Collection) { // Check for DB Results
			foreach ($retrieved as $currentAuthor) { // Loop through DB Results
				$currentAuthorObject = Author::getFromArray($currentAuthor->toArray());
				if ($currentAuthorObject instanceof Author) { // Check Object Creation
					$return[] = $currentAuthorObject;
				} // End of Check Object Creation
			} // End of Loop through DB Results
		} // End of Check for DB Results
		return $return;
	}
}
