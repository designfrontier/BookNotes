<?php

namespace App\Http\Controllers\Web;

use App\Traits\ValueObjectControllerClassAndModelAttributes;
use Illuminate\Http\Request;

abstract class ValueObjectController extends BaseController
{
	use ValueObjectControllerClassAndModelAttributes;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->validateValueObjectClassAndModelAttributes();
	}
}
