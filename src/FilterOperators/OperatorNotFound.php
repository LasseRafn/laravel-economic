<?php

namespace LasseRafn\Economic\FilterOperators;

class OperatorNotFound extends \Exception
{
	function __construct( $operator ) { parent::__construct( "Operator '{$operator}' not defined.", 0, null ); }
}