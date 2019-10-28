<?php

namespace LasseRafn\Economic\FilterOperators;

class GreaterThanOrEqualOperator implements FilterOperatorInterface
{
	public $queryString = '$gte:';
}