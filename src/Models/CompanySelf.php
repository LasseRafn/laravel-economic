<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class CompanySelf extends Model
{
    protected $entity = 'self';
    protected $primaryKey = 'agreementNumber';

    public $agreementNumber;

    /** @var object */
    public $application = [
        'appNumber'      => null,
        'appPublicToken' => null,
        'created'        => null,
        'name'           => null,
        'requiredRoles'  => [],
        'self'           => null,
    ];

    /** @var object */
    public $agreementType = [
        'agreementTypeNumber' => null,
        'name'                => null,
    ];

    /** @var object */
    public $bankInformation = [
        'bankAccountNumber'      => null,
        'bankGiroNumber'         => null,
        'bankName'               => null,
        'bankSortCode'           => null,
        'pbsCustomerGroupNumber' => null,
        'pbsFiSupplierNumber'    => null,
    ];

    /** @var object */
    public $company = [
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
        'zip'                         => null,
    ];

    /** @var object */
    public $settings = [
        'baseCurrency'        => null,
        'internationalLedger' => null,
    ];

    /** @var object */
    public $user = [
        'agreementNumber' => null,
        'email'           => null,
        'language'        => [
            'culture'        => null,
            'languageNumber' => null,
            'name'           => null,
            'self'           => null,
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
