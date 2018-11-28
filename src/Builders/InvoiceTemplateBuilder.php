<?php
/**
 * Created by PhpStorm.
 * User: kgbot
 * Date: 11/28/18
 * Time: 6:11 PM
 */

namespace LasseRafn\Economic\Builders;


use LasseRafn\Economic\Models\InvoiceTemplate;
use LasseRafn\Economic\Utils\Request;

class InvoiceTemplateBuilder extends Builder
{
    protected $entity = 'customers/:customerNumber/templates/invoice';
    protected $model  = InvoiceTemplate::class;

    public function __construct( Request $request, $customerNumber )
    {
        $this->entity = str_replace( ':customerNumber', $customerNumber, $this->entity );

        parent::__construct( $request );
    }
}