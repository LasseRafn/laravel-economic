<?php

namespace LasseRafn\Economic\Models;

use LasseRafn\Economic\Utils\Model;

class DraftOrder extends Model
{
    protected $entity = 'orders/drafts';
    protected $primaryKey = 'orderNumber';
    protected $puttable = [
        'orderNumber',
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
        'paymentTerms',
        'customer',
        'recipient',
        'delivery',
        'references',
        'layout',
        'lines',
    ];

    public $orderNumber;
    public $self;
    public $pdf;
    public $name;
    public $date;
    public $currency;
    public $recipient;
    public $project;
    public $grossAmount;
    public $netAmount;

    /** @var object */
    public $soap;

    /** @var Customer */
    public $customer;

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
    public function addLine($description, $quantity, $product)
    {
        $line = new \stdClass();

        $line->description = $description;
        $line->quantity = (float) number_format($quantity, 2);
        $line->product = $product;
        if ($product !== null) {
            $line->unitNetPrice = $product->salesPrice;
            $line->unitCostPrice = $product->costPrice;
            $line->totalNetAmount = $quantity * $product->salesPrice;

            if (isset($product->unit)) {
                $line->unit = $product->unit;
            }
        }

        $this->lines[] = $line;
    }
}
