<?php

namespace App\Data;

use App\Exceptions\InvalidAttribute;
use App\Exceptions\RestrictedAttributeException;

abstract class EntityObject extends ValueObjectWithId
{
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
}
