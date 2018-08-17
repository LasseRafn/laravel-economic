<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class PaymentTerm extends Model
{
	protected $entity     = 'payment-terms';
	protected $primaryKey = 'paymentTermsNumber';
	protected $puttable   = [
		'daysOfCredit',
		'description',
		'name',
		'paymentTermsType',
	];

	public $daysOfCredit;
	public $description;
	public $name;
	public $paymentTermsType;
	public $contraAccountForPrepaidAmount;
	public $contraAccountForRemainderAmount;
	public $percentageForPrepaidAmount;
	public $percentageForRemainderAmount;
	public $creditCardCompany;
}
