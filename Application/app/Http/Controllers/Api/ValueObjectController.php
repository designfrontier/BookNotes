<?php

namespace App\Http\Controllers\Api;

use App\Data\ValueObject;
use App\Traits\ValueObjectControllerClassAndModelAttributes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class ValueObjectController extends BaseController
{
	use ValueObjectControllerClassAndModelAttributes;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->validateValueObjectClassAndModelAttributes();
	}

	protected function checkRetrieveFullyPopulatedValueObject(): bool
	{
		switch (strtolower((string) \Request::get('full', false))) { // Check the Input

			case '1':
			case 'true':
			case 'yes':
				$return = true;
				break;

			case '':
			case '0':
			case 'false':
			case 'no':
			default:
				$return = false;
				break;

		} // End of Check the Input
		return $return;
	}

	protected function convertArrayOfValueObjectsToArrayOfArrays(array $arrayOfValueObjects): array
	{
		$return = array();
		foreach ($arrayOfValueObjects as $currentValueObject) { // Loop through Passed Array
			if ($currentValueObject instanceof ValueObject) { // Validate Current Value Object is What it Should Be
				$return[] = $currentValueObject->toArray();
			} // End of Validate Current Value Object is What it Should Be
		} // End of Loop through Passed Array
		return $return;
	}

	protected function notFoundResponse(string $fullyNamespacedResourceName = null): JsonResponse
	{
		$resourceClassName = (empty($fullyNamespacedResourceName) ? $this->valueObjectClassName : $fullyNamespacedResourceName);
		return $this->errorResponse(sprintf('%s not found', $this->getClassNameWithoutNamespace($resourceClassName)), 404);
	}
}
