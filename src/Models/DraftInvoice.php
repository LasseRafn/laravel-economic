<?php

namespace LasseRafn\Economic\Models;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use LasseRafn\Economic\Exceptions\EconomicClientException;
use LasseRafn\Economic\Exceptions\EconomicRequestException;
use LasseRafn\Economic\Utils\Model;

class DraftInvoice extends Model
{
    protected $entity     = 'invoices/drafts';
    protected $primaryKey = 'draftInvoiceNumber';
    protected $puttable   = [
        'draftInvoiceNumber',
        'date',
        'currency',
        'exchangeRate',
        'netAmount',
        'netAmountInBaseCurrency',
        'grossAmount',
        'grossAmountInBaseCurrency',
        'marginInBaseCurrency',
        'marginPercentage',
        'vatAmount',
        'roundingAmount',
        'costPriceInBaseCurrency',
        'dueDate',
        'paymentTerms',
        'customer',
        'recipient',
        'deliveryLocation',
        'delivery',
        'notes',
        'references',
        'project',
        'lines',
    ];

    public $draftInvoiceNumber;
    public $self;
    public $pdf;
    public $name;
    public    $dueDate;
    public    $date;
    public    $currency;
    public    $recipient;
    public    $project;
    public    $grossAmount;
    public    $netAmount;

    /** @var Customer */
    public $customer;

    /** @var \stdClass|array */
    public $notes;

    /** @var Layout */
    public $layout;

    /** @var PaymentTerm */
    public $paymentTerms;

    /** @var array */
    public $lines;

    /**
     * @param string $description
     * @param int    $quantity
     * @param        $product
     */
    public function addLine( $description, $quantity, $product )
    {
        $line = new \stdClass();

        $line->description = $description;
        $line->quantity    = (float) number_format( $quantity, 2 );
        $line->product     = $product;
        if ( $product !== null ) {
            $line->unitNetPrice   = $product->salesPrice;
            $line->unitCostPrice  = $product->costPrice;
            $line->totalNetAmount = $quantity * $product->salesPrice;

            if ( isset( $product->unit ) ) {
                $line->unit = $product->unit;
            }
        }

        $this->lines[] = $line;
    }

    /**
     * $number specifies the (optional) number that the booked invoice will have.
     * $sendBy can be one of: none, mobilepay or ean.
     *
     * Documentation: https://restdocs.e-conomic.com/#post-invoices-booked
     *
     * @param null $number
     * @param null $sendBy
     *
     * @return BookedInvoice
     */
    public function book( $number = null, $sendBy = null )
    {
        $data = [
            'draftInvoice' => [
                'self'               => $this->self,
                'draftInvoiceNumber' => $this->draftInvoiceNumber,
            ],
        ];

        if ( $number !== null ) {
            $data[ 'bookWithNumber' ] = $number;
        }

        if ( $sendBy !== null ) {
            $data[ 'sendBy' ] = strtolower( $sendBy );
        }

        try {
            $responseData = $this->request->curl->post( 'invoices/booked', [
                'json' => $data,
            ] )->getBody()->getContents();
        } catch ( ClientException $exception ) {
            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {
                $message = $exception->getResponse()->getBody()->getContents();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new EconomicRequestException( $message, $code );
        } catch ( ServerException $exception ) {
            $message = $exception->getMessage();
            $code    = $exception->getCode();

            if ( $exception->hasResponse() ) {
                $message = $exception->getResponse()->getBody()->getContents();
                $code    = $exception->getResponse()->getStatusCode();
            }

            throw new EconomicRequestException( $message, $code );
        } catch ( \Exception $exception ) {
            $message = $exception->getMessage();
            $code    = $exception->getCode();

            throw new EconomicClientException( $message, $code );
        }

        $responseData = json_decode( $responseData );

        return new BookedInvoice( $this->request, $responseData );
    }
}
