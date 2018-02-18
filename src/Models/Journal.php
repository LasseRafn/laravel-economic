<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Journal extends Model
{
	protected $entity     = 'journals-experimental';
	protected $primaryKey = 'journalNumber';
	protected $fillable   = [
		'journalNumber',
		'entries',
		'name'
	];

	public $journalNumber;
	public $entries;
	public $name;
}