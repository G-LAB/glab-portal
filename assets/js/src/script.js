/*global bootbox: false, google: false, Helper:false, ich: false, Modernizr: false */

var GLAB = {};
GLAB.cookie = new Helper.cookie();

// Base URL of Installation
var siteURL = decodeURIComponent(GLAB.cookie.get('ci_siteurl')) + '/';
// CodeIgniter Session Expiration
var ciSessionexpire;
// Number of AJAX requests loading data
var loadingCount = 0;
// Google Maps for Modals
var mapModalMap;
var mapDirectionsService;
var mapDirectionsRenderer;
var mapDirectionsMap;

/**
 * Class for G LAB Portal
 */
var Portal = function() {};

/**
 * Convert map classes to Google Maps
 */
Portal.prototype.gmapBind = function() {
  jQuery('.map').each(function() {
    var lat, lng;
    var element = jQuery(this);
    var geocoder = new google.maps.Geocoder();

    // Draw Map
    var map = new google.maps.Map(this, {
      zoom: 14,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // Declared Latitude and Longitude
    if (element.data('latlng') !== undefined) {
      var latlng = element.data('latlng').split(',', 2);
      lat = latlng[0];
      lng = latlng[1];
      map.setCenter(new google.maps.LatLng(lat, lng));
    }

    // Declared Address
    else if (element.data('address') !== undefined)
    {
      geocoder.geocode({ 'address': element.data('address')},
      function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
          });
        }
      });
    }
  });
};

/**
 * Google Maps API Callback
 */
