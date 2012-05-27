<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'config/config.php';

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = 'index.php';

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|  0 = Disables logging, Error logging TURNED OFF
|  1 = Error Messages (including PHP errors)
|  2 = Debug Messages
|  3 = Informational Messages
|  4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 2;


/* End of file config.php */
/* Location: ./application/config/config.php */
