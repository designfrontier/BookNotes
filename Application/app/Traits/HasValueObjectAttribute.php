<?php

namespace App\Traits;

use App\Data\ValueObject;
use App\Exceptions\MissingRequiredAttributeException;

trait HasValueObjectAttribute
{
	protected $valueObjectClassType = ValueObject::class;

	protected $valueObjectClassName;

	protected function validateValueObjectClassTypeAttribute(): void
	{
		if (!empty($this->valueObjectClassType) && is_string($this->valueObjectClassType)) { // Check for (Required) Value Object Class Type
			if (class_exists($this->valueObjectClassType)) { // Verify Value Object Class Type Exists
				if (!is_subclass_of($this->valueObjectClassType, ValueObject::class)) { // Verify Value Object Class Type is ValueObject
					throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassType class must inherit from %s (%s given)', get_called_class(), ValueObject::class, $this->valueObjectClassType));
				} // End of Verify Value Object Class Type is ValueObject
			} else { // Middle of Verify Value Object Class Type Exists
				throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassType must be a class that exists (%s given)', get_called_class(), $this->valueObjectClassType));
			} // End of Verify Value Object Class Type Exists
		} else { // Middle of Check for (Required) Value Object Class Type
			throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassType cannot be empty', get_called_class()));
		} // End of Check for (Required) Value Object Class Type
	}

	protected function validateValueObjectClassNameAttribute(): void
	{
		if (!empty($this->valueObjectClassName) && is_string($this->valueObjectClassName)) { // Check for (Required) Value Object Class Name
			if (class_exists($this->valueObjectClassName)) { // Verify Value Object Class Exists
				if (!is_subclass_of($this->valueObjectClassName, $this->valueObjectClassType)) { // Verify Value Object Class is ValueObject
					throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName class must inherit from %s (%s given)', get_called_class(), $this->valueObjectClassType, $this->valueObjectClassName));
				} // End of Verify Value Object Class is ValueObject
			} else { // Middle of Verify Value Object Class Exists
				throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName must be a class that exists (%s given)', get_called_class(), $this->valueObjectClassName));
			} // End of Verify Value Object Class Exists
		} else { // Middle of Check for (Required) Value Object Class Name
			throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName cannot be empty', get_called_class()));
		} // End of Check for (Required) Value Object Class Name
	}

	protected function validateValueObjectClassAttributes(): void
	{
		$this->validateValueObjectClassTypeAttribute();
		$this->validateValueObjectClassNameAttribute();
	}

	public function getValueObjectClassName(): string
	{
		return $this->valueObjectClassName;
	}

	public function getValueObjectClassType(): string
	{
		return $this->valueObjectClassType;
	}
}
