<?php

namespace App\Models;

use App\Data\Book;
use App\Data\Note;
use App\Exceptions\InvalidUsage;

class NotesModel extends EntityModel
{
	protected $table = 'notes';

	protected $valueObjectClassName = Note::class;

	public function fetchAll(bool $constructFullyPopulatedValueObject = false): ?array
	{
		throw new InvalidUsage('Should not fetch all notes (must fetch by book or note ID).');
	}

	public function fetchBookNotes(Book $book): array
	{
		return $this->fetchValueObjectsWithIdFromBuilder($this->select('notes.*')->where('notes.book_id', $book->id));
	}
}