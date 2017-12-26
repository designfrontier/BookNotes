<?php

class BooksSeeder extends BaseSeeder
{
	protected $tableName = 'books';
	
	protected $tableColumns = array('id', 'title', 'type');
	
	protected $tableValues = array(
		array(1, "The Well of Ascension", 1),
		array(2, "The Name of the Wind", 1),
		array(3, "The Wise Man's Fear", 1),
		array(4, "Mistborn", 1),
		array(5, "The Hero of Ages", 1),
		array(6, "The Complete Fiction of HP Lovecraft", 1),
		array(7, "Koko", 1),
		array(8, "The Alchemist", 1),
		array(9, "Siddhartha", 1),
		array(10, "Blood Meridien", 1),
		array(11, "The Agony and the Ecstasy", 3),
		array(12, "Perdurabo", 2),
		array(13, "The Rise of the House of Rothschild", 2),
		array(14, "The Reign of the House of Rothschild", 2),
		array(15, "How to Read a Book", 2),
		array(16, "The Four Pillars of Investing", 2),
		array(17, "The Intelligent Asset Allocator", 2),
		array(18, "Tragedy and Hope", 2),
		array(19, "Our Oriental Heritage", 2),
		array(20, "The Hero with a Thousand Faces", 2),
		array(21, "Freemasonry: A History", 2),
		array(22, "Enochian Magick", 2),
		array(23, "Freemasonry", 2),
		array(24, "Morals and Dogma", 2),
		array(25, "Transcendental Magic", 2),
		array(26, "Magick: Book 4", 2),
		array(27, "The Theology of Plato", 2),
		array(28, "The Holographic Universe", 2),
		array(29, "The Sociopath Next Door", 2),
		array(30, "Without Conscience", 2),
		array(31, "Snakes in Suits", 2),
		array(32, "The Basic Writings of CG Jung", 2),
		array(33, "The Function of the Orgasm", 2),
		array(34, "The Joint Book", 2),
		array(35, "The Complete Manual of Woodworking", 2)
	);
}
