<?php

namespace App\Http\Controllers\Web;

use App\Data\ValueObjectWithId;
use App\Models\ValueObjectWithIdModel;

abstract ValueObjectWithIdContoller extends ValueObjectContoller
{
	protected $valueObjectClassType = ValueObjectWithId::class;

	protected $valueObjectModelType = ValueObjectWithIdModel::class;
}
