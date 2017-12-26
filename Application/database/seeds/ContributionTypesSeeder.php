<?php

class ContributionTypesSeeder extends BaseSeeder
{
	protected $tableName = 'contribution_types';
	
	protected $tableColumns = array('id', 'name');
	
	protected $tableValues = array(
		array(1, 'Author'),
		array(2, 'Contributor'),
		array(3, 'Preface'),
		array(4, 'Forward'),
		array(5, 'Introduction'),
		array(6, 'Translator')
	);
}
