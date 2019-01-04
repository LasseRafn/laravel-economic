<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Voucher;
use LasseRafn\Economic\Utils\Request;

class VoucherBuilder extends Builder
{
    protected $entity = 'accounting-years/:accountingYear/vouchers';
    protected $model = Voucher::class;

    public function __construct(Request $request, $year)
    {
        $this->entity = str_replace(':accountingYear', $year, $this->entity);

        parent::__construct($request);
    }
}
