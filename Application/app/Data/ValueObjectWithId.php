<?php

namespace App\Data;

use App\Exceptions\InvalidParameterException;
use App\Exceptions\MissingRequiredParameterException;

abstract class ValueObjectWithId extends ValueObject
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = array();
		if (isset($rawData['id']) && !empty($rawData['id'])) { // Check for Passed ID Parameter
			if (false !== ($validatedId = static::validateNonZeroPositiveInteger($rawData['id']))) { // Check ID Validation
				$return['id'] = $validatedId;
			} else { // Middle of Check ID Validation
				throw new InvalidParameterException(sprintf('Invalid ID parameter value: %s', print_r($rawData['id'], true)));
			} // End of Check ID Validation
		} else { // Middle of Check for Passed ID Parameter
			throw new MissingRequiredParameterException('Missing required ID parameter');
		} // End of Check for Passed ID Parameter
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array('id' => null);
	}
}
