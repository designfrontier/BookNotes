<?php

namespace App\Traits;

trait Singleton
{
	protected static $instance;

	public static function getInstance()
	{
		if (!static::$instance instanceof static) { // Check for Instance Variable
			static::$instance = new static();
		} // End of Check for Instance Variable
		return static::$instance;
	}

	abstract protected function __construct();
}
