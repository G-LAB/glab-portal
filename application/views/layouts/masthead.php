<!doctype html>
<!--[if IE 6]><![endif]-->
<html lang="en-us">
<head>
	<?=$template['partials']['headers']?>
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
					<div class="span8">
						<h1><?=htmlspecialchars($template['title'])?></h1>
					</div>
					<?php if ($this->acl->is_auth() !== true AND $this->router->fetch_method() !== 'multifactor') : ?>
					<div id="login" class="span4 justr">
						<button id="btn-login" class="btn primary">Login via <img src="/assets/img/google_logo_18.png" alt="Google Logo"></button>
					</div>
					<?php endif; ?>
				</div>
				<div class="row">
					<div class="span12">
						<?php foreach (User_Notice::fetch_array() as $notice) : ?>
						<div class="alert alert-<?=$notice->type?>">
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
</body>
</html>