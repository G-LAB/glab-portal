<div class="row">
	<div class="span7 offset1">
		<form action="<?=current_url()?>"  method="post">
			<legend>Choose an Authentication Method</legend>
			<fieldset class="control-group">
				<div class="controls">
					<label for="otp">Yubikey One-Time Password</label>
					<div class="input">
						<div class="input-prepend">
							<span class="add-on"><input type="radio" name="method" id="method" value="yubikey" checked></span>
							<input class="x-large" id="otp" name="otp" size="32" type="text" autocomplete="off" autofocus>
						</div>
					</div>
				</div>
				<div class="controls">
					<label for="authcode">Device Activation Code</label>
					<div class="input-prepend">
						<span class="add-on"><input type="radio" name="method" id="method" value="authcode"></span>
						<input class="x-large" id="authcode" name="authcode" size="32" type="text">
					</div>
				</div>
				<div class="controls">
					<label>Other Options</label>
					<label class="radio">
						<input type="radio" name="method" value="sms" disabled>
						<span>Send an authorization code via text message.</span>
					</label>
					<label class="radio">
						<input type="radio" name="method" value="phone" disabled>
						<span>Call me to verify my identity by phone.</span>
					</label>
				</div>
			</fieldset>
			<fieldset class="form-actions">
				<button type="submit" class="btn primary">Login</button>&nbsp;
				<a href="<?=site_url('login/destroy')?>" class="btn">Cancel</a>
			</fieldset>
		</form>
	</div>
	<div class="span3">
		<h2>Multifactor Authentication</h2>
		<p>The sensitive data stored in this system is kept secure by combining information that you know, such as your password, with something that you have, such as a Yubikey one-time password or mobile device.</p>
	</div>
</div>