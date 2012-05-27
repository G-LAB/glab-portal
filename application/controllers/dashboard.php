<?php

/**
 * Dashboard Controller for G LAB Company Portal
 *
 * @author Ryan Brodkin
 * @copyright G LAB. All rights reserved.
 * @package CodeIgniter
 */


class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    /* Gmail Inbox */
    $this->load->library('Gmail');
    $this->template->set('gmail', $this->gmail->connect('ryan@glabstudios.com'));
  }


  /**
   * Display Dashboard
   */
  function index()
  {
    $this->template->build('dashboard/main');
  }

  function inbox_action($uniqueid, $action)
  {
    switch ($action) {
      case 'archive':
        $this->gmail->move_message($uniqueid, 'All Mail');
        break;

      case 'spam':
        $this->gmail->move_message($uniqueid, 'Spam');
        break;

      case 'trash':
        $this->gmail->move_message($uniqueid, 'Trash');
        break;
    }
  }

  function inbox_feed($limit,$uniqueid=null)
  {
    $data = $this->gmail->get_messages($limit,$uniqueid);

    $messages=array();
    foreach ($data as $key=>$message)
    {
      $time = strtotime($message->date);

      $sender = $message->from;
      $sender_name = trim(substr($sender, 0, strrpos($sender,'<')));
      $sender_email = trim(substr($sender, strrpos($sender,'<')),'<> ');

      $m['uniqueid'] = $this->gmail->get_unique_id($key);
      $m['thread_id'] = $this->gmail->get_thread_id($key);
      $m['thread_url'] = 'http://webmail.glabstudios.com/#inbox/'.dechex($m['thread_id']);
      $m['flag_replied'] = $message->hasFlag(Zend_Mail_Storage::FLAG_ANSWERED);
      $m['flag_starred'] = $message->hasFlag(Zend_Mail_Storage::FLAG_FLAGGED);
      $m['flag_unread'] = !$message->hasFlag(Zend_Mail_Storage::FLAG_SEEN);
      $m['sender_name'] = (empty($sender_name)) ? $sender_email : $sender_name;
      $m['sender_email'] = $sender_email;
      $m['subject'] = $message->subject;
      $m['date_friendly'] = (date('mdy',$time) === date('mdy')) ? date('g:i',$time) : date('M j',$time);
      $m['date_timestamp'] = standard_date('DATE_W3C',$time);

      $messages[] = $m;
    }

    $feed = array(
      'count_total' => $this->gmail->get_message_count(),
      'messages' => $messages
    );

    echo json_encode($feed);
  }

}