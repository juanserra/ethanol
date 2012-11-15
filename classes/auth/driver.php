<?php

namespace Ethanol;

/**
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 */
abstract class Auth_Driver
{

	//Log in
	public abstract function login($username, $password);

	//log out
	public abstract function logout();

	//get user
	public abstract function getUser($identifier);
}
