<?php

namespace App\Traits;

trait ValueObjectControllerClassAndModelAttributes
{
	use HasValueObjectAttribute, HasValueObjectModelAttribute;

	protected function validateValueObjectClassAndModelAttributes(): void
	{
		$this->validateValueObjectClassAttributes();
		$this->validateValueObjectModelAttributes();
	}
}
