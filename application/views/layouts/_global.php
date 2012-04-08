<!-- GLOBALLY SHARED CONTENT -->
<div id="global">
	<!-- Session Timout Modal -->
	<div id="modal_timeout" class="modal hide fade">
		<div class="modal-header">
			<a href="#" class="close" data-dismiss="modal">×</a>
			<h3>Session Expiration Warning</h3>
		</div>
		<div class="modal-body">
			<p>Your session will be terminated in <span class="counter"></span> seconds due to inactivity...</p>
		</div>
		<div class="modal-footer">
			<a class="btn btn-primary" data-dismiss="modal">Stay Signed In</a>
			<a href="<?=site_url('login/destroy')?>" class="btn">Logout</a>
		</div>
	</div>

	<!-- Loading Overlay -->
	<div id="overlay_loading">
		<div class="modal-backdrop in"></div>
		<div class="modal hide fade in">
			<div class="modal-header">
				<h3>Please Wait, Loading...</h3>
			</div>
			<div class="modal-body">
				<div class="progress progress-striped active">
					<div id="loading_bar" class="bar" style="width: 100%;"></div>
				</div>
				<p id="loading_file">Downloading Files...</p>
			</div>
		</div>
	</div>

	<!-- Google Map Modal -->
	<div class="modal hide fade" id="modal_map">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Google Map</h3>
		</div>
		<div class="modal-body">
			<div id="modal_map_gmap" class="gmap"></div>
		</div>
	</div>

	<!-- Google Directions Modal -->
	<div class="modal hide fade" id="modal_directions">
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
								<button id="modal_directions_submit" class="btn btn-primary">Get Directions</button>
								</div>
							</fieldset>
						</form>
					</div>
					<div id="modal_directions_list"></div>
				</div>
				<div id="modal_directions_gmap" class="span7 gmap"></div>
			</div>
		</div>
	</div>
</div>