Portal.prototype.gmapInit = function() {
  /* Basic Map in Modal */
  mapModalMap = new google.maps.Map(document.getElementById('modal_map_gmap'), {
    zoom: 14,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  /* Directions in Modal */
  mapDirectionsService = new google.maps.DirectionsService();
  mapDirectionsRenderer = new google.maps.DirectionsRenderer();
  mapDirectionsMap = new google.maps.Map(
    document.getElementById('modal_directions_gmap'),
    {
      zoom: 9,
      center: new google.maps.LatLng(34.05, -118.24),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
  );
  mapDirectionsRenderer.setMap(mapDirectionsMap);
  mapDirectionsRenderer.setPanel(
    document.getElementById('modal_directions_list')
  );

  /* Bind Map Elements */
  this.gmapBind();
};

/**
 * Hide or Show Loading Overlay
 * @param  {string|bool} mode Two modes, true/'show' and false/'hide'.
 */
Portal.prototype.overlay = function(mode) {
  var overlay = jQuery('#overlay_loading');

  if (mode === 'show' || mode === true)
  {
    jQuery('#overlay_loading_progress').css({width: '100%'});
    jQuery('#overlay_loading_text').text('  ');
    overlay.fadeIn('slow');
  }
  else if (mode === 'hide' || mode === false)
  {
    overlay.fadeOut('fast');
  }
};

/**
 * Hide or Show Loading Bar
 * @param  {bool|string} mode Two modes, true/'show' and false/'hide'.
 */
Portal.prototype.loading = function(mode) {
  var loading = jQuery('#loading_bar');

  // Set Loading Message
  var messages = [];
  messages.push('Reticulating Splines');
  messages.push('Go ahead, hold your breath!');
  messages.push('Hampsters Processing');
  messages.push('Inverting Multipliers');
  messages.push('Please Don\'t Feed the Programmers');
  messages.push('Pretending To Do Something Useful');
  messages.push('Foraging For Objects');
  messages.push('Sarcasm Approaching Critical Levels');
  messages.push('Does anyone read these things?');
  messages.push('Hitting Your Keyboard Won\'t Make This Faster');
  messages.push('Ensuring Everything Works Perfectly');
  messages.push('Spawning Zombie Processes');
  messages.push('Loading Cute Cat Photos');
  messages.push('Can Haz JSON???');
  messages.push('Alright, Which Jokester Stored the Data on a Floppy?');

  if (mode === 'show' || mode === true)
  {
    loadingCount++;
  }
  else if (mode === 'hide' || mode === false)
  {
    loadingCount--;
  }

  // Hide/Show as Necessary
  if (loadingCount > 0)
  {
    var key = Math.floor(Math.random() * messages.length);
    jQuery('#loading_bar_text').text(messages[key]);
    loading.fadeIn('fast');
  }
  else
  {
    loading.fadeOut(1000);
  }
};

/**
 * Send API request to server
 * @param  {string} method  HTTP method to use (GET, POST, PUT or DELETE).
 * @param  {string} uri     Resource where API request will be sent in API.
 * @param  {array|object|string} data   Parameters to be sent with AJAX request.
 * @param {function(object)} callback Function to execute when complete.
 * @return {jQuery}         jQuery AJAX request object.
 */
Portal.prototype.api = function(method, uri, data, callback) {
  return jQuery.ajax({
    type: method,
    url: siteURL + '/ajax/' + uri,
    data: data,
    dataType: 'json',
    complete: callback
  });
};

/**
 * Instanciate Portal Class
 * @type {glab}
 */
Portal = new Portal();

/* Trigger Prepended Radio Buttons */
jQuery('.input-prepend input').on('focus', function() {
  jQuery(this).parent().find('.add-on input[type="radio"]').click();
});

/**
 * Trigger overlay on unload w/ jQuery
 */
jQuery(window).unload(function() {
  Portal.overlay('show');
});
/**
 * Trigger overlay on unload for crankier browsers
 */
window.onbeforeunload = function() {
  Portal.overlay('show');
};

/* Load Assets */
var assets = [
  '/assets/js/dist/bootstrap.min.js',
  '//maps.googleapis.com/maps/api/js?key=AIzaSyAgsnPACf66og7cXNk48Toh6ijmogR3H7E&callback=Portal.gmapInit&sensor=false&v=3.7',
  '/assets/bootbox/bootbox.js',
  '/assets/icanhaz/ICanHaz.min.js'
];

/* Load Bootstrap */
Modernizr.load([
  {
    load: assets,
    callback: function(url, result, key) {
      jQuery('#overlay_loading_progress')
      .css({width: (key / assets.length * 100) + '%'});
      jQuery('#overlay_loading_text').text('Initialized ' + url);
    },
    complete: function() {
      /* Release Hold */
      jQuery.holdReady(false);

      /* Hide Page Loading Overlay */
      Portal.overlay('hide');

      /* Dropdown Menus */
      jQuery('.dropdown-toggle').dropdown();

      /* Alert Message Close Buttons */
      jQuery('.alert-message').alert();

      /* Tabs */
      jQuery('.tabbable').tab();

      /* Enable Tooltips */
      jQuery('a[title], i[title], span[title]').tooltip();

      /* Replace Default System Dialogs */
      window.alert = bootbox.alert;
      window.confirm = bootbox.confirm;

      /* Listen for Google Map Actions */
      jQuery('[data-action="modal-map"]').on('click', function(event) {
        event.preventDefault();

        var trigger = jQuery(this);
        var modal = jQuery('#modal_map');
        var geocoder = new google.maps.Geocoder();
        var address;

        if (
          trigger.data('address') !== undefined &&
          trigger.data('address').substring(0, 1) === '#'
        ) {
          if (jQuery(trigger.data('address')).data('address') !== undefined) {
            address = jQuery(trigger.data('address')).data('address');
          } else {
            address = jQuery(trigger.data('address')).text();
          }
        } else {
          address = trigger.data('address');
        }

        geocoder.geocode({ 'address': address}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            mapModalMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: mapModalMap,
                position: results[0].geometry.location
            });
          } else {
            window.alert(
              'Geocode was not successful for the following reason: ' +
              status
            );
          }
        });

        modal.find('h3').text(address);
        modal.modal('show');
      });

      /* Listen for Google Directions Actions */
      // Modal Show Event
      jQuery('[data-action="modal-directions"]').on('click', function(event) {
        event.preventDefault();

        var trigger = jQuery(this);
        var modal = jQuery('#modal_directions');
        var address;

        if (
          trigger.data('address') !== undefined &&
          trigger.data('address').substring(0, 1) === '#'
        ) {
          if (jQuery(trigger.data('address')).data('address') !== undefined) {
            address = jQuery(trigger.data('address')).data('address');
          } else {
            address = jQuery(trigger.data('address')).text();
          }
        } else {
          address = trigger.data('address');
        }

        // Reset Modal to Original State
        modal.find('#modal_directions_form').show();
        modal.find('#modal_directions_list').hide().empty();
        mapDirectionsMap.setZoom(9);

        // Set Destination Address
        modal.find('#destination').val(address);

        // Show Modal
        modal.modal('show').css({
          'width': '100%',
          'max-width': '650px',
          'margin-left': function() { return -(jQuery(this).width() / 2); }
        });
      });

      // Modal Submit Event
      jQuery('#modal_directions_submit').on('click', function(event) {
        event.preventDefault();

        var modal = jQuery('#modal_directions');

        var origin = modal.find('#origin').val();
        var destination = modal.find('#destination').val();

        mapDirectionsService.route({
          origin: origin,
          destination: destination,
          travelMode: google.maps.TravelMode.DRIVING
        },
        function(response, status) {
          if (status === google.maps.DirectionsStatus.OK) {

            // Toggle Form
            modal.find('#modal_directions_form').fadeOut('fast', function() {
              // Render and Show
              mapDirectionsRenderer.setDirections(response);
              modal.find('#modal_directions_list').empty().fadeIn('slow');
            });
          }
        });
      });

      // Resize Map When Shown
      jQuery('#modal_map').on('shown', function() {
        google.maps.event.trigger(mapModalMap, 'resize');
      });

      // Resize Map When Shown
      jQuery('#modal_directions').on('shown', function() {
        google.maps.event.trigger(mapDirectionsMap, 'resize');
      });
    }
  }
]);


