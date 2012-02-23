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

	function __construct () {
		parent::__construct();

		$this->template->set_layout('masthead');
	}

	/**
	 * Displays welcome page
	 */
	function index()
	{
		if ($this->acl->is_auth() === true)
		{
			// Send to Dashboard
			redirect('dashboard');
		}

		// Delete Any and All Session Data
		$this->session->sess_destroy();

		$this->template->title('Step One')->build('login/main');
	}

	/**
	 * Destroys the session and redirects to default controller.
	 */
	function destroy()
	{
		// Delete Any and All Session Data
		$this->session->sess_destroy();

		// Send to default controller
		redirect();
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
		$this->load->library('openid');
		$this->load->config('openid');

		$request_to = site_url($this->config->item('openid_request_to'));

		$this->openid->set_request_to($request_to);
		$this->openid->set_trust_root(base_url());
		$this->openid->set_args(null);

		$provider_url = $this->openid->get_provider_url('glabstudios.com');

		$data['result']['provider_url'] = $provider_url;

		echo json_encode($data);
	}

	/**
	 * Validates response from OpenID provider
	 */
	function oid_response()
	{
		$this->load->library('openid');
		$this->load->config('openid');

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

				// Identity
				$openid = $response->getDisplayIdentifier();

				// AX
				$ax_resp = Auth_OpenID_AX_FetchResponse::fromSuccessResponse($response);
				if ($ax_resp)
				{
					$first_name = $ax_resp->data['http://axschema.org/namePerson/first'];
				}

				// Temporarily Store Data to Session
				$this->session->set_userdata('openid', $openid);
				$this->session->set_userdata('first_name', $first_name);

				// Redirect to Yubikey Auth
				redirect('login/multifactor');

				break;
		}
	}

	/**
	 * Displays and validates multifactor authentication options
	 */
	function multifactor()
	{
		if (is_string($this->session->userdata('openid')) !== true)
		{
				User_Notice::error('OpenID Session Error: ','Could not retrieve ID from session.  Cannot continue with login process.');
		}

		if ($this->input->post('method') == 'yubikey')
		{
			$otp = $this->input->post('otp');

			$this->load->library('Auth_Yubico',array());
			$this->load->config('auth');

			$yubikey = new Auth_Yubico(config_item('auth_yubico_id'),config_item('auth_yubico_key'),true);

			$response = $yubikey->verify($otp);

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

					if ($profile->exists() === true AND $profile->is_employee()) // @todo Also Validate Prefix of Key
					{
						$this->acl->create_session($profile->pid);
						redirect();
					}
					elseif ($profile->exists() === true)
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
				$this->event->log('auth_failure_mf_yubikey',false,array('error'=>$response->message));
			}

		}

		$this->template->title('Step Two')->build('login/multifactor');
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