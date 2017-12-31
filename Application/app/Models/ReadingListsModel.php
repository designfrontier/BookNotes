<?php

namespace App\Models;

use App\Data\Book;
use App\Data\ReadingList;
use App\Data\ValueObjectWithId;
use App\Models\BooksModel;

class ReadingListsModel extends ValueObjectWithIdAndNameModel
{
	protected $table = 'reading_lists';

	protected $valueObjectClassName = ReadingList::class;

	protected function populateValueObjectWithId(ValueObjectWithId $readingListToPopulate): ValueObjectWithId
	{
		// @todo Consider Moving this Functionality to Entity Object Itself
		if ($readingListToPopulate instanceof ReadingList) { // Validate Passed Book Parameter
			$readingListToPopulate->addBooks((new BooksModel())->fetchReadingListBooks($readingListToPopulate));
		} // End of Validate Passed Book Parameter
		return $readingListToPopulate;
	}

	public function fetchBookReadingLists(Book $book): array
	{
		return $this->fetchValueObjectsWithIdFromBuilder(
			$this->select('reading_lists.*')
				->join('books_reading_lists', 'books_reading_lists.list_id', '=', 'reading_lists.id')
				->where('books_reading_lists.book_id', $book->id)
				->orderBy('books_reading_lists.order', 'asc')
		);
	}
}