jQuery(document).ready(function() {
  jQuery(document).ajaxStart(function() {
    Portal.loading(true);
  });

  jQuery(document).ajaxStop(function() {
    Portal.loading(false);
  });
});

/* LAYOUT: Default */
if (jQuery('body').attr('id') === 'default') {

  /* Timeout Inactive Sessions */
  // Determine Session Expiration in Codeigniter
  ciSessionexpire = GLAB.cookie.get('ci_sessionexpire') * 1000;
  var timeoutTrigger = ciSessionexpire - 90000;

  // Prepare Modal if Session Expiration Enabled
  if (timeoutTrigger > 0) {

    // Display Modal One Minute Before Expiration
    setInterval(function() {
      jQuery('#modal_timeout').modal('show');
    },timeoutTrigger);

    // Start 1 Minute Countdown
    jQuery('#modal_timeout').on('shown', function() {

      // Set Timeout Initial Value
      var timeoutRemainder = 60;
      jQuery('#modal_timeout .counter').text(timeoutRemainder);

      // Adjust Value in Countdown
      window.timeoutCounter = setInterval(function() {
        jQuery('#modal_timeout .counter').text(timeoutRemainder);
        if (timeoutRemainder > 0) {
          timeoutRemainder = (timeoutRemainder - 1);
        }
      },1000);

      // Force Logout After 60 Seconds
      window.timeoutSession = setTimeout(function() {
        window.location = siteURL + '/login/destroy?timeout=1&location=';
      }, 60000);
    });

    // Cancel Forced Logout
    jQuery('#modal_timeout').on('hide', function() {
      jQuery.ajax(siteURL + '/login/heartbeat');
      clearTimeout(window.timeoutSession);
      clearInterval(window.timeoutCounter);
    });
  }

  // Chrome Application Installation Prompt
  jQuery('#btn_app_install').on('click', function(event) {
    event.preventDefault();
    window.chrome.webstore.install('', function() {},
    function(str) {
      // Error
      window.alert(str);
    });
  });
}

/**
 * CONTROLLERS AND VIEWS
 */

if (jQuery('body').hasClass('chrome')) {

  // Disable Install Button on Non-Chrome Browsers
  if (window.chrome === undefined) {
    jQuery('#btn_app_install').addClass('disabled');
  }
}

