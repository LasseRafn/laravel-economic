<?php

namespace LasseRafn\Economic\FilterOperators;

class NotEqualsOperator implements FilterOperatorInterface
{
	public $queryString = '$ne:';
}