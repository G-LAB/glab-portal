<div class="row">
	<div class="span10 offset1">
		<?php if (isset ($timeout) === true AND $timeout == true) : ?>
		<div class="alert alert-block alert-error">
			<div class="alert-heading"><strong>You have been logged out due to inactivity.</strong></div>
			Sessions are ended automatically after <?=$sess_expiration?> if the portal is left unused.
		</div>
		<?php elseif (isset ($timeout) === true AND $timeout == false) : ?>
		<div class="alert alert-success">
			<strong>Success!</strong> You have been logged out successfully.
		</div>
		<?php endif; ?>
		<p class="legal">
			This system and all related information accessed thereby is the property of G LAB, and is for the sole use of those persons expressly authorized by G LAB. Continued use of this system implies consent to monitoring and an understanding that recording and/or disclosure of any data on the system may occur at G LAB's discretion. &nbsp;By logging into and using this website, I agree to the Terms of Use and Legal Terms and Conditions of this website and to any other terms and conditions that may be set forth on the individual pages of this website.
		</p>
	</div>
</div>