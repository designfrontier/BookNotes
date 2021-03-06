<?php

namespace App\Data;

use App\Exceptions\MissingRequiredParameterException;

class Author extends EntityObject
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = parent::validateFactoryInput($rawData);
		if ((false !== $return) && is_array($return)) { // Check if Raw Data Passed Validation in Parent
			if (isset($rawData['first_name']) && !empty($rawData['first_name'])) { // Validate First Name Parameter
				$return['firstName'] = (string) $rawData['first_name'];
			} // End of Validate First Name Parameter
			if (isset($rawData['middle_name']) && !empty($rawData['middle_name'])) { // Validate Middle Name Parameter
				$return['middleName'] = (string) $rawData['middle_name'];
			} // End of Validate Middle Name Parameter
			if (isset($rawData['last_name']) && !empty($rawData['last_name'])) { // Validate Required Last Name Parameter
				$return['lastName'] = (string) $rawData['last_name'];
			} else { // Middle of Validate Required Last Name Parameter
				\Log::debug(sprintf('%s::%s() - Missing required last name parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
				throw new MissingRequiredParameterException('Missing required last name parameter');
			} // End of Validate Required Last Name Parameter
		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'firstName'         => null,
			'middleName'        => null,
			'lastName'          => null,
			'parentAuthorId'    => null,
			'books'             => array(),
			'contributionTypes' => array()
		));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('books', 'contributionTypes', 'pseudonyms'));
	}

	public function __toString(): string
	{
		$return  = (!empty($this->data['firstName']) ? $this->data['firstName'] . ' ' : null);
		$return .= (!empty($this->data['middleName']) ? $this->data['middleName'] . ' ' : null);
		$return .= $this->data['lastName'];
		return  $return;
	}

	public function addBooks(array $booksToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($booksToAdd, 'books', Book::class);
	}

	public function addContributionTypes(array $contributionTypesToAdd): int
	{
		return $this->addArrayOfValueObjectsToDataAttribute($contributionTypesToAdd, 'contributionTypes', ContributionType::class);
	}
}
