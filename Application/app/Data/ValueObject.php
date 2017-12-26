<?php

namespace App\Data;

use App\Exceptions\InvalidAttribute;
use App\Exceptions\RestrictedAttributeException;
use App\Traits\Validator;

abstract class ValueObject
{
	use Validator;

	public static function getFromArray(array $rawData)
	{
		$return = false;
		if ($parsedData = static::validateFactoryInput($rawData)) { // Validate Passed Raw Data Parameter
			$return = static::__construct($parsedData);
		} // End of Validate Passed Raw Data Parameter
		return $return;
	}
	
	abstract protected static function validateFactoryInput(array $rawData);

	protected $data;

	protected function __construct(array $rawDataObjectDetails)
	{
		$this->data = $this->initializeDataAttribute();
		$this->parseRawData($rawDataObjectDetails);
	}

	abstract protected function initializeDataAttribute();

	protected function parseRawData(array $rawDataObjectDetails)
	{
		foreach (array_keys($this->data) as $currentAttributeName) { // Loop through Value Object's Data Fields
			if (isset($rawDataObjectDetails->{$currentAttributeName})) { // Check for Data Field Value in Raw Data
				if (method_exists($this, 'set_' . $currentAttributeName)) { // Check for Data Field Setter Method
					$this->{'set_' . $currentAttributeName}($rawDataObjectDetails->{$currentAttributeName});
				} else { // Middle of Check for Data Field Setter Method
					$this->data[$currentAttributeName] = $rawDataObjectDetails->{$currentAttributeName};
				} // End of Check for Data Field Setter Method
			} // End of Check for Data Field Value in Raw Data
		} // End of Loop through Value Object's Data Fields
	}

	public function __get(string $attributeName)
	{
		if (method_exists($this, 'get_' . $attributeName)) { // Check for Attribute Getter and Existence
			$return = $this->{'get_'.$attributeName}();
		} elseif (isset($this->data[$attributeName])) { // Middle of Check for Attribute Getter and Existence
			$return = $this->data[$attributeName];
		} else { // Middle of Check for Attribute Getter and Existence
			throw new InvalidAttribute(sprintf('The %s->%s attribute does not exist', get_called_class(), $attributeName));
		} // End of Check for Attribute Getter and Existence
		return $return;
	}

	public function __set(string $attributeName, $attributeValue)
	{
		throw new RestrictedAttributeException(sprintf('You cannot set any attributes on %1$s (including: %1$s->%2$s)', get_called_class(), $attributeName));
	}

	abstract public function __toString();

	public function toString()
	{
		return $this->__toString();
	}

	public function toJsonString($prettyPrint = false)
	{
		$prettyPrint = (bool) $prettyPrint;
		return json_encode($this->toArray(), $prettyPrint);
	}

	public function toArray()
	{
		return $this->data;
	}
}
