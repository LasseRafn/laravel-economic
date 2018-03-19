<?php
/**
 * Created by PhpStorm.
 * User: kgbot
 * Date: 12/28/17
 * Time: 11:58 PM.
 */

namespace LasseRafn\Economic\Builders;

use App\Economic\Models\PaidInvoice;

class PaidInvoiceBuilder extends Builder
{
    protected $entity = 'invoices/paid';
    protected $model = PaidInvoice::class;
}
