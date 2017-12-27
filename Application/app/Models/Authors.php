<?php

namespace App\Models;

use App\Data\Author;

class Authors extends EntityModel
{
	protected $entityClassName = Author::class;

	protected function populateEntity(EntityObject $entityToPopulate)
	{
		return $entityToPopulate;
	}
}
