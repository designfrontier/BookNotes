<?php

namespace App\Http\Controllers\Api;

use App\Data\ContributionType;
use App\Models\ContributionTypesModel;

class ContributionTypesController extends ValueObjectWithIdAndNameController
{
	protected $valueObjectClassName = ContributionType::class;

	protected $valueObjectModelName = ContributionTypesModel::class;
}
