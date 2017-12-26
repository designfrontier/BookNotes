<?php

class BookAuthorsSeeder extends BaseSeeder
{
	protected $tableName = 'book_authors';
	
	protected $tableColumns = array('book_id', 'author_id', 'contribution_id');
	
	protected $tableValues = array(
		array(1, 1, 1),
		array(2, 2, 1),
		array(3, 2, 1),
		array(4, 1, 1),
		array(5, 1, 1),
		array(6, 3, 1),
		array(7, 4, 1),
		array(8, 5, 1),
		array(9, 6, 1),
		array(10, 7, 1),
		array(11, 8, 1),
		array(12, 9, 1),
		array(13, 10, 1),
		array(14, 10, 1),
		array(15, 11, 1),
		array(16, 12, 1),
		array(17, 12, 1),
		array(18, 13, 1),
		array(19, 14, 1),
		array(20, 15, 1),
		array(21, 16, 1),
		array(22, 17, 1),
		array(23, 16, 1),
		array(24, 18, 1),
		array(25, 19, 1),
		array(26, 17, 1),
		array(27, 20, 1),
		array(28, 21, 1),
		array(29, 22, 1),
		array(30, 23, 1),
		array(31, 23, 1),
		array(32, 24, 1),
		array(33, 25, 1)
	);
}
