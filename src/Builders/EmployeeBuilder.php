<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Employee;

class EmployeeBuilder extends Builder
{
    protected $entity = 'employees';
    protected $model = Employee::class;
}
