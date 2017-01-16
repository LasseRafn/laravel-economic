<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Product extends Model
{
	protected $entity     = 'products';
	protected $primaryKey = 'productNumber';
	protected $fillable   = [
		'productNumber',
		'name',
		'self',
		'unit',
		'description',
		'recommendedPrice',
		'salesPrice',
		'costPrice'
	];

	public $productNumber;
	public $name;
	public $self;
	public $unit;
	public $description;
	public $recommendedPrice;
	public $salesPrice;
	public $costPrice;
}