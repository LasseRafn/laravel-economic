<?php namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Builders\ContactBuilder;
use LasseRafn\Economic\Utils\Model;

class Customer extends Model
{
	protected $entity   = 'customers';
	protected $primaryKey = 'customerNumber';
	protected $fillable = [
		'customerNumber',
	    'currency',
	    'paymentTerms',
	    'customerGroup',
	    'corporateIdentificationNumber',
	    'vatNumber',
	    'address',
	    'balance',
	    'dueAmount',
	    'name',
	    'vatZone',
	    'website',
	    'country',
	    'lastUpdated',
	    'contacts',
	    'templates',
	    'totals',
	    'deliveryLocations',
	    'invoices',
	    'city',
	    'telephoneAndFaxNumber',
	    'zip',
	    'email',
	    'self',
	    'attention',
	    'ean',
	    'layout',
	    'salesPerson',
	    'customerContact',
	];

	public $customerNumber;
	public $corporateIdentificationNumber;
	public $vatNumber;
	public $currency;
	public $address;
	public $telephoneAndFaxNumber;
	public $balance;
	public $dueAmount;
	public $city;
	public $name;
	public $lastUpdated;
	public $contacts;
	public $country;
	public $zip;
	public $templates;
	public $totals;
	public $website;
	public $deliveryLocations;
	public $invoices;
	public $self;
	public $email;
	public $attention;
	public $ean;
	public $layout;
	public $salesPerson;
	public $customerContact;

	/** @var PaymentTerm */
	public $paymentTerms;

	/** @var CustomerGroup */
	public $customerGroup;

	/** @var VatZone */
	public $vatZone;

	/**
	 * @return ContactBuilder
	 */
	public function contacts()
	{
		return new ContactBuilder($this->request, $this->customerNumber);
	}
}