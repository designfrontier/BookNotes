<?php

namespace App\Models;

use App\Data\ValueObjectWithId;
use App\Exceptions\MissingRequiredAttributeException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

abstract class ValueObjectWithIdModel extends ValueObjectModel
{
	protected $valueObjectClassType = ValueObjectWithId::class;

	protected $valueObjectClassName;

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->validateValueObjectClassTypeAttribute();
		$this->validateValueObjectClassNameAttribute();
	}

	protected function validateValueObjectClassTypeAttribute(): void
	{
		if (!empty($this->valueObjectClassType) && is_string($this->valueObjectClassType)) { // Check for (Required) Value Object Class Type
			if (class_exists($this->valueObjectClassType)) { // Verify Value Object Class Type Exists
				if (!is_subclass_of($this->valueObjectClassType, ValueObjectWithId::class)) { // Verify Value Object Class is Value Object With ID
					throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassType class must inherit from %s (%s given)', get_called_class(), ValueObjectWithId::class, $this->valueObjectClassType));
				} // End of Verify Value Object Class is Value Object With ID
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
				if (!is_subclass_of($this->valueObjectClassName, $this->valueObjectClassType)) { // Verify Value Object Class is Value Object With ID
					throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName class must inherit from %s (%s given)', get_called_class(), $this->valueObjectClassType, $this->valueObjectClassName));
				} // End of Verify Value Object Class is Value Object With ID
			} else { // Middle of Verify Value Object Class Exists
				throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName must be a class that exists (%s given)', get_called_class(), $this->valueObjectClassName));
			} // End of Verify Value Object Class Exists
		} else { // Middle of Check for (Required) Value Object Class Name
			throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName cannot be empty', get_called_class()));
		} // End of Check for (Required) Value Object Class Name
	}

	protected function fetchValueObjectsWithIdFromBuilder(Builder $builder, string $valueObjectClassName): array
	{
		$return = array();
		$retrieved = $builder->get();
		if ($retrieved instanceof Collection) { // Check for DB Results
			foreach ($retrieved as $currentValueObjectResult) { // Loop through DB Results
				$currentValueObject = $valueObjectClassName::getFromArray($currentValueObjectResult->toArray());
				if ($currentValueObject instanceof $valueObjectClassName) { // Check Object Creation
					$return[] = $currentValueObject;
				} // End of Check Object Creation
			} // End of Loop through DB Results
		} // End of Check for DB Results
		return $return;
	}

	protected function populateValueObjectWithId(ValueObjectWithId $valueObjectWithIdToPopulate): ValueObjectWithId
	{
		// @todo Consider Moving this Functionality to Value Object Itself
		return $valueObjectWithIdToPopulate;
	}

	public function fetchAll(bool $constructFullyPopulatedValueObject = false)
	{
		$return = false;
		$databaseResult = $this->all();
		if ($databaseResult instanceof Collection) { // Check Database Retrieval
			$return = array();
			foreach ($databaseResult as $currentResult) { // Loop through Database Results
				$currentValueObject = $this->valueObjectClassName::getFromArray($currentResult->toArray());
				if ($currentValueObject instanceof $this->valueObjectClassName) { // Check Data Object Creation
					$return[] = ($constructFullyPopulatedValueObject ? $this->populateValueObjectWithId($currentValueObject) : $currentValueObject);
				} else { // Middle of Check Data Object Creation
					\Log::debug(sprintf('%s->%s(): Failed to make %s object', get_called_class(), __FUNCTION__, $this->valueObjectClassName), $currentResult->toArray());
				} // End of Check Data Object Creation
			} // End of Loop through Database Results
		} // End of Check Database Retrieval
		return $return;
	}

	public function fetchById(int $valueObjectId, bool $constructFullyPopulatedValueObject = false)
	{
		$return = false;
		$databaseResult = $this->find($valueObjectId);
		if ($databaseResult instanceof static) { // Check Database Retrieval
			$valueObject = $this->valueObjectClassName::getFromArray($databaseResult->toArray());
			if ($valueObject instanceof $this->valueObjectClassName) { // Check Data Object Creation
				$return = ($constructFullyPopulatedValueObject ? $this->populateValueObjectWithId($valueObject) : $valueObject);
					$return = $valueObject;
				} else { // Middle of Check Data Object Creation
					\Log::debug(sprintf('%s->%s(): Failed to make %s object', get_called_class(), __FUNCTION__, $this->valueObjectClassName), $databaseResult->toArray());
				} // End of Check Data Object Creation
		} // End of Check Database Retrieval
		return $return;
	}

	public function getValueObjectClassType(): string
	{
		return $this->valueObjectClassType;
	}

	public function getValueObjectClassName(): string
	{
		return $this->valueObjectClassName;
	}
}
