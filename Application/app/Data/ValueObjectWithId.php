<?php

namespace App\Data;

use App\Exceptions\InvalidAttribute;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\MissingRequiredParameterException;

abstract class ValueObjectWithId extends ValueObject
{
	protected $restrictedAttributes;

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
			\Log::debug(sprintf('%s::%s() - Missing required ID parameter', get_called_class(), __FUNCTION__), array('Passed Data' => $rawData));
			throw new MissingRequiredParameterException('Missing required ID parameter');
		} // End of Check for Passed ID Parameter
		return $return;
	}

	protected function __construct(array $rawDataObjectDetails)
	{
		parent::__construct($rawDataObjectDetails);
		$this->restrictedAttributes = $this->getRestrictedAttributesArray();
	}

	protected function initializeDataAttribute()
	{
		return array('id' => null);
	}

	protected function getRestrictedAttributesArray()
	{
		return array('id');
	}

	protected function addArrayOfValueObjectsToDataAttribute(array $arrayOfValueObjects, string $dataAttributeName, string $valueObjectClassName, bool $uniqueValueObjectsOnly = true): int
	{
		$return = 0;
		if (isset($this->data[$dataAttributeName]) && is_array($this->data[$dataAttributeName])) { // Validate Data Attribute Is Array
			foreach ($arrayOfValueObjects as $currentValueObject) { // Loop through Array of Value Objects
				if ($currentValueObject instanceof $valueObjectClassName) { // Validate Current Entity is Correct Data Type
					if ($uniqueValueObjectsOnly) { // Check Whether We Want Unique Value Objects Only
						if (!in_array($currentValueObject, $this->data[$dataAttributeName])) { // Verify that Current Entity is Unique in Data Attribute Array
							$this->data[$dataAttributeName][] = $currentValueObject;
							$return++;
						} // End of Verify that Current Entity is Unique in Data Attribute Array
					} else { // Middle of Check Whether We Want Unique Value Objects Only
						$this->data[$dataAttributeName][] = $currentValueObject;
						$return++;
					} // End of Check Whether We Want Unique Value Objects Only
				} // End of Validate Current Entity is Correct Data Type
			} // End of Loop through Array of Value Objects
		} else { // Middle of Validate Data Attribute Is Array
			throw new InvalidAttribute(sprintf('%s->data[%s] must be an array to be populated with %s objects', get_called_class(), $dataAttributeName, $valueObjectClassName));
		} // End of Validate Data Attribute Is Array
		return $return;
	}
}
