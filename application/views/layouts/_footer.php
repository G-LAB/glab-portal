<div class="row">
	<div class="span6">
		Copyright &copy; 2009-<?=date('Y')?> G LAB. &nbsp;All rights reserved.
	</div>
	<div class="span6 justr">
		<?=(ENVIRONMENT == 'development') ? shell_exec('cd '.APPPATH.' && git name-rev --name-only HEAD').'/' : 'Revision'?>
		<?=shell_exec('cd '.APPPATH.' && git rev-parse --short HEAD')?>
	</div>
</div>

<!-- GLOBALLY SHARED CONTENT -->

<!-- Loading Overlay -->
<div id="overlay-loading">
	<div class="ui-overlay">
		<div class="ui-widget-overlay"></div>
		<div class="overlay-container">
			<div class="ui-widget-shadow ui-corner-all"></div>
			<div class="ui-widget ui-widget-content ui-corner-all">
				<img src="/assets/img/loading_bar.gif">
				<p>Loading</p>
			</div>
		</div>
	</div>
</div>