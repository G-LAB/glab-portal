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
  </div>
</div>
<div class="row">
  <div class="span7 offset1">
    <form action="<?=current_url()?>"  method="post" class="form-vertical">
      <legend>Choose an Authentication Method</legend>
      <fieldset class="control-group">
        <div class="controls visible-desktop">
          <label for="otp">Yubikey One-Time Password</label>
          <div class="input-prepend">
            <span class="add-on"><input type="radio" name="method" id="method" value="yubikey" checked></span><input class="span4" id="otp" name="otp" size="32" type="text" autocomplete="off" autofocus>
          </div>
        </div>
        <div class="controls hidden-desktop">
          <label for="authcode">Device Activation Code</label>
          <div class="input-prepend">
            <span class="add-on"><input type="radio" name="method" id="method" value="authcode"></span><input class="span4" id="authcode" name="authcode" size="32" type="text">
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
        <button type="submit" class="btn btn-primary">Login</button>
      </fieldset>
    </form>
  </div>
  <div class="span3">
    <h2>Multifactor Authentication</h2>
    <p>The sensitive data stored in this system is kept secure by combining information that you know, such as your password, with something that you have, such as a Yubikey one-time password or mobile device.</p>
  </div>
</div>
<div class="row">
  <div class="span10 offset1">
    <p class="legal">
      This system and all related information accessed thereby is the property of G LAB, and is for the sole use of those persons expressly authorized by G LAB. Continued use of this system implies consent to monitoring and an understanding that recording and/or disclosure of any data on the system may occur at G LAB's discretion. &nbsp;By logging into and using this website, I agree to the Terms of Use and Legal Terms and Conditions of this website and to any other terms and conditions that may be set forth on the individual pages of this website.
    </p>
  </div>
</div>