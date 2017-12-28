<?php

namespace App\Http\Controllers\Api;

use App\Data\EntityObject;
use App\Exceptions\MissingRequiredAttributeException;
use App\Models\EntityModel;
use App\Traits\Validator;
use Illuminate\Http\JsonResponse;

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

	protected function checkRetrieveFullyPopulatedEntityObject(): bool
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

	public function index(): JsonResponse
	{
		$retrieved = (new $this->entityModelName())->fetchAll($this->checkRetrieveFullyPopulatedEntityObject());
		if (is_array($retrieved) && count($retrieved)) { // Check for Retrieved Entities from DB
			$return = $this->entityOnlyDataResponse($this->convertArrayOfEntitiesToArrayOfArrays($retrieved));
		} else { // Middle of Check for Retrieved Entities from DB
			$return = $this->notFoundResponse();
		} // End of Check for Retrieved Entities from DB
		return $return;
	}

	protected function convertArrayOfEntitiesToArrayOfArrays(array $arrayOfEntities): array
	{
		$return = array();
		foreach ($arrayOfEntities as $currentEntityObject) { // Loop through Passed Array
			if ($currentEntityObject instanceof EntityObject) { // Validate Current Entity Object is What it Should Be
				$return[] = $currentEntityObject->toArray();
			} // End of Validate Current Entity Object is What it Should Be
		} // End of Loop through Passed Array
		return $return;
	}

	public function single($id = null): JsonResponse
	{
		if ((bool) $filteredId = static::validateNonZeroPositiveInteger((int) $id)) { // Validate Passed ID Parameter
			$retrieved = (new $this->entityModelName())->fetchById($filteredId, $this->checkRetrieveFullyPopulatedEntityObject());
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

	protected function notFoundResponse(string $fullyNamespacedResourceName = null): JsonResponse
	{
		$resourceClassName = (empty($fullyNamespacedResourceName) ? $this->entityClassName : $fullyNamespacedResourceName);
		return $this->errorResponse(sprintf('%s not found', $this->getClassNameWithoutNamespace($resourceClassName)), 404);
	}

	protected function entityOnlyDataResponse(array $responsePayloadData): JsonResponse
	{
		return $this->okResponse(array($this->payloadIndexName => $responsePayloadData));
	}

	protected function getClassNameWithoutNamespace(string $fullyNamespacedClassName): string
	{
		$classNamePieces = explode('\\', $fullyNamespacedClassName);
		return array_pop($classNamePieces);
	}
}
