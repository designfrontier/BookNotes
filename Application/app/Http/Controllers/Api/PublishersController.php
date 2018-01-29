<?php

namespace App\Http\Controllers\Api;

use App\Data\Publisher;
use App\Models\PublishersModel;

class PublishersController extends ValueObjectWithIdAndNameController
{
	protected $valueObjectClassName = Publisher::class;

	protected $valueObjectModelName = PublishersModel::class;
}
