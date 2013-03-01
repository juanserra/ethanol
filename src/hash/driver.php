<?php

namespace Ethanol;

/**
 * Defines a common interface for hashing libraries.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
abstract class Hash_Driver
{

	/**
	 * Shold hash the given string and return the hash of that string.
	 * 
	 * @param string $string The string to hash
	 * @return string The hashed string
	 */
	public abstract function hash($string, $salt = '');
}
