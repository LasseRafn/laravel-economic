<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class VatZone extends Model
{
	protected $entity     = 'vat-zones';
	protected $primaryKey = 'vatZoneNumber';

	public $vatZoneNumber;
	public $name;
	public $enabledForCustomer;
	public $self;
}
