<?php

/**
 * Errors Controller for G LAB Company Portal
 *
 * @author Ryan Brodkin
 * @copyright G LAB. All rights reserved.
 * @package CodeIgniter
 */


class Errors extends CI_Controller
{

  function __construct () {
    parent::__construct();

    $this->template->set_layout('masthead');
  }

  /**
   * Displays welcome page
   */
  function error_404()
  {
    $this->template->title('Page Not Found')->build('errors/404');
  }

}