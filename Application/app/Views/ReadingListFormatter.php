<?php

namespace App\Views;

use App\Data\ReadingList;
use App\Data\ValueObjectWithId;

class ReadingListFormatter extends ValueObjectWithIdAndNameFormatter
{
	protected $valueObjectClassName = ReadingList::class;

	protected $riverSubItemHeader = 'Reading List(s)';

	public function formatAsRiverMainItem(ValueObjectWithId $valueObjectWithId): ?string
	{

	}

	public function formatAsRiverSubItem(ValueObjectWithId $valueObjectWithId): ?string
	{
		return '<li class="reading-list">Insert Reading List Here</li>';
	}
}
