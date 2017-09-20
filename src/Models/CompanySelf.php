<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class CompanySelf extends Model
{
	protected $entity     = 'self';
	protected $primaryKey = 'agreementNumber';

	public $agreementNumber;

	public $application = (object) [
		'appNumber'      => null,
		'appPublicToken' => null,
		'created'        => null,
		'name'           => null,
		'requiredRoles'  => [],
		'self'           => null
	];

	public $agreementType = (object) [
		'agreementTypeNumber' => null,
		'name'                => null
	];

	public $bankInformation = (object) [
		'bankAccountNumber'      => null,
		'bankGiroNumber'         => null,
		'bankName'               => null,
		'bankSortCode'           => null,
		'pbsCustomerGroupNumber' => null,
		'pbsFiSupplierNumber'    => null
	];

	public $company = (object) [
		'addressLine1'                => null,
		'addressLine2'                => null,
		'attention'                   => null,
		'city'                        => null,
		'companyIdentificationNumber' => null,
		'country'                     => null,
		'email'                       => null,
		'name'                        => null,
		'phoneNumber'                 => null,
		'vatNumber'                   => null,
		'website'                     => null,
		'zip'                         => null
	];

	public $settings = (object) [
		'baseCurrency'        => null,
		'internationalLedger' => null
	];

	public $user = (object) [
		'agreementNumber' => null,
		'email'           => null,
		'language'        => (object) [
			'culture'        => null,
			'languageNumber' => null,
			'name'           => null,
			'self'           => null
		],
		'loginId'         => null,
		'name'            => null,
	];

	public $userName;

	public $companyAffiliation;

	public $modules = [];

	public $self;

	/** @var YYYY-MM-DD */
	public $signupDate;

	/** @var bool */
	public $canSendElectronicInvoice;

	/** @var bool */
	public $canSendMobilePay;

}