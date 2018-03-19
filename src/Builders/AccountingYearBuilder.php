<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\AccountingYear;
use LasseRafn\Economic\Utils\Request;

class AccountingYearBuilder extends Builder
{
    protected $entity = 'accounting-years/:accountingYear';
    protected $model = AccountingYear::class;

    public $year;

    public function __construct(Request $request, $year)
    {
        $this->year = $year;

        $this->entity = str_replace(':accountingYear', $this->year, $this->entity);

        parent::__construct($request);
    }
}
