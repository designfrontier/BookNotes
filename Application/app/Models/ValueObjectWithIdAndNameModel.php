<?php

namespace App\Models;

use App\Data\ValueObjectWithIdAndName;
use App\Exceptions\MissingRequiredAttributeException;
use Illuminate\Database\Eloquent\Collection;

abstract class ValueObjectWithIdAndNameModel extends BaseModel
{
	protected $valueObjectClassName;

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		if (!empty($this->valueObjectClassName) && is_string($this->valueObjectClassName)) { // Check for (Required) Value Object Class Name
			if (class_exists($this->valueObjectClassName)) { // Verify Value Object Class Exists
				if (!is_subclass_of($this->valueObjectClassName, ValueObjectWithIdAndName::class)) { // Verify Value Object Class is ValueObjectWithIdAndName
					throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName class must inherit from %s (%s given)', get_called_class(), ValueObjectWithIdAndName::class, $this->valueObjectClassName));
				} // End of Verify Value Object Class is ValueObjectWithIdAndName
			} else { // Middle of Verify Value Object Class Exists
				throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName must be a class that exists (%s given)', get_called_class(), $this->valueObjectClassName));
			} // End of Verify Value Object Class Exists
		} else { // Middle of Check for (Required) Value Object Class Name
			throw new MissingRequiredAttributeException(sprintf('%s->valueObjectClassName cannot be empty', get_called_class()));
		} // End of Check for (Required) Value Object Class Name
	}

	public function fetchAll()
	{
		$return = false;
		$databaseResult = $this->all();
		if ($databaseResult instanceof Collection) { // Check Database Retrieval
			$return = array();
			foreach ($databaseResult as $currentResult) { // Loop through Database Results
				$currentValueObject = $this->valueObjectClassName::getFromArray($currentResult->toArray());
				if ($currentValueObject instanceof $this->valueObjectClassName) { // Check Data Object Creation
					$return[] = $currentValueObject;
				} else { // Middle of Check Data Object Creation
					\Log::debug(sprintf('Failed to make %s object', $this->valueObjectClassName), $currentResult->toArray());
				} // End of Check Data Object Creation
			} // End of Loop through Database Results
		} // End of Check Database Retrieval
		return $return;
	}

	public function fetchById(int $valueObjectId)
	{
		$return = false;
		$databaseResult = $this->find($valueObjectId);
		if ($databaseResult instanceof static) { // Check Database Retrieval
			$valueObject = $this->valueObjectClassName::getFromArray($databaseResult->toArray());
			if ($valueObject instanceof $this->valueObjectClassName) { // Check Data Object Creation
					$return = $valueObject;
				} else { // Middle of Check Data Object Creation
					\Log::debug(sprintf('Failed to make %s object', $this->valueObjectClassName), $databaseResult->toArray());
				} // End of Check Data Object Creation
		} // End of Check Database Retrieval
		return $return;
	}
}
