<?php

namespace App\Http\Controllers\Api;

use App\Data\ValueObject;
use App\Exceptions\MissingRequiredAttributeException;
use App\Models\ValueObjectModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class ValueObjectController extends BaseController
{
	protected $valueObjectClassType = ValueObject::class;

	protected $valueObjectClassName;

	protected $valueObjectModelType = ValueObjectModel::class;

	protected $valueObjectModelName;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->validateValueObjectClassTypeAttribute();
		$this->validateValueObjectClassNameAttribute();
		$this->validateValueObjectModelTypeAttribute();
		$this->validateValueObjectModelNameAttribute();
	}

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

	public function getValueObjectClassName(): string
	{
		return $this->valueObjectClassName;
	}

	public function getValueObjectClassType(): string
	{
		return $this->valueObjectClassType;
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
