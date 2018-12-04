<?php

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

    public function get( $filters = [] )
    {

        return $this->request->handleWithExceptions( function () {
            $response = $this->request->curl->get( "/{$this->entity}" );

            $responseData = json_decode( $response->getBody()->getContents() );

            $model = new $this->model( $this->request, $responseData );

            return $model;
        } );
    }
}
