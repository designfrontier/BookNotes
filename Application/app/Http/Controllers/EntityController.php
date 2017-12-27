<?php

namespace App\Http\Controllers;

use App\Data\EntityObject;
use App\Exceptions\MissingRequiredAttributeException;
use App\Models\EntityModel;
use App\Traits\Validator;

abstract class EntityController extends Controller
{
	use Validator;

	protected $entityClassName;

	protected $entityModelName;

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
	}

	protected function checkRetrieveFullyPopulatedEntityObject()
	{
		// @todo Check the Input
	}

	public function index()
	{
		return sprintf('<pre>%s</pre>', print_r((new $this->entityModelName())->fetchAll(), true));
	}

	public function single($id = null)
	{
		if ((bool) $filteredId = static::validateNonZeroPositiveInteger((int) $id)) { // Validate Passed ID Parameter
			$retrieved = (new $this->entityModelName())->fetchById($id);
			$return = '<pre>' . ($retrieved instanceof $this->entityClassName ? print_r($retrieved, true) : '[Not Found]') . '</pre>';
		} else { // Middle of Validate Passed ID Parameter
			$return = sprintf('<pre>You passed an invalid ID: %s</pre>', $id);
		} // End of Validate Passed ID Parameter
		return $return;
	}
}
