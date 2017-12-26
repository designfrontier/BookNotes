<?php

namespace App\Data;

use App\Traits\Singleton;

abstract class BookType extends ValueObjectWithIdAndName
{
	use Singleton;

	const ID = 0;

	const NAME = "";

	public static function getInstance()
	{
		if (!static::$instance instanceof static) { // Check for Instance Variable
			static::$instance = static::getFromArray(array(
				'id'    => static::ID,
				'name'  => static::NAME
			));
		} // End of Check for Instance Variable
		return static::$instance;
	}
}
