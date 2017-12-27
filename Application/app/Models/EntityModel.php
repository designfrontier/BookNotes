<?php

namespace App\Models;

use App\Data\EntityObject;
use App\Exceptions\MissingRequiredAttributeException;
use Illuminate\Database\Eloquent\Collection;

abstract class EntityModel extends BaseModel
{
	protected $entityClassName;

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		if (!empty($this->entityClassName) && is_string($this->entityClassName)) { // Check for (Required) Entity Class Name
			if (class_exists($this->entityClassName)) { // Verify Entity Class Exists
				if (!is_subclass_of($this->entityClassName, EntityObject::class)) { // Verify Entity Class is EntityObject
					throw new MissingRequiredAttributeException(sprintf('%s->entityClassName class must inherit from %s (%s given)', get_called_class(), EntityObject::class, $this->entityClassName));
				} // End of Verify Entity Class is EntityObject
			} else { // Middle of Verify Entity Class Exists
				throw new MissingRequiredAttributeException(sprintf('%s->entityClassName must be a class that exists (%s given)', get_called_class(), $this->entityClassName));
			} // End of Verify Entity Class Exists
		} else { // Middle of Check for (Required) Entity Class Name
			throw new MissingRequiredAttributeException(sprintf('%s->entityClassName cannot be empty', get_called_class()));
		} // End of Check for (Required) Entity Class Name
	}

	// abstract protected function populateEntity(EntityObject $entityToPopulate);

	public function fetchAll(bool $constructFullyPopulatedEntity = false)
	{
		$return = false;
		$databaseResult = $this->all();
		if ($databaseResult instanceof Collection) { // Check Database Retrieval
			$return = array();
			foreach ($databaseResult as $currentResult) { // Loop through Database Results
				$currentEntityObject = $this->entityClassName::getFromArray($currentResult->toArray());
				if ($currentEntityObject instanceof $this->entityClassName) { // Check Data Object Creation
					$return[] = ($constructFullyPopulatedEntity ? $this->populateEntity($currentEntityObject) : $currentEntityObject);
				} else { // Middle of Check Data Object Creation
					\Log::debug(sprintf('Failed to make %s object', $this->entityClassName), $currentResult->toArray());
				} // End of Check Data Object Creation
			} // End of Loop through Database Results
		} // End of Check Database Retrieval
		return $return;
	}

	public function fetchById(int $entityId, bool $constructFullyPopulatedEntity = false)
	{
		$return = false;
		$databaseResult = $this->find($entityId);
		if ($databaseResult instanceof static) { // Check Database Retrieval
			$entityObject = $this->entityClassName::getFromArray($databaseResult->toArray());
			if ($entityObject instanceof $this->entityClassName) { // Check Data Object Creation
					$return = $entityObject;
				} else { // Middle of Check Data Object Creation
					\Log::debug(sprintf('Failed to make %s object', $this->entityClassName), $databaseResult->toArray());
				} // End of Check Data Object Creation
		} // End of Check Database Retrieval
		return $return;
	}
}
