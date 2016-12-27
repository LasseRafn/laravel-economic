<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Product extends Model
{
	protected $entity   = 'products';
	protected $primaryKey = 'productNumber';
	protected $fillable = [
		'productNumber',
	    'name',
	    'self',
	    'unit',
	    'description',
	    'recommendedPrice',
	    'salesPrice',
	    'costPrice'
	];
}