<?php

/**
 * Preferences Controller for G LAB Company Portal
 *
 * @author Ryan Brodkin
 * @copyright G LAB. All rights reserved.
 * @package CodeIgniter
 */


class Preferences extends CI_Controller
{
	/**
	 * Display Preferences
	 */
	function index()
	{
		$this->template
			->set('profile',$this->profile->current())
			->build('preferences/main');
	}

}