<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class Supplier extends Model
{
    protected $entity = 'suppliers';
    protected $primaryKey = 'supplierNumber';
    protected $puttable = [
        'address',
        'attention',
        'bankAccount',
        'barred',
        'city',
        'corporateIdentificationNumber',
        'costAccount',
        'country',
        'currency',
        'email',
        'layout',
        'name',
        'remittanceAdvice',
        'salesPerson',
        'self',
        'supplierContact',
        'supplierGroup',
        'supplierNumber',
        'zip',
        'paymentTerms',
        'vatZone',
    ];

    public $address;
    public $attention;
    public $bankAccount;
    public $barred;
    public $city;
    public $corporateIdentificationNumber;
    public $costAccount;
    public $country;
    public $currency;
    public $email;
    public $layout;
    public $name;
    public $remittanceAdvice;
    public $salesPerson;
    public $self;
    public $supplierContact;
    public $supplierGroup;
    public $supplierNumber;
    public $zip;

    /** @var PaymentTerm */
    public $paymentTerms;

    /** @var VatZone */
    public $vatZone;
}
