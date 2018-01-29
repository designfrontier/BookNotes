<?php

namespace App\Http\Controllers\Web;

use App\Traits\ValueObjectControllerClassAndModelAttributes;

abstract class ValueObjectContoller extends BaseController
{
	use ValueObjectControllerClassAndModelAttributes;

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->validateValueObjectClassAndModelAttributes();
	}
}
