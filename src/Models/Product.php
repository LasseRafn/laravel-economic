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
		'departmentalDistribution',
		'recommendedPrice',
		'salesPrice',
		'costPrice'
	];

	public $productNumber;
	public $departmentalDistribution;
	public $name;
	public $self;
	public $unit;
	public $description;
	public $recommendedPrice = 0;
	public $salesPrice = 0;
	public $costPrice = 0;
}
