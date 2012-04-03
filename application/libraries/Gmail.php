<?php

/**
 * @author Ryan Brodkin ryan@glabstudios.com
 * @package Codeigniter
 * @copyright  Copyright 2010 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
      * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once 'Zend/Oauth.php';
require_once 'Zend/Oauth/Config.php';
require_once 'Zend/Oauth/Token/Access.php';
require_once 'Zend/Mail/Protocol/Imap.php';
require_once 'Zend/Mail/Storage/Imap.php';

class Gmail
{
	private $consumer_key;
	private $consumer_secret;
	private $email_address;

	private $imap_storage;
	private $imap_protocol;

	private $thread_id;
	private $unique_id;

	function __construct($consumer_key_or_config=null, $consumer_secret=null)
	{
		if (is_array($consumer_key_or_config) === true)
		{
			$this->consumer_key = element('consumer_key', $consumer_key_or_config);
			$this->consumer_secret = element('consumer_secret', $consumer_key_or_config);
		}
		elseif (isset($consumer_key_or_config, $consumer_secret) === true)
		{
			$this->consumer_key = $consumer_key_or_config;
			$this->consumer_secret = $consumer_secret;
		}
		else
		{
			$CI =& get_instance();
			$CI->load->config('googleapi', true, true);
			$config = $CI->config->item('googleapi');

			$this->consumer_key = element('consumer_key', $config);
			$this->consumer_secret = element('consumer_secret', $config);
		}
	}

	function connect($email_address=null)
	{
		if (isset($email_address) === true)
		{
			$this->email_address = $email_address;
		}
		else
		{
			log_message('error', 'Gmail: Email address is required for method connect.');
			exit;
		}

		/**
		 * Setup OAuth
		 */
		$options = array(
		    'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER,
		    'version' => '1.0',
		    'signatureMethod' => 'HMAC-SHA1',
		    'consumerKey' => $this->consumer_key,
		    'consumerSecret' => $this->consumer_secret
		);

		$config = new Zend_Oauth_Config();
		$config->setOptions($options);
		$config->setToken(new Zend_Oauth_Token_Access());
		$config->setRequestMethod('GET');
		$url = 'https://mail.google.com/mail/b/' .
		       $this->email_address .
		       '/imap/';
		$urlWithXoauth = $url .
		                 '?xoauth_requestor_id=' .
		                 urlencode($this->email_address);

		$httpUtility = new Zend_Oauth_Http_Utility();

		/**
		 * Get an unsorted array of oauth params,
		 * including the signature based off those params.
		 */
		$params = $httpUtility->assembleParams(
		    $url,
		    $config,
		    array('xoauth_requestor_id' => $this->email_address));

		/**
		 * Sort parameters based on their names, as required
		 * by OAuth.
		 */
		ksort($params);

		/**
		 * Construct a comma-deliminated,ordered,quoted list of
		 * OAuth params as required by XOAUTH.
		 *
		 * Example: oauth_param1="foo",oauth_param2="bar"
		 */
		$first = true;
		$oauthParams = '';
		foreach ($params as $key => $value) {
		  // only include standard oauth params
		  if (strpos($key, 'oauth_') === 0) {
		    if (!$first) {
		      $oauthParams .= ',';
		    }
		    $oauthParams .= $key . '="' . urlencode($value) . '"';
		    $first = false;
		  }
		}

		/**
		 * Generate SASL client request, using base64 encoded
		 * OAuth params
		 */
		$initClientRequest = 'GET ' . $urlWithXoauth . ' ' . $oauthParams;
		$initClientRequestEncoded = base64_encode($initClientRequest);

		/**
		 * Make the IMAP connection and send the auth request
		 */
		$imap = new Zend_Mail_Protocol_Imap('imap.gmail.com', '993', true);
		$authenticateParams = array('XOAUTH', $initClientRequestEncoded);
		$imap->requestAndResponse('AUTHENTICATE', $authenticateParams);

		$this->imap_protocol = $imap;
		$this->imap_storage = new Zend_Mail_Storage_Imap($imap);

		return $this;
	}

	function get_server_capabilities()
	{
		return $this->imap_protocol->capability();
	}

	function get_email_address()
	{
		return $this->email_address;
	}

	/*function get_labels($key)
	{
		if (isset($this->thread_id[$key]) !== true)
		{
			$data = $this->imap_protocol->fetch('X-GM-LABELS', $key);
			$this->thread_id[$key] = $data;
		}

		return $this->thread_id[$key];
	}*/

	function get_key($uniqueid)
	{
		return $this->imap_storage->getNumberByUniqueId($uniqueid);
	}

	function get_message($id)
	{
		return $this->imap_storage->getMessage($id);
	}

	function get_message_count()
	{
		return $this->imap_storage->countMessages();
	}

	function get_messages($limit, $uniqueid=null)
	{
		$messages = array();
		$count = $this->imap_storage->countMessages();
		$key = $count;

		if (isset($uniqueid) === true)
		{
			$offset = $this->get_key($uniqueid);
			$limit = $count-$offset;
		}

		for ($i = 1; $i <= $count && $i <= $limit; $i++ ){
			$messages[$key] = $this->imap_storage->getMessage($key);
			$key--;
		}

		return $messages;
	}

	function get_thread_id($key)
	{
		if (isset($this->thread_id[$key]) !== true)
		{
			$this->thread_id[$key] = $this->imap_protocol->fetch('X-GM-THRID', $key);
		}

		return $this->thread_id[$key];
	}

	function get_unique_id($key)
	{
		if (isset($this->unique_id[$key]) !== true)
		{
			$data = $this->imap_storage->getUniqueId($key);

			if (is_array($data) === true)
			{
				$this->unique_id[$key] = implode(',', $data);
			}
			else
			{
				$this->unique_id[$key] = (string) $data;
			}
		}

		return $this->unique_id[$key];
	}

	function move_message($uniqueid, $label)
	{
		return $this->imap_storage->moveMessage($this->get_key($uniqueid), '[Gmail]/'.$label);
	}

	/*function remove_label($uniqueid,$label)
	{
		var_dump( $this->imap_protocol->requestAndResponse('STORE '.$this->get_key($uniqueid).' -X-GM-LABELS ('.$label.')')   );
	}*/

	function remove_message($uniqueid)
	{
		return $this->imap_storage->removeMessage($this->get_key($uniqueid));
	}

}