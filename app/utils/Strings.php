<?php

namespace App\Utils;



/**
 * String utils.
 */
class Strings
{
	/**
	 * Calculates XOR of the given strings.
	 * @param  string
	 * @param  string
	 * @return string
	 */
	public static function xorStrings($a, $b)
	{
		if (($length = strlen($a)) !== strlen($b)) {
			throw new \InvalidArgumentException('The lengths of the given strings have to be equal.');
		}

		$s = '';
		for ($i = 0; $i < $length; $i++) {
			$s .= chr(ord($a[$i]) ^ ord($b[$i]));
		}
		return $s;
	}
}
