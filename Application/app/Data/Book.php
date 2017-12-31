<?php

namespace App\Data;

use App\Data\Author;
use App\Data\Category;
use App\Data\Note;
use App\Exceptions\MissingRequiredParameterException;

class Book extends EntityObject
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = parent::validateFactoryInput($rawData);
		if ((false !== $return) && is_array($return)) { // Check if Raw Data Passed Validation in Parent
			if (isset($rawData['title']) && !empty($rawData['title'])) { // Validate Required Title Parameter
				$return['title'] = (string) $rawData['title'];
			} else { // Middle of Validate Required Title Parameter
				throw new MissingRequiredParameterException('Missing required title parameter');
			} // End of Validate Required Title Parameter
			if (isset($rawData['type']) && !empty($rawData['type'])) { // Validate Required Type Parameter
				$return['type'] = (string) $rawData['type'];
			} else { // Middle of Validate Required Type Parameter
				throw new MissingRequiredParameterException('Missing required type parameter');
			} // End of Validate Required Type Parameter
			if (isset($rawData['published_date']) && !empty($rawData['published_date'])) { // Validate Published Date Parameter
				if ($publishedDate = static::validateDateTimeString($rawData['published_date'])) { // Verify Published Date Format
					$return['publishedDate'] = $publishedDate;
				} // End of Verify Published Date Format
			} // End of Validate Published Date Parameter
		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'title'             => null,
			'type'              => null,
			'publishedDate'     => null,
			'authors'           => array(),
			'categories'        => array(),
			'notes'             => array()
		));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('authors', 'categories', 'notes'));
	}

	public function __toString(): string
	{
		return $this->data['title'];
	}

	public function addCategories(array $categoriesToAdd): int
	{
		return $this->addArrayOfEntitiesToDataAttribute($categoriesToAdd, 'categories', Category::class);
	}

	public function addAuthors(array $authorsToAdd): int
	{
		return $this->addArrayOfEntitiesToDataAttribute($authorsToAdd, 'authors', Author::class);
	}

	public function addNotes(array $notesToAdd): int
	{
		return $this->addArrayOfEntitiesToDataAttribute($notesToAdd, 'notes', Note::class);
	}
}
