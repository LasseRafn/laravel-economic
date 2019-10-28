<?php

namespace LasseRafn\Economic\FilterOperators;

class NullOperator implements FilterOperatorInterface
{
	public $queryString = '$null:';
}