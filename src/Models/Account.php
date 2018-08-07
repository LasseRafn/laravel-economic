<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Account extends Model
{
	protected $entity     = ' /accounts';
	protected $primaryKey = 'accountNumber';

	public $accountNumber;
	public $name;
}
