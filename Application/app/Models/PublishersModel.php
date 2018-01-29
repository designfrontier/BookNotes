<?php

namespace App\Models;

use App\Data\Publisher;

class PublishersModel extends ValueObjectWithIdAndNameModel
{
	protected $table = 'publishers';
	
	protected $valueObjectClassName = Publisher::class;
}
