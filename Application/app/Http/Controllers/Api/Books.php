<?php

namespace App\Http\Controllers\Api;

use App\Data\Book;
use App\Models\Books as BooksModel;

class Books extends EntityController
{
	protected $entityClassName = Book::class;

	protected $entityModelName = BooksModel::class;
}
