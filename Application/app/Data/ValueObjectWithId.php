<?php

namespace App\Data;

use App\Exceptions\InvalidParameterException;

abstract class ValueObjectWithId extends ValueObject
{
	protected static function validateFactoryInput(array $rawData)
	{
		$return = array();
		if (isset($rawData['id']) && !empty($rawData['id'])) { // Check for Passed ID Parameter
			$validatedId = static::validateNonZeroPositiveInteger($rawData['id']);
			if (false !== $validatedId) { // Check ID Validation
				$return['id'] = $validatedId;
			} else { // Middle of Check ID Validation
				throw new InvalidParameterException(sprintf('Invalid ID parameter value: %s', print_r($rawData['id'], true)));
			} // End of Check ID Validation
		} // End of Check for Passed ID Parameter
		return $return;
	}

	protected function initializeDataAttribute()
	{
		return array('id' => null);
	}
}
