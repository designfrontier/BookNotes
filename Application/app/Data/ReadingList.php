<?php

namespace App\Data;

class ReadingList extends ValueObjectWithIdAndName
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = parent::validateFactoryInput($rawData);
		if ((false !== $return) && is_array($return)) { // Check if Raw Data Passed Validation in Parent
	
			// @todo Add Validation of List Description
	
		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'description'   => null,
			'books'         => array()
		));
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
