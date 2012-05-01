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

		/* LOAD ACL LIBRARY */
		// Required before autoloads processed
		$CI->load->library('ACL');

		/* REQUIRE SSL AT ALL TIMES */
		$CI->acl->require_ssl();

		/* BUILD PERMISSIONS FOR CURRENT USER */
		$profile = $CI->profile->current();

		// Check if Employee
		if ($profile->is_employee())
		{
			$CI->acl->allow($profile->pid, ':employee');
		}

		// Get memeber groups
		$groups = $profile->meta->portal_acl_groups;
		if (isset($groups) === true)
		{
			$groups = unserialize($groups);
			if (is_array($groups) === true)
			{
				foreach ($groups as $group)
				{
					$CI->acl->allow($profile->pid, ':'.$group);
				}
			}
		}

		/* CHECK FOR PERMISSIONS */
		// Check if permissions pass
		if ($CI->acl->is_allowed('portal_'.$CI->router->fetch_class()) !== true)
		{
			// Error if authenticated, redirect if not
			if ($CI->acl->is_auth() === true)
			{
				show_error('Permission denied.',401);
			}
			else
			{
				redirect('login');
			}
		}

		/* SET CONTENT SECURITY POLICY */
		$csp = "default-src 'self'; font-src 'self' themes.googleusercontent.com; img-src 'self' data: *.gstatic.com *.googleapis.com ajax.aspnetcdn.com ssl.google-analytics.com secure.gravatar.com; script-src 'self' *.gstatic.com *.googleapis.com ajax.aspnetcdn.com ssl.google-analytics.com; style-src 'self' 'unsafe-inline' fonts.googleapis.com;";
		header("X-WebKit-CSP-Report-Only: $csp");
		header("X-Content-Security-Policy-Report-Only: $csp");

		/* PASS KEY SYSTEM VARIABLES TO JAVASCRIPT VIA COOKIES */
		$CI->load->helper('cookie');
		set_cookie(array(
			'name'=>'ci_environment',
			'value'=>ENVIRONMENT,
			'expire'=>60*10,
			'secure'=>true
		));
		set_cookie(array(
			'name'=>'ci_siteurl',
			'value'=>site_url(),
			'expire'=>60*10,
			'secure'=>true
		));
		set_cookie(array(
			'name'=>'ci_sessionexpire',
			'value'=>$CI->config->item('sess_expiration'),
			'expire'=>60*10,
			'secure'=>true
		));

		/* LOAD TEMPLATE LIBRARY W/ LOCAL CONFIG */
		$template_config = array(
			'parser_enabled'=>false,
			'title_separator'=>' : ',
			'layout'=>'default'
		);
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
		$CI->template->set_partial('global','layouts/_global');
		$CI->template->set_partial('user','layouts/_user');
		$CI->template->set_partial('side','layouts/_side');
		$CI->template->set_partial('footer','layouts/_footer');
	}
}