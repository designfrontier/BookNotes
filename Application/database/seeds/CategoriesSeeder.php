<?php

class CategoriesSeeder extends BaseSeeder
{
	protected $tableName = 'categories';
	
	protected $tableColumns = array('id', 'name');
	
	protected $tableValues = array(
		array(1, "Fantasy"),
		array(2, "Horror"),
		array(3, "Mystery"),
		array(4, "Biography"),
		array(5, "Education"),
		array(6, "Finance"),
		array(7, "History"),
		array(8, "Mythology"),
		array(9, "Occult"),
		array(10, "Philosophy"),
		array(11, "Physics"),
		array(12, "Psychology"),
		array(13, "Woodworking"),
		array(14, "Graphic Novel"),
		array(15, "Health & Wellness"),
		array(16, "Cooking & Recipes"),
		array(17, "Language"),
		array(18, "Science"),
		array(19, "Business"),
		array(20, "Investing"),
		array(21, "Religion"),
		array(22, "Photography"),
		array(23, "Science Fiction")
	);
}
