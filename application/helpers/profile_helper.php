<?php

function profile_url ($pid)
{
  $CI =& get_instance();

  $CI->load->helper('url');

  $profile = $CI->profile->get($pid);

  if ($profile->exists() === true)
  {
    return site_url('client_profile/'.$profile->pid_hex);
  }
  else
  {
    return false;
  }
}

function profile_link ($pid, $name_type='full')
{
  $CI =& get_instance();

  $CI->load->helper('url');

  $profile = $CI->profile->get($pid);

  if ($profile->exists() === true)
  {
    return '<a href="'.profile_url($pid).'" data-pid="'.$profile->pid.'">'.$profile->name->{$name_type}.'</a>';
  }
  else
  {
    return false;
  }
}

// End of file.