<?php

namespace App\Http\Controllers\Web;

use App\Data\EntityObject;
use App\Models\EntityModel;

abstract class EntityController extends ValueObjectWithIdController
{
	protected $valueObjectClassType = EntityObject::class;

	protected $valueObjectModelType = EntityModel::class;
}
