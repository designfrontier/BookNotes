<?php

namespace App\Data;

use App\Exceptions\MissingRequiredParameterException;

abstract class ValueObjectWithIdAndName extends ValueObjectWithId
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = parent::validateFactoryInput($rawData);
		if ((false !== $return) && is_array($return)) { // Check if Raw Data Passed Validation in Parent
			if (isset($rawData['name']) && !empty($rawData['name'])) { // Validate Required Name Parameter
				$return['name'] = (string) $rawData['name'];
			} else { // Middle of Validate Required Name Parameter
				throw new MissingRequiredParameterException('Missing required name parameter');
			} // End of Validate Required Name Parameter
		} // End of Check if Raw Data Passed Validation in Parent
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array_merge(parent::initializeDataAttribute(), array('name' => null));
	}

	public function __toString(): string
	{
		return $this->data['name'];
	}
}
