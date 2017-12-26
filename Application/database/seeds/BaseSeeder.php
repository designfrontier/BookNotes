<?php

use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder
{
	protected $tableName;
	
	protected $tableColumns = array();
	
	protected $tableValues = array();

	protected $emptyToNullColumns = array();

	public function __construct()
	{
		parent::__construct();
		if (empty($this->tableName)) { // Validate Table Name Not Empty
			throw new Exception(sprintf('%s->tableName Cannot be empty', get_called_class())); // @todo Change Exception Type Thrown
		} // End of Validate Table Name Not Empty
		if (count($this->tableColumns) < 1) { // Validate Table Columns Not Empty
			throw new Exception(sprintf('%s->tableColumns Cannot be empty', get_called_class())); // @todo Change Exception Type Thrown
		} // End of Validate Table Columns Not Empty
		if (count($this->tableValues) < 1) { // Validate Table Values Not Empty
			throw new Exception(sprintf('%s->tableValues Cannot be empty', get_called_class())); // @todo Change Exception Type Thrown
		} // End of Validate Table Values Not Empty
	}

	public function run()
	{
		$queryBase = sprintf(
			'INSERT INTO `%s` (%s) VALUES (%s)',
			$this->tableName,
			'`' . implode('`, `', $this->tableColumns) . '`',
			sprintf('%s', implode(', ', array_fill(0, count($this->tableColumns), '?')))
		);
		foreach ($this->tableValues as $currentTableValues) { // Loop through Table Values
			DB::statement($queryBase, $currentTableValues);
		} // End of Loop through Table Values
		foreach ($this->emptyToNullColumns as $currentColumn) { // Loop through Columns to Convert Empty Values to Nulls
			$this->replaceEmptyValuesWithNulls($currentColumn);
		} // End of Loop through Columns to Convert Empty Values to Nulls
	}

	protected function replaceEmptyValuesWithNulls(string $columnName)
	{
		DB::update(sprintf('UPDATE TABLE `%1$s` SET `%2$s` = NULL WHERE `%2$s` = "";', $this->tableName, $columnName));
	}
}
