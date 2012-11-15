<?php

namespace Ethanol;

/**
 * Basic hashing driver for sha1 hashes.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Hash_Driver_Sha1 extends Hash_Driver
{

	public function hash($string, $salt = '')
	{
		return sha1(sha1($string . $salt));
	}

}
