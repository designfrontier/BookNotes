<?php

namespace App\Traits;

trait Validator
{
	protected static function validateNonZeroPositiveInteger(int $valueToValidate)
	{
		$return = false;
		if ($valueToValidate > 0) { // Validate Passed Paramter
			$return = $valueToValidate;
		} // End of Validate Passed Paramter
		return $return;
	}

	protected static function validateDateTimeString(string $valueToValidate)
	{
		$return = false;
		if (($dateTimeObject = \date_create($valueToValidate)) instanceof \DateTime) { // Validate Date Time String Format
			$return = $dateTimeObject;
		} // End of Validate Date Time String Format
		return $return;
	}
}
