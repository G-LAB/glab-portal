<!doctype html>
<!--[if IE 6]><![endif]-->
<html lang="en-us">
<head>
	<?=$template['partials']['headers']?>

	<!-- Async Loading -->
	<script>
		Modernizr.load([
			{
				load: [
					'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
					'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'
				],
				complete: function ()
				{
					if (!window.jQuery)
					{
						Modernizr.load('https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js');
					}

					if (!window.jQuery.ui)
					{
						Modernizr.load('https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.16/jquery-ui.min.js');
					}

					Modernizr.load({
						load: [
							'<?=site_url('asset/bootstrap/js/bootstrap-alerts.js')?>',
							'<?=site_url('asset/bootstrap/js/bootstrap-buttons.js')?>',
							'<?=site_url('asset/bootstrap/js/bootstrap-dropdown.js')?>',
							'<?=site_url('asset/bootstrap/js/bootstrap-modal.js')?>',
							'<?=site_url('asset/bootstrap/js/bootstrap-tabs.js')?>',
							'<?=site_url('asset/global/js/global.js')?>',
							'<?=site_url('asset/js/script.js')?>'
						]
					});
				}
			}
		]);
	</script>

	<?=$template['metadata']?>

</head>
<body id="masthead" class="<?=strtolower($this->router->fetch_class().' '.$this->router->fetch_method())?>">
	<div class="container">
		<header id="header">
			<?=$template['partials']['menu']?>
		</header>
		<div id="main">
			<section>
				<div id="heading" class="row">
					<div class="span-two-thirds">
						<h2><?=htmlspecialchars($template['title'])?></h2>
					</div>
					<?php if ($this->acl->is_auth() !== true AND $this->router->fetch_method() !== 'multifactor') : ?>
					<div id="login" class="span-one-third justr">
						<button id="btn-login" class="btn primary">Login via Google</button>
					</div>
					<?php endif; ?>
				</div>
				<div class="row">
					<div class="span16">
						<?php foreach (User_Notice::fetch_array() as $notice) : ?>
						<div class="alert-message <?=$notice->type?>">
							<a class="close">×</a>
							<strong><?=$notice->title?></strong> <?=$notice->msg?>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?=$template['body']?>
			</section>

		</div>
		<footer id="footer">
			<?=$template['partials']['footer']?>
		</footer>
	</div>
	<div id="overlay-loading">
		<div class="ui-overlay">
		    <div class="ui-widget-overlay"></div>
		    <div class="overlay-container">
			    <div class="ui-widget-shadow ui-corner-all"></div>
			    <div class="ui-widget ui-widget-content ui-corner-all">
					<img src="<?=site_url('asset/img/loading_bar.gif')?>">
					<p>Loading</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>