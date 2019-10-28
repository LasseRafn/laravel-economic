<?php

namespace LasseRafn\Economic\FilterOperators;

class LessThanOrEqualOperator implements FilterOperatorInterface
{
	public $queryString = '$lte:';
}