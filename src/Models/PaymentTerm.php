<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class PaymentTerm extends Model
{
	protected $entity   = 'payment-terms';
	protected $primaryKey = 'paymentTermsNumber';
	protected $fillable = [
		'paymentTermsNumber',
	    'name',
	    'self'
	];
}