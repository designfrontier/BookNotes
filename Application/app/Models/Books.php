<?php

namespace App\Models;

use App\Data\Book;
use App\Data\EntityObject;

class Books extends EntityModel
{
	protected $entityClassName = Book::class;

	protected function populateEntity(Book $bookToPopulate)
	{
		return $bookToPopulate;
	}
}
