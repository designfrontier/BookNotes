<?php

namespace App\Http\Controllers\Web;

use App\Data\ValueObjectWithIdAndName;
use App\Models\ValueObjectWithIdAndNameModel;

abstract class ValueObjectWithIdAndNameController extends ValueObjectWithIdController
{
	protected $valueObjectClassType = ValueObjectWithIdAndName::class;

	protected $valueObjectModelType = ValueObjectWithIdAndNameModel::class;
}
