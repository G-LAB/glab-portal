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

		/* ENABLE PROFILER FOR DEVELOPERS */
		if (ENVIRONMENT == 'development' AND $CI->input->get('profiler') !== false)
		{
			$CI->output->enable_profiler(true);
		}

		/* REQUIRE SSL AT ALL TIMES */
		// Force ACL to load in time
		$CI->load->library('ACL');
		$CI->acl->require_ssl();

		/* SET CONTENT SECURITY POLICY */
		$csp = "default-src 'self'; font-src 'self' themes.googleusercontent.com; img-src 'self' data: ajax.googleapis.com ajax.aspnetcdn.com ssl.google-analytics.com secure.gravatar.com; script-src 'self' ajax.googleapis.com ajax.aspnetcdn.com https://ssl.google-analytics.com; style-src 'self' 'unsafe-inline' fonts.googleapis.com;";
		header("X-WebKit-CSP-Report-Only: $csp");
		header("X-Content-Security-Policy-Report-Only: $csp");

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
		// Default Page Title
		$CI->template->title(' ');
		// HTML Headers
		$CI->template->set_partial('headers','layouts/_headers');
		// Layout Components
		$CI->template->set_partial('menu','layouts/_menu');
		$CI->template->set_partial('hud','layouts/_hud');
		$CI->template->set_partial('side','layouts/_side');
		$CI->template->set_partial('footer','layouts/_footer');
	}
}