/* Client Profile */
if (jQuery('body').hasClass('client_profile')) {

  // Remove Email Dialog
  jQuery('#email [data-action="email-remove"]').on('click', function() {
    var trigger = jQuery(this);
    bootbox.dialog(
      'Are you sure that you want to remove this email address?',
      [{
        'label' : 'Cancel'
      },
      {
        'label' : 'Remove',
        'class' : 'btn-danger',
        'callback' : function() {
          trigger.closest('li').remove();
        }
      }]
    );
  });

  // Remove Telephone Number Dialog
  jQuery('#telephone [data-action="tel-remove"]').on('click', function() {
    var trigger = jQuery(this);
    bootbox.dialog(
      'Are you sure that you want to remove this telephone number?',
      [{
        'label' : 'Cancel'
      },
      {
        'label' : 'Remove',
        'class' : 'btn-danger',
        'callback' : function() {
          trigger.closest('li').remove();
        }
      }]
    );
  });

  // Remove Address Dialog
  jQuery('#address [data-action="address-remove"]').on('click', function() {
    var trigger = jQuery(this);
    bootbox.dialog(
      'Are you sure that you want to remove this address?',
      [{
        'label' : 'Cancel'
      },
      {
        'label' : 'Remove',
        'class' : 'btn-danger',
        'callback' : function() {
          jQuery('#address .active').remove();
          jQuery('#address .help-block').addClass('active');
        }
      }]
    );
  });

  // Revoke Manager Dialog
  jQuery('#manager button[data-action="manager-revoke"]').on('click', function() {
    var trigger = jQuery(this);
    bootbox.dialog(
      'Are you sure that you want to revoke access?',
      [{
        'label' : 'Cancel'
      },
      {
        'label' : 'Revoke',
        'class' : 'btn-danger',
        'callback' : function() {
          trigger.closest('tr').remove();
        }
      }]
    );
  });

  jQuery(document).ready(function() {

    // Fetch Email Subscriptions
    Portal.api('get', '/proxy/communication/email_list/groups')
    .success(function(interests) {
      // Fill Existing Values
      var profile = {};
      profile.pid = jQuery('.vcard .fn').data('pid');
      Portal.api(
        'get', '/proxy/communication/email_list/subscriber', profile
      )
      .success(function(subscriber) {
        // Set Values
        var checked = {};
        jQuery.each(subscriber.merges.GROUPINGS, function(index, interest) {
          checked[interest.id] = interest.groups.split(', ');
        });
        var rows = jQuery('#email_subscriptions table tbody');
        rows.empty();
        // Append Interests to Table
        jQuery.each(interests, function(index, interest) {
          jQuery.each(interest.groups, function(index, group) {
            if (checked[interest.id].indexOf(group.name) > -1) {
              group.checked = true;
            } else {
              group.checked = false;
            }
          });
          var row = ich.email_subscriptions_row(interest);
          rows.append(row);
        });
        // Add Change Event
        jQuery('#email_subscriptions form').change(function(event) {
          var form = jQuery(this);
          // Get Field Data
          var data = form.serialize();
          // Disable checkboxes while request is processed
          form.find('input').attr('disabled', 'disabled');
          // Send request
          Portal.api(
            'post',
            '/proxy/communication/email_list/subscriber',
            data,
            function() {
              // Enable checkboxes after request is complete
              form.find('input').removeAttr('disabled');
            }
          );
        });
      });
    })
    .error(function() {
      window.alert('Error retrieving interest groups from MailChimp.');
    });

  }); // ready

}

