<div class="row">
	<div class="span11">
		<form action="<?=current_url()?>"  method="post" class="form-stacked">
			<fieldset>
				<legend>Choose an Authentication Method</legend>
				<div class="clearfix">
					<label for="otp">Yubikey One-Time Password</label>
					<div class="input">
						<div class="input-prepend">
							<label class="add-on"><input type="radio" name="method" id="method" value="yubikey" checked></label>
							<input class="x-large" id="otp" name="otp" size="32" type="text" autocomplete="off">
						</div>
					</div>
				</div><!-- /clearfix -->
				<div class="clearfix">
					<label for="authcode">iPad Activation Code</label>
					<div class="input">
						<div class="input-prepend">
							<label class="add-on"><input type="radio" name="method" id="method" value="authcode"></label>
							<input class="x-large" id="authcode" name="authcode" size="32" type="text">
						</div>
					</div>
				</div><!-- /clearfix -->
				<div class="clearfix">
					<label id="optionsCheckboxes">Other Options</label>
					<div class="input">
						<ul class="inputs-list">
							<li>
								<label>
									<input type="radio" name="method" value="sms" disabled>
									<span>Send an authorization code via text message.</span>
								</label>
							</li>
							<li>
								<label>
									<input type="radio" name="method" value="phone" disabled>
									<span>Call me to verify my identity by phone.</span>
								</label>
							</li>
						</ul>
					</div>
				</div><!-- /clearfix -->
			</fieldset>
			<div class="actions">
				<button type="submit" class="btn primary">Login</button>&nbsp;<a href="<?=site_url()?>" class="btn">Cancel</a>
			</div>
		</form>
	</div>
	<div class="span4">
		<h2>Multifactor Authentication</h2>
		<p>The sensitive data stored in this system is kept secure by combining information that you know, such as your password, with something that you have, such as a Yubikey one-time password or mobile device.</p>
	</div>
</div>

<script>
	$(document).ready(function()
	{

	});
</script>