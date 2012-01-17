<?php

/**
 * Dashboard Controller for G LAB Company Portal
 *
 * @author Ryan Brodkin
 * @copyright G LAB. All rights reserved.
 * @package CodeIgniter
 */


class Dashboard extends CI_Controller
{
	/**
	 * Display Dashboard
	 */
	function index()
	{
		$this->template->build('dashboard/main');
	}

}