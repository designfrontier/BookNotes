<?php

namespace App\Data;

class ReadingList extends EntityObject
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = parent::validateFactoryInput($rawData);
		if ((false !== $return) && is_array($return)) { // Check if Raw Data Passed Validation in Parent
			if (isset($rawData['name']) && !empty($rawData['name'])) { // Validate Required Last Name Parameter
				$return['name'] = (string) $rawData['name'];
			} else { // Middle of Validate Required Last Name Parameter
				throw new MissingRequiredParameterException('Missing required name parameter');
			} // End of Validate Required Last Name Parameter
	
			// @todo Add Validation of List Description
	
		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'name'          => null,
			'description'   => null,
			'books'         => array()
		));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('books'));
	}
}
