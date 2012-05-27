<div class="row">
  <section class="span12">
    <form class="form-horizontal">
      <fieldset>
        <legend>Locale Settings</legend>
        <div class="control-group">
          <label class="control-label" for="time_zone">Time Zone</label>
          <div class="controls">
            <?=timezone_menu(set_value('time_zone',$profile->meta->time_zone))?>
            <p class="help-block">We'll use this to display dates and times in your local time.</p>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="time_zone">Time Format</label>
          <div class="controls">
            <label class="checkbox inline">
              <input name="time_format" type="radio" value="12" <?=set_radio('time_format', '12', ($profile->meta->time_format == 12) ? true : false)?>> <strong>12-Hour</strong> <?=date('g:i a')?>
            </label>
            <label class="checkbox inline">
              <input name="time_format" type="radio" value="24" <?=set_radio('time_format', '12', ($profile->meta->time_format == 24) ? true : false)?>> <strong>24-Hour</strong> <?=date('H:i')?>
            </label>
          </div>
        </div>
      </fieldset>
    </form>
  </section>
</div>
<h2>Device Management</h2>
<div class="row">
  <section class="span12">
    <form>
      <fieldset>
        <legend>My Devices</legend>
        <table class="table">
          <thead>
            <tr>
              <th>Device Type</th>
              <th>Activation Date</th>
              <th>Last Access</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>iPod Touch</td>
              <td>January 23, 2012</td>
              <td>3 days ago</td>
              <td>
                <a class="btn btn-mini btn-danger">
                  <i class="icon-remove icon-white"></i>
                  Remove Device
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </fieldset>
      <fieldset>
        <legend>Activate a Device</legend>
        <br>
        <p class="span 8">If you would like to associate a supported device, such as an tablet computer, with this account you have the option of activating it using an authorization code. &nbsp;Once activated, the device will be given direct access to your account without use of the Yubikey hardware.  Such devices should not be shared with others due to the sensitive nature of the information contained in this system.</p>
        <div class="clearfix"></div>
        <div class="form-actions">
          <div id="device_request" class="span3">
            <a class="btn btn-large btn-success">Generate Activation Code</a>
          </div>
          <div id="device_loading" class="span5">
            <div class="progress progress-info progress-striped active">
              <div class="bar" style="width: 100%"></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div id="device_response">
            <h3>
              Here's Your Authorization Code!
              <small>Careful, it's hot!!!</small>
            </h3>
            <div class="alert alert-warning">
              <strong>NOTE:</strong> This code will expire in 10 minutes if unused.
            </div>
            <input type="text" id="authcode" value="550e8400-e29b-41d4-a716-446655440000" class="span6" disabled>
            <p class="help-block">Just navigate to the portal using your device's web browser and enter the authorization code in step 2, after you have logged in using your G LAB Google account.</p>
          </div>
        </div>
      </fieldset>
    </form>
  </section>
</div>