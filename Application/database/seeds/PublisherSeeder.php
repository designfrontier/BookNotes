<?php

class PublisherSeeder extends BaseSeeder
{
	protected $tableName = 'publishers';
	
	protected $tableColumns = array('id', 'name');
	
	protected $tableValues = array(
		array(1, 'Unknown'),
		array(2, 'Tor'),
		array(3, 'DAW Books, Inc')
	);
}
