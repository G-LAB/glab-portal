<?php

/**
 * AJAX Request Controller for G LAB Company Portal
 *
 * @author Ryan Brodkin
 * @copyright G LAB. All rights reserved.
 * @package CodeIgniter
 */


class Ajax extends CI_Controller
{
	function __constructor ()
	{
		//$this->input->is_ajax_request()
		parent::__constructor();
	}

	/**
	 * Remap Request to API
	 */
	function _remap ()
	{
		$method = $this->input->server('REQUEST_METHOD');
		$uri = implode( array_slice( $this->uri->rsegment_array(), 1), '/');
		$params = $_REQUEST;

		$this->_process_request($method, $uri, $params);
	}

	/**
	 * Output JSON
	 */
	function _process_request($method, $uri, $params)
	{
		$result = $this->api->request(strtolower($method), $uri, $params);
		echo json_encode($result);
	}

}