<?php

namespace App\Data;

use App\Exceptions\InvalidParameterException;
use App\Exceptions\MissingRequiredParameterException;
use App\Models\PublishersModel;

class Book extends EntityObject
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = parent::validateFactoryInput($rawData);
		if ((false !== $return) && is_array($return)) { // Check if Raw Data Passed Validation in Parent
			if (isset($rawData['title']) && !empty($rawData['title'])) { // Validate Required Title Parameter
				$return['title'] = (string) $rawData['title'];
			} else { // Middle of Validate Required Title Parameter
				\Log::debug(sprintf('%s::%s() - Missing required title parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
				throw new MissingRequiredParameterException('Missing required title parameter');
			} // End of Validate Required Title Parameter
			if (isset($rawData['type']) && !empty($rawData['type'])) { // Validate Required Type Parameter
				$return['type'] = (string) $rawData['type'];
			} else { // Middle of Validate Required Type Parameter
				\Log::debug(sprintf('%s::%s() - Missing required type parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
				throw new MissingRequiredParameterException('Missing required type parameter');
			} // End of Validate Required Type Parameter
			if (isset($rawData['published_date']) && !empty($rawData['published_date'])) { // Validate Published Date Parameter
				if ($publishedDate = static::validateDateTimeString($rawData['published_date'])) { // Verify Published Date Format
					$return['publishedDate'] = $publishedDate;
				} // End of Verify Published Date Format
			} // End of Validate Published Date Parameter
			if (isset($rawData['publisher_id']) && !empty($rawData['publisher_id'])) { // Check for Passed Publisher (ID) Parameter
				if (false !== ($validatedId = static::validateNonZeroPositiveInteger($rawData['publisher_id']))) { // Check ID Validation
					$return['publisher_id'] = $validatedId;
				} else { // Middle of Check ID Validation
					throw new InvalidParameterException(sprintf('Invalid Publisher (ID) parameter value: %s', print_r($rawData['publisher_id'], true)));
				} // End of Check ID Validation
			} else { // Middle of Check for Passed Publisher (ID) Parameter
				\Log::debug(sprintf('%s::%s() - Missing required Publisher (ID) parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
				throw new MissingRequiredParameterException('Missing required Publisher (ID) parameter');
			} // End of Check for Passed Publisher (ID) Parameter
		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function __construct(array $rawDataObjectDetails)
	{
		parent::__construct($rawDataObjectDetails);
		$this->set_publisher($this->retrievePublisher($rawDataObjectDetails['publisher_id']));
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'title'             => null,
			'type'              => null,
			'publishedDate'     => null,
			'possessionStatus'  => null,
			'edition'           => null,
			'publisher'         => null,
			'authors'           => array(),
			'categories'        => array(),
			'notes'             => array(),
			'readingLists'      => array()
		));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('authors', 'categories', 'notes', 'publisher'));
	}

	public function __toString(): string
	{
		return $this->data['title'];
	}

	protected function retrievePublisher(int $publisherId): Publisher
	{
		$return = (new PublishersModel())->fetchById($publisherId);
		if (!$return instanceof Publisher) { // Verify Publisher was Retrieved
			\Log::debug(sprintf('%s::%s() - Publisher not found', get_called_class(), __FUNCTION__), array('Book Data' => $this->toArray(), 'Publisher ID' => $publisherId));
			throw new InvalidParameterException('Book publisher not found');
		} // End of Verify Publisher was Retrieved
		return $return;
	}

	public function addCategories(array $categoriesToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($categoriesToAdd, 'categories', Category::class);
	}

	public function addAuthors(array $authorsToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($authorsToAdd, 'authors', Author::class);
	}

	public function addNotes(array $notesToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($notesToAdd, 'notes', Note::class);
	}

	public function addReadingLists(array $readingListsToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($readingListsToAdd, 'readingLists', ReadingList::class);
	}

	public function set_publisher(Publisher $publisher): Publisher
	{
		return $this->data['publisher'] = $publisher;
	}
}
