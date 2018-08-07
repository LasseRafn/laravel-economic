<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Unit extends Model
{
	protected $entity     = 'units';
	protected $primaryKey = 'unitNumber';

	protected $puttable   = [
		'unitNumber',
		'name',
	];

	public $unitNumber;
	public $name;
	public $self;
}
