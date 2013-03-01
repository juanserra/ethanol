<?php

namespace Ethanol;

/**
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
abstract class Random_Driver
{

	/**
	 * Returns a random string of the given length
	 * 
	 * @param int $length Length of the string to generate
	 */
	public abstract function random($length);
}
