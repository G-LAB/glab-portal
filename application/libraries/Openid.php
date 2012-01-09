<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* OpenID Library
*
* @package    CodeIgniter
* @author     bardelot
* @see        http://cakebaker.42dh.com/2007/01/11/cakephp-and-openid/
*             & http://openidenabled.com/php-openid/
*/

class Openid
{

	private $storePath = '/tmp';

	private $sreg_enable = false;
	private $sreg_required = null;
	private $sreg_optional = null;
	private $sreg_policy = null;

	private $pape_enable = false;
	private $pape_policy_uris = null;

	private $request_to;
	private $trust_root;
	private $ext_args;

	function __construct()
	{
	$CI =& get_instance();
		$CI->config->load('openid');
		$this->storePath = $CI->config->item('openid_storepath');

		session_start();
		$this->_doIncludes();

	log_message('debug', "OpenID Class Initialized");
	}

	function _doIncludes()
	{
		set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());

		require_once "Auth/OpenID/Consumer.php";
		require_once "Auth/OpenID/FileStore.php";
		require_once "Auth/OpenID/SReg.php";
		require_once "Auth/OpenID/PAPE.php";
		require_once "Auth/OpenID/AX.php";
		//require_once "Auth/OpenID/OAuth.php";
		require_once 'Auth/OpenID/google_discovery.php';
	}

	function set_sreg($enable, $required = null, $optional = null, $policy = null)
	{
		$this->sreg_enable = $enable;
		$this->sreg_required = $required;
		$this->sreg_optional = $optional;
		$this->sreg_policy = $policy;
	}

	function set_pape($enable, $policy_uris = null)
	{
		$this->pape_enable = $enable;
		$this->pape_policy_uris = $policy_uris;
	}

	function set_request_to($uri)
	{
		$this->request_to = $uri;
	}

	function set_trust_root($trust_root)
	{
		$this->trust_root = $trust_root;
	}

	function set_args($args)
	{
		$this->ext_args = $args;
	}

	function _set_message($error, $msg, $val = '', $sub = '%s')
	{
		$CI =& get_instance();
		$CI->lang->load('openid');
		echo str_replace($sub, $val, $CI->lang->line($msg));

		if ($error)
		{
			exit;
		}
	}

	function get_provider_url($openId)
	{
		$consumer = $this->_getConsumer();
		$authRequest = $consumer->begin($openId);

		// No auth request means we can't begin OpenID.
		if (!$authRequest)
		{
			$this->_set_message(true,'openid_auth_error');
		}

		// AX Request
		$ax = new Auth_OpenID_AX_FetchRequest;
		$ax->add(Auth_OpenID_AX_AttrInfo::make('http://axschema.org/namePerson/first',1,1));
		$authRequest->addExtension($ax);

		if ($this->sreg_enable)
		{
			$sreg_request = Auth_OpenID_SRegRequest::build($this->sreg_required, $this->sreg_optional, $this->sreg_policy);

			if ($sreg_request)
			{
				$authRequest->addExtension($sreg_request);
			}
			else
			{
				$this->_set_message(true,'openid_sreg_failed');
			}
		}

		if ($this->ext_args != null)
		{
			foreach ($this->ext_args as $extensionArgument)
			{
				if (count($extensionArgument) == 3)
				{
					 $authRequest->addExtensionArg($extensionArgument[0], $extensionArgument[1], $extensionArgument[2]);
				}
			}
		}

		$redirect_url = $authRequest->redirectURL($this->trust_root, $this->request_to);

		// If the redirect URL can't be built, display an error
		// message.
		if (Auth_OpenID::isFailure($redirect_url))
		{
			$this->_set_message(true,'openid_redirect_failed', $redirect_url->message);
		}
		else
		{
			// Send redirect.
			return $redirect_url;
		}


	}

	function getResponse()
	{
	  $consumer = $this->_getConsumer();
	  $response = $consumer->complete($this->request_to);

	  return $response;
	}

	function _getConsumer()
	{
		if (!file_exists($this->storePath) && !mkdir($this->storePath))
		{
			$this->_set_message(true,'openid_storepath_failed', $this->storePath);
		}

		$store = new Auth_OpenID_FileStore($this->storePath);
		$consumer = new Auth_OpenID_Consumer($store);
		new GApps_OpenID_Discovery($consumer);

		return $consumer;
	}
}
?>
