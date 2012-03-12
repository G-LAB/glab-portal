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

<!-- Google Map -->
<div class="modal fade" id="modal_map">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Google Map</h3>
	</div>
	<div class="modal-body">
		<div id="modal_map_gmap" class="gmap"></div>
	</div>
</div>

<!-- Google Directions -->
<div class="modal fade" id="modal_directions">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Driving Directions</h3>
		<div class="row">
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="span5">
				<div id="modal_directions_form">
					<form class="form-vertical">
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="origin">Origin</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="origin">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="destination">Destination</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="destination">
								</div>
							</div>
							<div class="form-actions">
							<button class="btn btn-primary action-directions-submit">Get Directions</button>
							</div>
						</fieldset>
					</form>
				</div>
				<div id="modal_directions_list"></div>
			</div>
			<div id="modal_directions_gmap" class="span7 gmap"></div>
		</div>
		<div class="modal-footer"></div>
	</div>
</div>