<?php

class AuthorsSeeder extends BaseSeeder
{
	protected $tableName = 'authors';
	
	protected $tableColumns = array('id', 'first_name', 'middle_name', 'last_name');
	
	protected $tableValues = array(
		array(1, "Brandon", "", "Sanderson"),
		array(2, "Patrick", "", "Rothfuss"),
		array(3, "Howard", "Phillips", "Lovecraft"),
		array(4, "Peter", "", "Straub"),
		array(5, "Paolo", "", "Coello"),
		array(6, "Herman", "", "Hesse"),
		array(7, "Cormac", "", "McCarthy"),
		array(8, "Irving", "", "Stone"),
		array(9, "Richard", "", "Kacynski"),
		array(10, "Egon", "Caesar Conte", "Corti"),
		array(11, "Mortimer", "Jerome", "Adler"),
		array(12, "William", "", "Bernstein"),
		array(13, "Carrol", "", "Quigley"),
		array(14, "Will", "", "Durant"),
		array(15, "Joseph", "", "Campbell"),
		array(16, "Angel", "", "Millar"),
		array(17, "Aleister", "", "Crowley"),
		array(18, "Albert", "", "Pike"),
		array(19, "Eliphas", "", "Levi"),
		array(20, "", "", "Proclus"),
		array(21, "Michael", "", "Talbot"),
		array(22, "Martha", "", "Stout"),
		array(23, "Robert", "", "Hare"),
		array(24, "Carl", "Gustav", "Jung"),
		array(25, "Wilhelm", "", "Reich")
	);

	protected $emptyToNullColumns = array('first_name', 'middle_name');
}