/* Dashboard */
else if (jQuery('body').hasClass('dashboard')) {

  // Show Welcome Message
  if (Boolean(GLAB.cookie.get('dashboard_welcome_hide')) !== true) {
    var welcome = jQuery('#welcome');
    var hud = jQuery('#hud');
    welcome.show();
    hud.hide();

    // Event Handlers
    jQuery(welcome).on('click', 'a.btn', function() {
      if (jQuery('#welcome_hide').is(':checked')) {
        GLAB.cookie.set('dashboard_welcome_hide', '1');
      }
    });

    jQuery('#btn_welcome_hide').on('click', function() {
      welcome.fadeOut('slow', function() {
        hud.fadeIn('slow');
      });
    });
  }

  // Show Chrome Application Alert
  if (window.chrome !== undefined && window.chrome.app.isInstalled !== true) {
    jQuery('#alert_chrome').show();
  }

  // Animate Refresh Icon
  var inboxLoadCount = 0;
  function inboxLoading(loading) {
    if (loading === true) {
      inboxLoadCount++;
      jQuery('#btn_inbox_refresh').addClass('active');
    } else if (--inboxLoadCount <= 0) {
      jQuery('#btn_inbox_refresh').removeClass('active');
      inboxLoadCount = 0;
    }
  }

  // Retrieve Inbox Feed
  function inboxRefresh() {
    var limit = 5;
    var uniqueid = jQuery('#inbox .message').first().data('unique-id');
    if (uniqueid === undefined) {
      uniqueid = '';
    }

    inboxLoading(true);

    jQuery.getJSON(
      siteURL +
      '/dashboard/inbox_feed/' +
      limit + '/' +
      uniqueid,
      function(data) {

        // Append New Messages to Table
        jQuery.each(data.messages.reverse(), function(index, message) {
          var row = ich.inbox_row(message);
          jQuery('#inbox tbody').prepend(row);
        });

        // Remove Excess Messages
        jQuery('#inbox .message').each(function(key, value) {
          if (key + 1 > limit) {
            jQuery(this).remove();
          }
        });

        // Update Counts
        var count = jQuery('#message_count');
        count.find('.shown').text(jQuery('#inbox tbody tr input').size());
        count.find('.total').text(data.count_total);
      }
    ).complete(function() {
      inboxLoading(false);
    });
  }

  // Process Message Actions
  function inboxMessagesAction(action) {
    var inputs = jQuery('#inbox tbody tr input:checked');

    if (inputs.size() > 0) {

      inboxLoading(true);

      inputs.each(function(index, element) {

        var row = jQuery(element).closest('tr');
        var uniqueid = row.data('unique-id');

        jQuery.get(
          siteURL +
          '/dashboard/inbox_action/' +
          uniqueid +
          '/' +
          action
        ).success(function() {
          row.remove();
          inboxRefresh();
        }).error(function() {
          window.alert('Could not remove message' + uniqueid);
        }).complete(function() {
          inboxLoading(false);
        });

      });
    }
    else {
      window.alert('You must select at least one message to continue.');
    }
  }

  // Gmail Inbox Actions
  jQuery('#inbox a[data-action="inbox-archive"]').on('click', function() {
    inboxMessagesAction('archive');
  });
  jQuery('#inbox a[data-action="inbox-spam"]').on('click', function() {
    bootbox.confirm(
      'Are you sure that these messages are spam?',
      function(confirmed) {
        if (confirmed) {
          inboxMessagesAction('spam');
        }
      }
    );
  });
  jQuery('#inbox a[data-action="inbox-trash"]').on('click', function() {
    bootbox.confirm(
      'Are you sure that you want to permanently remove these messages?',
      function(confirmed) {
        if (confirmed) {
          inboxMessagesAction('trash');
        }
      }
    );
  });
  jQuery('#inbox i[data-action="inbox-refresh"]').on('click', function() {
    inboxRefresh();
  });

  jQuery(document).ready(function() {
    inboxRefresh();
    setInterval(function() {
      inboxRefresh();
    }, 1000 * 60 * 2);
  });
}

/* Preferences */
else if (jQuery('body').hasClass('preferences')) {

  // Request and Display Authorization Code
  jQuery('#device_request a.btn').on('click', function() {
    var button = jQuery(this);

    button.addClass('disabled');
    jQuery('#device_loading').fadeIn();

    // Request Auth Code via AJAX
    jQuery.getJSON(siteURL + '/failure').success(function(data) {
      button.fadeOut().hide();
      jQuery('#device_loading').fadeOut().hide();
      jQuery('#device_response').slideDown();
    }).error(function() {
      window.alert(
        'Could not retrieve authorization code due to an unknown error.  ' +
        'Please try again later.'
      );
      button.removeClass('disabled');
      jQuery('#device_loading').fadeOut();
    });
  });

}
