<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class Contact extends Model
{
    protected $entity = 'customers/:customerNumber/contacts';
    protected $primaryKey = 'customerContactNumber';
    protected $puttable = [
        'customerContactNumber',
        'email',
        'phone',
        'name',
        'customer',
        'eInvoiceId',
        'emailNotifications',
    ];

    public $customerContactNumber;
    public $self;
    public $phone;
    public $email;
    public $name;
    public $eInvoiceId;
    public $emailNotifications;
    public $notes;

    /** @var Customer $customer */
    public $customer;

    public function __construct(Request $request, $data)
    {
        $this->entity = str_replace(':customerNumber', $data->customer->customerNumber, $this->entity);

        parent::__construct($request, $data);
    }
}
