<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Contact;
use LasseRafn\Economic\Utils\Request;

class ContactBuilder extends Builder
{
    protected $entity = 'customers/:customerNumber/contacts';
    protected $model = Contact::class;

    public function __construct(Request $request, $customerNumber)
    {
        $this->entity = str_replace(':customerNumber', $customerNumber, $this->entity);

        parent::__construct($request);
    }
}
