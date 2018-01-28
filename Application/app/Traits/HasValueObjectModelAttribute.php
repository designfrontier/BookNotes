<?php

namespace App\Traits;

use App\Exceptions\MissingRequiredAttributeException;

trait HasValueObjectModelAttribute
{
	protected $valueObjectModelType = ValueObjectModel::class;

	protected $valueObjectModelName;

	protected function validateValueObjectModelTypeAttribute(): void
	{
		if (!empty($this->valueObjectModelType) && is_string($this->valueObjectModelType)) { // Check for (Required) Value Object Model Type
			if (class_exists($this->valueObjectModelType)) { // Verify Value Object Model Type Exists
				if (!is_subclass_of($this->valueObjectModelType, ValueObjectModel::class)) { // Verify Value Object Model Type is ValueObject
					throw new MissingRequiredAttributeException(sprintf('%s->valueObjectModelType class must inherit from %s (%s given)', get_called_class(), ValueObjectModel::class, $this->valueObjectModelType));
				} // End of Verify Value Object Model Type is ValueObject
			} else { // Middle of Verify Value Object Model Type Exists
				throw new MissingRequiredAttributeException(sprintf('%s->valueObjectModelType must be a class that exists (%s given)', get_called_class(), $this->valueObjectModelType));
			} // End of Verify Value Object Model Type Exists
		} else { // Middle of Check for (Required) Value Object Model Type
			throw new MissingRequiredAttributeException(sprintf('%s->valueObjectModelType cannot be empty', get_called_class()));
		} // End of Check for (Required) Value Object Model Type
	}

	protected function validateValueObjectModelNameAttribute(): void
	{
		if (!empty($this->valueObjectModelName) && is_string($this->valueObjectModelName)) { // Check for (Required) Value Object Model Name
			if (class_exists($this->valueObjectModelName)) { // Verify Value Object Model Exists
				if (!is_subclass_of($this->valueObjectModelName, $this->valueObjectModelType)) { // Verify Value Object Model is ValueObjectModel
					throw new MissingRequiredAttributeException(sprintf('%s->valueObjectModelName class must inherit from %s (%s given)', get_called_class(), $this->valueObjectModelType, $this->valueObjectModelName));
				} // End of Verify Value Object Model is ValueObjectModel
			} else { // Middle of Verify Value Object Model Exists
				throw new MissingRequiredAttributeException(sprintf('%s->valueObjectModelName must be a class that exists (%s given)', get_called_class(), $this->valueObjectModelName));
			} // End of Verify Value Object Model Exists
		} else { // Middle of Check for (Required) Value Object Model Name
			throw new MissingRequiredAttributeException(sprintf('%s->valueObjectModelName cannot be empty', get_called_class()));
		} // End of Check for (Required) Value Object Model Name
	}

	protected function validateValueObjectModelAttributes(): void
	{
		$this->validateValueObjectModelTypeAttribute();
		$this->validateValueObjectModelNameAttribute();
	}

	public function getValueObjectModelName(): string
	{
		return $this->valueObjectModelName;
	}

	public function getValueObjectModelType(): string
	{
		return $this->valueObjectModelType;
	}
}
