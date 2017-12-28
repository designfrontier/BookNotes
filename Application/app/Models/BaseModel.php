<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
	abstract public function fetchAll();

	abstract public function fetchById(int $valueObjectId);

	protected function fetchValueObjectsWithIdAndNameFromBuilder(Builder $builder, string $valueObjectClassName): array
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
}
