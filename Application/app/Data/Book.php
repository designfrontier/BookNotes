<?php

namespace App\Data;

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

			// @todo Add Validation of Published Date
			// @todo Add Validation of Notes
			// @todo Add Validation of Category

		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array(
			'title'             => null,
			'type'              => null,
			'publishedDate'     => null,
			'notes'             => array(),
			'categories'        => array()
		));
	}

	protected function getRestrictedAttributesArray()
	{
		return array_merge(parent::getRestrictedAttributesArray(), array('notes', 'categories'));
	}

	public function __toString()
	{
		return $this->data['title'];
	}
}
