<!doctype html>
<!--[if IE 6]><![endif]-->
<html lang="en-us">
<head>
	<?=$template['partials']['headers']?>
	<?=$template['metadata']?>
</head>
<body id="default" class="<?=strtolower($this->router->fetch_class().' '.$this->router->fetch_method())?>">
	<div class="container">
		<header id="header">
			<?=$template['partials']['menu']?>
		</header>
		<header id="hud">
			<?=$template['partials']['hud']?>
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
	<div id="modal_timeout" class="modal fade ui-helper-hidden">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">×</a>
			<h3>Session Expiration Warning</h3>
		</div>
		<div class="modal-body">
			<p>Your session is about to be terminated due to inactivity...</p>
		</div>
		<div class="modal-footer">
			<a class="btn primary" data-dismiss="modal">Stay Signed In</a>
			<a href="<?=site_url('login/destroy')?>" class="btn">Logout</a>
		</div>
	</div>
</body>
</html>