<!doctype html>
<!--[if IE 6]><![endif]-->
<html lang="en-us">
<head>
	<meta charset="utf-8">
	
	<title>G LAB (portal) :: <?=$template['title']?></title>
	
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
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans:regular,bold">

	<!-- Twitter Bootstrap CSS -->
	<link rel="stylesheet" href="<?=site_url('asset/bootstrap/bootstrap.css')?>">

	<!-- G LAB CSS -->
	<link rel="stylesheet" href="<?=site_url('asset/global/css/style.css')?>">
	<link rel="stylesheet" href="<?=site_url('asset/css/style.css')?>">
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?=site_url('asset/img/favicon.ico')?>">
	
	<!-- Async JS Loading -->
	<script src="<?=site_url('asset/js/modernizr.custom.20925.js')?>"></script>
	<script>
		Modernizr.load([
			{
				load: [
					'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js',
					'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js'
				],
				complete: function () 
				{
					if (!window.jQuery) 
					{
						Modernizr.load('https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.6.4.min.js');
					}

					if (!window.jQuery.ui) 
					{
						Modernizr.load('https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.12/jquery-ui.min.js');
					}
				}
			}
		]);
	</script>

	<?=$template['metadata']?>
	
</head>
<body>
	<div class="container-fluid">
		<header>
			Header
		</header>
		<div>
			<nav>
				<?=$template['partials']['menu']?>
			</nav>
			<section id="content">
				<?=$template['body']?>
			</section>
			<section>
				<?=$template['partials']['side']?>
			</section>
		</div>
		<footer>
			<?=$template['partials']['footer']?>
		</footer>
	</div>

</body>
</html>