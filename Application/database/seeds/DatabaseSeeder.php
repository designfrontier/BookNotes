<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(array(
			ContributionTypesSeeder::class,
			AuthorsSeeder::class,
			CategoriesSeeder::class,
			PublisherSeeder::class,
			BooksSeeder::class,
			BookAuthorsSeeder::class,
			BookCategoriesSeeder::class
		));
	}
}
