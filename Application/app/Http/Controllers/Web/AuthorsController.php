<?php

namespace App\Http\Controllers\Web;

use App\Data\Author;
use App\Models\AuthorsModel;

class AuthorsController extends EntityController
{
	protected $valueObjectClassName = Author::class;

	protected $valueObjectModelName = AuthorsModel::class;

	protected $indexPageTitle = 'Browse Authors';

	public function single()
	{
	}
}
