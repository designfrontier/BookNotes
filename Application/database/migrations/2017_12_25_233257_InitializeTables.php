<?php

use Illuminate\Database\Migrations\Migration;

class InitializeTables extends Migration
{
	protected $tablesToCreate = array(
		'books'                 => "`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `title` VARCHAR(255) NOT NULL, `type` ENUM('Fiction','Non-Fiction','Fiction based on Fact') NOT NULL DEFAULT 'Fiction', `published_date` DATE NULL, PRIMARY KEY (`id`), INDEX `BOOK_TYPE` (`type` ASC), UNIQUE INDEX `title_UNIQUE` (`title` ASC)",
		'authors'               => "`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `first_name` VARCHAR(255) NULL, `middle_name` VARCHAR(255) NULL, `last_name` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`), UNIQUE INDEX `FULL_NAME_UNIQUE` (`last_name` ASC, `first_name` ASC, `middle_name` ASC)",
		'pseudonyms'            => "`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `first_name` VARCHAR(255) NULL, `middle_name` VARCHAR(255) NULL, `last_name` VARCHAR(255) NOT NULL, `author_id` INT UNSIGNED NOT NULL, PRIMARY KEY (`id`), INDEX `P_FULL_NAME` (`last_name` ASC, `first_name` ASC, `middle_name` ASC), INDEX `P_AUTHOR_idx` (`author_id` ASC), CONSTRAINT `P_AUTHOR` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION",
		'contribution_types'    => "`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`), INDEX `C_NAMES` (`name` ASC), UNIQUE INDEX `name_UNIQUE` (`name` ASC)",
		'book_authors'          => "`book_id` INT UNSIGNED NOT NULL, `author_id` INT UNSIGNED NOT NULL, `pseudonym_id` INT UNSIGNED NULL, `contribution_id` INT UNSIGNED NULL, `listing_order` TINYINT UNSIGNED NULL, PRIMARY KEY (`book_id`, `author_id`), INDEX `BOOK_AUTHOR_idx` (`author_id` ASC), INDEX `BA_PSEUDONYM_idx` (`pseudonym_id` ASC), INDEX `CA_CONTRIBUTION_idx` (`contribution_id` ASC), CONSTRAINT `BA_AUTHOR` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `BA_BOOK` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `BA_PSEUDONYM` FOREIGN KEY (`pseudonym_id`) REFERENCES `pseudonyms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `CA_CONTRIBUTION` FOREIGN KEY (`contribution_id`) REFERENCES `contribution_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION",
		'categories'            => "`id` INT UNSIGNED NOT NULL, `name` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`), INDEX `BOOK_CATEGORY` (`name` ASC), UNIQUE INDEX `name_UNIQUE` (`name` ASC)",
		'book_categories'       => "`book_id` INT UNSIGNED NOT NULL, `category_id` INT UNSIGNED NOT NULL, PRIMARY KEY (`book_id`, `category_id`), INDEX `BC_CATEGORY_idx` (`category_id` ASC), CONSTRAINT `BC_CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `BC_BOOK` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION",
		'notes'                 => "`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `note` TEXT NOT NULL, `book_id` INT UNSIGNED NOT NULL, `parent_note_id` INT UNSIGNED NULL, `chapter` TINYINT UNSIGNED NULL, `section` VARCHAR(255) NULL, `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), INDEX `N_BOOK_idx` (`book_id` ASC), INDEX `N_PARENT_idx` (`parent_note_id` ASC), CONSTRAINT `N_BOOK` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `N_PARENT` FOREIGN KEY (`parent_note_id`) REFERENCES `notes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION",
		'reading_lists'         => "`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `description` VARCHAR(255) NULL, PRIMARY KEY (`id`), UNIQUE INDEX `name_UNIQUE` (`name` ASC)",
		'books_reading_lists'   => "`list_id` INT UNSIGNED NOT NULL, `book_id` INT UNSIGNED NOT NULL, `order` INT UNSIGNED NULL, `note` VARCHAR(255) NULL, PRIMARY KEY (`list_id`, `book_id`), INDEX `BL_BOOKS_idx` (`book_id` ASC), CONSTRAINT `BL_LISTS` FOREIGN KEY (`list_id`) REFERENCES `reading_lists` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `BL_BOOKS` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION"
	);

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach ($this->tablesToCreate as $currentTableName => $currentTableDefinition) { // Loop through Tables to Create
			$this->createTable($currentTableName, $currentTableDefinition);
		} // End of Loop through Tables to Create
	}

	protected function createTable(string $tableName, string $tableDefinition)
	{
		DB::statement(sprintf('CREATE TABLE `%s` (%s) ENGINE = InnoDB;', $tableName, $tableDefinition));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		foreach (array_keys($this->tablesToCreate) as $currentTableName) { // Loop through Tables to Create
			$this->dropTable($currentTableName);
		} // End of Loop through Tables to Create
	}

	protected function dropTable(string $tableName)
	{
		DB::statement(sprintf('DROP TABLE `%s`;', $tableName));
	}
}
