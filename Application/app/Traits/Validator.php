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
}
