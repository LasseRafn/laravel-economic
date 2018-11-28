<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;
use LasseRafn\Economic\Utils\Request;

class InvoiceTemplate extends Model
{
    protected $entity     = 'customers/:customerNumber/templates/invoice';
    protected $primaryKey = null;

    public function __construct( Request $request, $data )
    {
        $this->entity = str_replace( ':customerNumber', $data->customer->customerNumber, $this->entity );

        parent::__construct( $request, $data );
    }
}
