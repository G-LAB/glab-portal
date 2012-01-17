<meta charset="utf-8">

<title>
	G LAB Portal :: 
	<?=htmlspecialchars(controller_name())?>
	<?php
		if ($template['title'] !== ' ')
		{
			echo ' : '.htmlspecialchars($template['title']);
		}
		elseif (strtolower(method_name()) !== 'index')
		{
			echo ' : '.htmlspecialchars(method_name());
		}
	?>
</title>

<meta name="author" content="glabstudios.com">

<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<!-- Apple iOS and Android -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon-precomposed" href="<?=site_url('asset/theme/img/icon.png')?>">
<link rel="apple-touch-startup-image" href="<?=site_url('asset/theme/img/startup.png')?>">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1">

<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400">

<!-- Twitter Bootstrap CSS -->
<link rel="stylesheet" href="<?=site_url('asset/bootstrap/bootstrap.css')?>">

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="<?=site_url('asset/jquery-ui/jquery-ui-1.8.16.custom.css')?>">

<!-- G LAB CSS -->
<link rel="stylesheet" href="<?=site_url('asset/global/css/global.css')?>">
<link rel="stylesheet" href="<?=site_url('asset/css/style.css')?>">

<!-- Favicon -->
<link rel="shortcut icon" href="<?=site_url('asset/img/favicon.ico')?>">

<!-- Async Loading -->
<script src="<?=site_url('asset/js/modernizr.custom.js')?>"></script>
<script src="<?=site_url('asset/js/init.js')?>"></script>