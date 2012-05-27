<br>
<div class="row-fluid">
  <div class="span12">
    <div id="welcome" class="hero-unit">
      <h1>Welcome!</h1>
      <p>This is the portal, your virtual desk at G&nbsp;LAB.</p>
      <p>
        <a href="<?=site_url('welcome')?>" class="btn btn-large">Take Tour</a>
        <a id="btn_welcome_hide" class="btn btn-primary btn-large">Get Started</a>
      </p>
      <div>
        <label class="checkbox">
          <input type="checkbox" id="welcome_hide">
          Don't show this message again.
        </label>
      </div>
    </div>
    <div id="hud" class="hero-unit">
      <div id="slider">
        Other content shows up here
      </div>
    </div>
  </div>
</div>
<!-- Chrome Application -->
<section id="alert_chrome" style="display: none">
  <div class="row-fluid">
    <div class="span12">
      <div class="alert alert-info alert-block">
        <a class="close" data-dismiss="alert">&times;</a>
        <div class="pull-right">
          <a href="<?=site_url('chrome')?>" class="btn btn-large">Learn More</a>
          <button id="btn_app_install" class="btn-large btn-primary">Add to Chrome</button>
        </div>
        <h3 class="alert-heading">Install the G LAB Portal for Google Chrome</h3>
        Enjoy faster speeds and a better user experience.
      </div>
    </div>
  </div>
</section>

<!-- Gmail Inbox -->
<section id="inbox">
  <div class="row-fluid">
    <div class="span4">
      <h1>
        Inbox
        <small><?=$gmail->get_email_address()?></small>
      </h1>
    </div>
    <div class="span2">
      <div id="message_count">
        <span class="shown">0</span> of
        <span class="total">0</span> Messages
        <i class="icon-refresh" id="btn_inbox_refresh" data-action="inbox-refresh" title="Check for New Mail"></i>
      </div>
    </div>
    <div class="span6">
      <div class="btn-toolbar">
        <div class="btn-group pull-left">
          <a class="btn" data-action="inbox-archive" title="Archive Messages"><i class="icon-folder-open"></i> Archive</a>
          <a class="btn" data-action="inbox-spam" title="Mark Messages as Spam"><i class="icon-exclamation-sign"></i> Spam</a>
          <a class="btn" data-action="inbox-archive" title="Delete Messages Permanently"><i class="icon-trash"></i> Trash</a>
        </div>
      </div>
      <a href="http://webmail.glabstudios.com/" target="_blank" class="btn pull-right">
        <i class="icon-envelope"></i>
        Open Gmail
      </a>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">
      <table class="table color-text">
        <thead>
          <tr>
            <th></th>
            <th class="span1"></th>
            <th>From</th>
            <th class="span9">Subject</th>
            <th>Received</th>
          </tr>
        </thead>
        <tbody>
          <tr class="message-empty">
            <td colspan="5"><strong>Awesome!</strong> Inbox-zero, baby... You're an email-answering machine!</td>
          </tr>
        </tbody>
      </table>
      <script type="text/html" id="inbox_row">
        <tr data-unique-id="{{uniqueid}}" data-thread-id="{{thread_id}}" class="message {{#flag_unread}}inbox-flag-unread{{/flag_unread}} {{#flag_replied}}inbox-flag-replied{{/flag_replied}} {{#flag_starred}}inbox-flag-starred{{/flag_starred}}">
          <td>
            <input type="checkbox">
          </td>
          <td class="inbox-flags">
            <!-- Stars -->
            <i class="icon-star" title="Starred" rel="tooltip"></i>
            <i class="icon-star-empty" title="Unstarred" rel="tooltip"></i>

            <!-- Replied -->
            <i class="icon-share-alt" title="Reply Sent" rel="tooltip"></i>
          </td>
          <td>
            <span rel="tooltip" title="{{sender_email}}">{{sender_name}}</span>
          </td>
          <td class="inbox-subject">
            <a href="{{thread_url}}" target="_blank">{{subject}}</a>
          </td>
          <td class="inbox-received">
            <time datetime="{{date_timestamp}}">{{date_friendly}}</time>
          </td>
        </tr>
      </script>
    </div>
  </div>
</section>