<?php

class BookCategoriesSeeder extends BaseSeeder
{
	protected $tableName = 'book_categories';
	
	protected $tableColumns = array('book_id', 'category_id');
	
	protected $tableValues = array(
		array(1, 1),
		array(2, 1),
		array(3, 1),
		array(4, 1),
		array(5, 1),
		array(6, 2),
		array(7, 3),
		array(11, 4),
		array(12, 4),
		array(13, 4),
		array(14, 4),
		array(15, 5),
		array(16, 6),
		array(17, 6),
		array(18, 7),
		array(19, 7),
		array(20, 8),
		array(21, 9),
		array(22, 9),
		array(23, 9),
		array(24, 9),
		array(25, 9),
		array(26, 9),
		array(27, 10),
		array(28, 11),
		array(29, 12),
		array(30, 12),
		array(31, 12),
		array(32, 12),
		array(33, 12),
		array(34, 13),
		array(35, 13)
	);
}
