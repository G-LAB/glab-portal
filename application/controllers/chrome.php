<?php

class Chrome extends CI_Controller
{
  function index ()
  {
    $this->load->helper('glib_file');
    $this->template->build('chrome/main');
  }
}