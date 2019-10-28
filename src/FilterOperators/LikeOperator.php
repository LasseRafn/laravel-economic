<?php

namespace LasseRafn\Economic\FilterOperators;

class LikeOperator implements FilterOperatorInterface
{
	public $queryString = '$like:';
}