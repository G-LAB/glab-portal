<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Guests (Unauthorized Users) */
$config[':guest']['portal_errors'] = array();
$config[':guest']['portal_login'] = array();
$config[':guest']['portal_main'] = array();

/* Employees */
$config[':employee'][':guest'] = null;
$config[':employee']['portal_ajax'] = array();
$config[':employee']['portal_dashboard'] = array();
$config[':employee']['portal_client_profile'] = array();
$config[':employee']['portal_preferences'] = array();

/* End of file acl.php */
/* Location: ./application/config/acl.php */