<?php

/**
 * Login Controller for G LAB Company Portal
 *
 * @author Ryan Brodkin
 * @copyright G LAB. All rights reserved.
 * @package CodeIgniter
 */


class Login extends CI_Controller
{

	function __construct ()
	{
		parent::__construct();

		$this->template->set_layout('masthead');
	}

	/**
	 * Displays and validates multifactor authentication options
	 */
	function index()
	{
		/* Authenticated Users Redirect to Dashboard */
		if ($this->acl->is_auth() === true)
		{
			// Send to Dashboard
			redirect('dashboard');
		}

		/* Determine Session Timeout */
		if ($this->input->get('timeout') !== false)
		{
			$this->load->helper('date');

			// Set logout mode
			$this->template->set('timeout', $this->input->get('timeout'));

			// Set session duration
			$this->template->set('sess_expiration', strtolower(timespan(0,$this->config->item('sess_expiration'))));
		}

		/* AUTHENTICATION METHODS */
		// Yubikey
		if ($this->input->post('method') == 'yubikey')
		{
			$otp = $this->input->post('otp');

			$this->load->library('Auth_Yubico',array());
			$this->load->config('auth');

			$yubikey = new Auth_Yubico(config_item('auth_yubico_id'),config_item('auth_yubico_key'),true);

			$response = $yubikey->verify($otp);
			log_message('debug', 'Yubico API Response: '.$response);

			// Verify Yubikey OTP
			if ($response === true)
			{
				// Break OTP Into Parts
				$parts = $yubikey->parsePasswordOTP($otp);

				// Check Database for Yubikey Prefix
				$r = $this->api->request('get','multifactor/yubikey',array('prefix'=>element('prefix',$parts)));

				if (isset($r->pid) === true)
				{
					$profile = $this->profile->get($r->pid);

					if ($profile->exists() === true AND $profile->is_employee() === true) // @todo Also Validate Prefix of Key
					{
						$this->input->set_cookie(array(
							'name'=>'mf_pid',
							'value'=>$profile->pid,
							'expire'=>120,
							'secure'=>true
						));
						redirect('login/oid_request');
					}
					elseif ($profile->exists() === true AND $profile->is_employee() !== true)
					{
						User_Notice::error($profile->name->full.' is not an employee.');
					}
					else
					{
						User_Notice::error('Could not find profile. ('.$profile->name.')');
					}
				}
			}
			else
			{
				User_Notice::error('Yubico declined key ('.$response->message.').');
			}

		}

		// Delete Any and All Session Data
		$this->session->sess_destroy();

		// Show Multifactor Authentication
		$this->template->title('Authentication: Step One')->build('login/main');
	}

	/**
	 * Destroys the session and redirects to default controller.
	 */
	function destroy()
	{
		// Delete Any and All Session Data
		$this->session->sess_destroy();

		// Redirect to Login
		$timeout = (int) $this->input->get('timeout');
		redirect(site_url('login').'?timeout='.$timeout);
	}

	/**
	 * Empty method for AJAX keep alive requests.
	 */
	function heartbeat()
	{
		$this->session->all_userdata();
	}

	/**
	 * Displays JSON data containing OpenID request
	 */
	function oid_request()
	{
		if ($this->input->cookie('mf_pid') != false)
		{
			$this->load->library('openid');
			$this->load->config('openid');

			$request_to = site_url($this->config->item('openid_request_to'));

			$this->openid->set_request_to($request_to);
			$this->openid->set_trust_root(base_url());

			// PAPE
			$this->openid->set_pape(true, array(PAPE_AUTH_PHISHING_RESISTANT,PAPE_AUTH_MULTI_FACTOR), $this->config->item('sess_expiration')*4);

			// OAuth
			$google_apis = array(
				'https://www.googleapis.com/auth/userinfo.profile',
				'https://www.google.com/calendar/feeds/',
				'https://www.google.com/m8/feeds/',
				'https://docs.google.com/feeds/',
				'https://mail.google.com/mail/feed/atom/',
				'http://www-opensocial.googleusercontent.com/api/people',
				'https://spreadsheets.google.com/feeds/'
			);
			//$this->openid->set_args('http://specs.openid.net/extensions/oauth/1.0','consumer','glab-portal.ryan.glabdev.net');
			//$this->openid->set_args('http://specs.openid.net/extensions/oauth/1.0','scope', implode(' ', $google_apis));

			$provider_url = $this->openid->get_provider_url('glabstudios.com');

			redirect($provider_url);
		}
		else
		{
			redirect('login/destroy');
		}
	}

	/**
	 * Validates response from OpenID provider
	 */
	function oid_response()
	{
		$this->load->library('openid');
		$this->load->config('openid');
		$this->load->language('openid');

		$request_to = site_url($this->config->item('openid_request_to'));

		$this->openid->set_request_to($request_to);
		$response = $this->openid->getResponse();

		switch ($response->status)
		{
			case Auth_OpenID_CANCEL:
				User_Notice::error($this->lang->line('openid_cancel'));
				$this->index();
				break;
			case Auth_OpenID_FAILURE:
				User_Notice::error($this->_get_message('openid_failure', $response->message));
				$this->index();
				break;
			case Auth_OpenID_SUCCESS:

				// Multifactor PID
				$mf_pid = (int) $this->input->cookie('mf_pid');

				// OAuth Access Token
				//$oauth_data = $response->getSignedNS('http://specs.openid.net/extensions/oauth/1.0');
				//$oauth_token = element('request_token', $oauth_data);

				// Identity
				$openid = $response->getDisplayIdentifier();

				// AX
				$ax_resp = Auth_OpenID_AX_FetchResponse::fromSuccessResponse($response);
				$email = array_shift(element('http://axschema.org/contact/email', $ax_resp->data));

				// Profile
				$profile = $this->profile->get($email);

				// Check if Multifactor Matches Google User
				if ($profile->exists() && $profile->pid == $mf_pid)
				{
					// Create Session
					$this->acl->create_session($profile->pid);

					// Redirect to Default Controller
					redirect();
				}
				// Not Authorized
				else
				{
					show_error('Google authorization does not match multifactor credentials.',403);
				}

				break; //Auth_OpenID_SUCCESS
		}
	}

	/**
	 * Parses OpenID language file with returned data
	 * @param $msg Key in language file.
	 * @param $val Value to substitute into language value.
	 * @param $sub Match for substitution.
	 */
	function _get_message($msg, $val = '', $sub = '%s')
	{
		$this->load->language('openid');
		return str_replace($sub, $val, $this->lang->line($msg));
	}

}