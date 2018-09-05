<?php

namespace LasseRafn\Economic\Builders;

use LasseRafn\Economic\Models\Product;

class ProductBuilder extends Builder
{
	protected $entity = 'products';
	protected $model  = Product::class;

	/**
	 * @param $unencodedId
	 *
	 * @return mixed|Model
	 */
	public function findWithCustomEncoding( $unencodedId ) {
		return $this->find( $this->encode( $unencodedId ) );
	}

	/**
	 * @param $unencodedId
	 *
	 * @return string
	 */
	public function encode( $unencodedId ) {
		$replacements = [
			'_'  => '_8_',
			'<'  => '_0_',
			'>'  => '_1_',
			'*'  => '_2_',
			'%'  => '_3_',
			':'  => '_4_',
			'&'  => '_5_',
			'/'  => '_6_',
			'\\' => '_7_',
			' '  => '_9_',
			'?'  => '_10_',
			'.'  => '_11_',
			'#'  => '_12_',
			'+'  => '_13_',
		];

		return str_replace( array_keys( $replacements ), $replacements, $unencodedId );
	}

	/**
	 * @param $encodedId
	 *
	 * @return string
	 */
	public function decode( $encodedId ) {
		$replacements = [
			'_0_'  => '<',
			'_1_'  => '>',
			'_2_'  => '*',
			'_3_'  => '%',
			'_4_'  => ':',
			'_5_'  => '&',
			'_6_'  => '/',
			'_7_'  => '\\',
			'_8_'  => '_',
			'_9_'  => ' ',
			'_10_' => '?',
			'_11_' => '.',
			'_12_' => '#',
			'_13_' => '+',
		];

		return str_replace( array_keys( $replacements ), $replacements, $encodedId );
	}
}
