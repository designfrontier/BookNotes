<?php

namespace App\Http\Controllers;

use App\Data\Book;
use App\Models\Books as BooksModel;

class Books extends EntityController
{
	protected $entityClassName = Book::class;

	protected $entityModelName = BooksModel::class;
}
