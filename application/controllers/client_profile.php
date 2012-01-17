<?php

/**
 * Client Profile Controller for G LAB Company Portal
 *
 * @author Ryan Brodkin
 * @copyright G LAB. All rights reserved.
 * @package CodeIgniter
 */


class Client_profile extends CI_Controller
{
	/**
	 * Load Profile Data and Pass to Controller
	 */
	function _remap ($pid)
	{
		// Load Profile Data From Model
		if ($pid === 'me')
		{
			$profile = $this->profile->current();
		}
		else
		{
			$profile = $this->profile->get($pid);

			if ($profile->exists() !== true)
			{
				show_404();
			}
		}

		// Pass Profile and Execute Method
		$this->index($profile);
	}

	/**
	 * Display Profile
	 */
	function index($profile)
	{
		$this->template
			->title($profile->name->full)
			->build('client_profile/summary');
	}

}