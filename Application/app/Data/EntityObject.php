<?php

namespace App\Data;

use App\Exceptions\InvalidAttribute;
use App\Exceptions\RestrictedAttributeException;

abstract class EntityObject extends ValueObjectWithId
{
	protected $restrictedAttributes;

	protected function __construct(array $rawDataObjectDetails)
	{
		parent::__construct($rawDataObjectDetails);
		$this->restrictedAttributes = $this->getRestrictedAttributesArray();
	}

	protected function getRestrictedAttributesArray()
	{
		return array('id');
	}

	public function __set(string $attributeName, $attributeValue)
	{
		if (!in_array($needle, $this->restrictedAttributes)) { // Check if Attribute is Restricted
			if (method_exists($this, 'set_'.$attributeName)) { // Check For Attribute Setter or Existence
				$return = $this->{'set_'.$attributeName}($attributeValue);
			} elseif (isset($this->data[$attributeName])) { // Middle of Check For Attribute Setter or Existence
				$return = $this->data[$attributeName] = $attributeValue;
			} else { // Middle of Check For Attribute Setter or Existence
				throw new InvalidAttribute(sprintf('The %s->%s attribute does not exist', get_called_class(), $attributeName));
			} // End of Check For Attribute Setter or Existence
		} else { // Middle of Check if Attribute is Restricted
			throw new RestrictedAttributeException(sprintf('You cannot set the %s->%s attribute', get_called_class(), $attributeName));
		} // End of Check if Attribute is Restricted
		return $return;
	}

	protected function addArrayOfEntitiesToDataAttribute(array $arrayOfEntities, string $dataAttributeName, string $entityClassName, bool $uniqueEntitiesOnly = true): int
	{
		$return = 0;
		if (isset($this->data[$dataAttributeName]) && is_array($this->data[$dataAttributeName])) { // Validate Data Attribute Is Array
			foreach ($arrayOfEntities as $currentEntity) { // Loop through Array of Entities
			if ($currentEntity instanceof $entityClassName) { // Validate Current Entity is Correct Data Type
				if ($uniqueEntitiesOnly) { // Check Whether We Want Unique Entities Only
					if (!in_array($currentEntity, $this->data[$dataAttributeName])) { // Verify that Current Entity is Unique in Data Attribute Array
						$this->data[$dataAttributeName][] = $currentEntity;
						$return++;
					} // End of Verify that Current Entity is Unique in Data Attribute Array
				} else { // Middle of Check Whether We Want Unique Entities Only
					$this->data[$dataAttributeName][] = $currentEntity;
					$return++;
				} // End of Check Whether We Want Unique Entities Only
			} // End of Validate Current Entity is Correct Data Type
		} // End of Loop through Array of Entities
		} else { // Middle of Validate Data Attribute Is Array
			throw new InvalidAttribute(sprintf('%s->data[%s] must be an array to be populated with %s objects', get_called_class(), $dataAttributeName, $entityClassName));
		} // End of Validate Data Attribute Is Array
		return $return;
	}
}
