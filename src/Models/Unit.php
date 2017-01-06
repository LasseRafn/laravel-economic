<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Unit extends Model
{
	protected $entity   = 'units';
	protected $primaryKey = 'unitNumber';
	protected $fillable = [
		'vatZoneNumber',
	    'name',
	    'self'
	];
}