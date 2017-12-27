<?php

namespace App\Http\Controllers;

use App\Data\Author;
use App\Models\Authors as AuthorsModel;

class Authors extends EntityController
{
	protected $entityClassName = Author::class;

	protected $entityModelName = AuthorsModel::class;
}
