<?php

namespace App\Views;

use App\Data\Author;
use App\Data\ValueObjectWithId;

class AuthorFormatter extends EntityFormatter
{
	protected $valueObjectClassName = Author::class;

	protected $riverSubItemHeader = 'Author(s)';

	public function formatAsRiverMainItem(ValueObjectWithId $valueObjectWithId): string
	{

	}

	public function formatAsRiverSubItem(ValueObjectWithId $valueObjectWithId): string
	{
		return '<li class="author">Insert Author (Sub Item) Here</li>';
	}
}
