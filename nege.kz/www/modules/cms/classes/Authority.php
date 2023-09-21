<?php
/**
* Authority
*
* Authority is an authorization library for CodeIgniter 2+ and PHPActiveRecord
* This library is inspired by, and largely based off, Ryan Bates' CanCan gem
* for Ruby on Rails. It is not a 1:1 port, but the essentials are available.
* Please check out his work at http://github.com/ryanb/cancan/
*
* @package Authority
* @version 0.0.3
* @author Matthew Machuga
* @license MIT License
* @copyright 2011 Matthew Machuga
* @link http://github.com/machuga
*
**/




class Authority extends Ability {

	public static function initialize($user)
	{
		if(is_null($user)) return;

		static::reset();
		
		$initialize = Kohana::$config->load('authority');
		call_user_func($initialize['initialize'], $user);
	}

	public static function as_user($user)
	{
		static::initialize($user);
	}

}
