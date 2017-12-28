<?php

namespace App\Http\Controllers\Api;

use App\Data\EntityObject;
use App\Exceptions\MissingRequiredAttributeException;
use App\Models\EntityModel;
use App\Traits\Validator;

abstract class EntityController extends BaseController
{
	use Validator;

	protected $entityClassName;

	protected $entityModelName;

	protected $payloadIndexName;

	public function __construct()
	{
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
		if (!empty($this->entityModelName) && is_string($this->entityModelName)) { // Check for (Required) Entity Model Name
			if (class_exists($this->entityModelName)) { // Verify Entity Model Exists
				if (!is_subclass_of($this->entityModelName, EntityModel::class)) { // Verify Entity Model is EntityModel
					throw new MissingRequiredAttributeException(sprintf('%s->entityModelName class must inherit from %s (%s given)', get_called_class(), EntityModel::class, $this->entityModelName));
				} // End of Verify Entity Model is EntityModel
			} else { // Middle of Verify Entity Model Exists
				throw new MissingRequiredAttributeException(sprintf('%s->entityModelName must be a class that exists (%s given)', get_called_class(), $this->entityModelName));
			} // End of Verify Entity Model Exists
		} else { // Middle of Check for (Required) Entity Model Name
			throw new MissingRequiredAttributeException(sprintf('%s->entityModelName cannot be empty', get_called_class()));
		} // End of Check for (Required) Entity Model Name
		if (empty($this->payloadIndexName) || !is_string($this->payloadIndexName)) {
			$this->payloadIndexName = $this->getClassNameWithoutNamespace(get_called_class());
		}
	}

	protected function checkRetrieveFullyPopulatedEntityObject()
	{
		// @todo Check the Input
	}

	public function index()
	{
		$retrieved = (new $this->entityModelName())->fetchAll();
		if (is_array($retrieved) && count($retrieved)) { // Check for Retrieved Entities from DB
			$payload = array();
			foreach ($retrieved as $currentEntityObject) { // Loop through Retrieved Entities
				$payload[] = $currentEntityObject->toArray();
			} // End of Loop through Retrieved Entities
			unset($retrieved, $currentEntityObject);
			$return = $this->entityOnlyDataResponse($payload);
		} else { // Middle of Check for Retrieved Entities from DB
			$return = $this->notFoundResponse();
		} // End of Check for Retrieved Entities from DB
		return $return;
	}

	public function single($id = null)
	{
		if ((bool) $filteredId = static::validateNonZeroPositiveInteger((int) $id)) { // Validate Passed ID Parameter
			$retrieved = (new $this->entityModelName())->fetchById($id);
			if ($retrieved instanceof $this->entityClassName) { // Check if Entity Retrieved from DB
				$return = $this->entityOnlyDataResponse(array($retrieved->toArray()));
			} else { // Middle of Check if Entity Retrieved from DB
				$return = $this->notFoundResponse();
			} // End of Check if Entity Retrieved from DB
		} else { // Middle of Validate Passed ID Parameter
			$return = $this->errorResponse(sprintf('Invalid ID: %s', $id));
		} // End of Validate Passed ID Parameter
		return $return;
	}

	protected function notFoundResponse()
	{
		return $this->errorResponse(sprintf('%s not found', $this->getClassNameWithoutNamespace($this->entityClassName)), 404);
	}

	protected function entityOnlyDataResponse(array $responsePayloadData)
	{
		return $this->okResponse(array($this->payloadIndexName => $responsePayloadData));
	}

	protected function getClassNameWithoutNamespace(string $fullyNamespacedClassName)
	{
		$classNamePieces = explode('\\', $fullyNamespacedClassName);
		return array_pop($classNamePieces);
	}
}
