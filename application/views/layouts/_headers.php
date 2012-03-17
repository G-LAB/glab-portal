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
<link rel="apple-touch-icon-precomposed" href="/assets/theme/img/icon.png">
<link rel="apple-touch-startup-image" href="/assets/theme/img/startup.png')?>">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1">

<!-- Google Fonts -->
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400">

<!-- Twitter Bootstrap CSS -->
<link rel="stylesheet" href="/assets/bootstrap/docs/assets/css/bootstrap.css">

<!-- G LAB CSS -->
<link rel="stylesheet" href="/assets/global/css/global.css">
<link rel="stylesheet" href="/assets/css/style.css">

<!-- Favicon -->
<link rel="shortcut icon" href="/assets/img/favicon.ico')?>">

<!-- Async Loading -->
<script src="/assets/js/modernizr.custom.js"></script>
<script src="/assets/js/init.js"></script>

<!-- Microformats -->
<link rel="profile" href="//microformats.org/profile/hcard">