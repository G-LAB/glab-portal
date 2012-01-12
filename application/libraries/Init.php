<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * G-LAB Init Library for Code Igniter v2
 * Written by Ryan Brodkin
 * Copyright 2011 G LAB
 */

class Init 
{	
	public function __construct ()
	{
		$CI =& get_instance();

		/* REQUIRE SSL AT ALL TIMES */
		// Force ACL to load in time
		$CI->load->library('ACL');
		$CI->acl->require_ssl();

		/* LOAD TEMPLATE LIBRARY W/ LOCAL CONFIG */
		$CI->load->config('template',true);
		$template_config = $CI->config->item('template');
		if (isset($CI->template) === true)
		{
			$CI->template->initialize($template_config);
		}
		else
		{
			$CI->load->library('template',$template_config);
		}
		// HTML Headers
		$CI->template->set_partial('headers','layouts/_headers');
		// Layout Components
		$CI->template->set_partial('menu','layouts/_menu');
		$CI->template->set_partial('hud','layouts/_hud');
		$CI->template->set_partial('side','layouts/_side');
		$CI->template->set_partial('footer','layouts/_footer');
	}
}