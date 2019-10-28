<?php

namespace LasseRafn\Economic\FilterOperators;

class NotInOperator implements FilterOperatorInterface
{
	public $queryString = '$nin:';
}