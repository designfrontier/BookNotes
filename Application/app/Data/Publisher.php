<?php

namespace App\Data;

class Publisher extends ValueObjectWithIdAndName
{
	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array('books' => array()));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('books'));
	}

	public function addBooks(array $booksToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($booksToAdd, 'books', Book::class);
	}
}
