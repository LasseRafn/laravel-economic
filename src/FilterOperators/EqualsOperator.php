<?php

namespace LasseRafn\Economic\FilterOperators;

class EqualsOperator implements FilterOperatorInterface
{
	public $queryString = '$eq:';
}