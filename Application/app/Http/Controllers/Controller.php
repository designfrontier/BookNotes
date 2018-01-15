<?php

namespace App\Http\Controllers;

use App\Traits\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests; // Laravel Traits
	use Validator; // Additional Traits

	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	protected function getClassNameWithoutNamespace(string $fullyNamespacedClassName): string
	{
		$classNamePieces = explode('\\', $fullyNamespacedClassName);
		return array_pop($classNamePieces);
	}
}
