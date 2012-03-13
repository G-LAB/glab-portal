/* Global Variables */
siteURL = unescape(glab.cookie.get('ci_siteurl')) + '/';

/* Google Analytics Tracking */
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-18252433-3']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

/**
 * Class for G LAB Portal
 * @return null
 */
glab.class.portal = function () {};

/**
 * Hide or Show Loading Overlay
 * @param  string|bool mode
 * @return null
 */
glab.class.portal.prototype.loading = function (mode)
{
	var overlayLoading = $('#overlay-loading');

	if (mode == 'show' || mode == true)
	{
		overlayLoading.fadeIn('slow');
	}
	else if (mode == 'hide' || mode == false)
	{
		overlayLoading.fadeOut('fast');
	}
}

glab.class.portal.prototype.gmapInit = function ()
{
	/* Basic Map in Modal */
	mapModalMap = new google.maps.Map(document.getElementById("modal_map_gmap"), {
		zoom: 14,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	/* Directions in Modal */
	mapDirectionsService = new google.maps.DirectionsService();
	mapDirectionsRenderer = new google.maps.DirectionsRenderer();
	mapDirectionsMap = new google.maps.Map(document.getElementById("modal_directions_gmap"), {
		zoom: 9,
		center: new google.maps.LatLng(34.05, -118.24),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	mapDirectionsRenderer.setMap(mapDirectionsMap);
	mapDirectionsRenderer.setPanel(document.getElementById("modal_directions_list"));

	/* Bind Map Elements */
	this.gmapBind();
}

glab.class.portal.prototype.gmapBind = function ()
{
	$('.map').each(function () {
		var lat, lng;
		var element = $(this);
		var geocoder = new google.maps.Geocoder();

		// Draw Map
		var map = new google.maps.Map(this, {
			zoom: 14,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		// Declared Latitude and Longitude
		if (element.data('latlng') != undefined) {
			var latlng = element.data('latlng').split(',',2);
			lat = latlng[0];
			lng = latlng[1];
			map.setCenter(new google.maps.LatLng(lat,lng));
		}

		// Declared Address
		else if (element.data('address') != undefined)
		{
			geocoder.geocode( { 'address': element.data('address')}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					var marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location
					});
				}
			});
		}
	});
}

/* Instanciate Portal Class */
glab.portal = new glab.class.portal();

/* LAYOUT: Default */
if ($('body').attr('id') == 'default') {

	/* Load Bootstrap */
	Modernizr.load([
		{
			load: [
				'/assets/bootstrap/js/bootstrap-tab.js',
				'/assets/bootstrap/js/bootstrap-modal.js',
				'/assets/bootstrap/js/bootstrap-tooltip.js',
				'//maps.googleapis.com/maps/api/js?key=AIzaSyDX7KuCoJpi0h8r-9yiBBkePoyYQvLL4F0&callback=glab.portal.gmapInit&sensor=false',
				'/assets/bootbox/bootbox.js'
			],
			complete: function ()
			{
				/* Hide Page Loading Overlay */
				glab.portal.loading('hide');

				/* Tabs */
				$('.tabbable').tab();

				/* Timeout Inactive Sessions */
				// Determine Session Expiration in Codeigniter
				ciSessionexpire = glab.cookie.get('ci_sessionexpire')*1000;
				timeoutTrigger = ciSessionexpire-90000;

				// Prepare Modal if Session Expiration Enabled
				if (timeoutTrigger > 0) {

					// Display Modal One Minute Before Expiration
					setInterval(function () {
						$('#modal_timeout').modal('show');
					},timeoutTrigger);

					// Start 1 Minute Countdown
					$('#modal_timeout').on('shown', function () {

						// Set Timeout Initial Value
						var timeoutRemainder = 60;
						$('#modal_timeout .counter').text(timeoutRemainder);

						// Adjust Value in Countdown
						window.timeoutCounter = setInterval(function () {
							$('#modal_timeout .counter').text(timeoutRemainder);
							if (timeoutRemainder > 0) {
								timeoutRemainder = (timeoutRemainder - 1);
							}
						},1000);

						// Force Logout After 60 Seconds
						window.timeoutSession = setTimeout(function () {
							window.location = siteURL + '/login/destroy?timeout=1&location=';
						}, 60000);
					});

					// Cancel Forced Logout
					$('#modal_timeout').on('hide', function () {
						$.ajax(siteURL + '/login/heartbeat');
						clearTimeout(window.timeoutSession);
						clearInterval(window.timeoutCounter);
					});
				}

				/* Enable Tooltips */
				$('a[title], i[data-action]').tooltip();

				/* Listen for Google Map Actions */
				$('[data-action="modal-map"]').on('click', function (event) {
					event.preventDefault();

					var trigger = $(this);
					var modal = $('#modal_map');
					var geocoder = new google.maps.Geocoder();
					var address;

					if (trigger.data('address') != undefined && trigger.data('address').substring(0,1) == '#') {
						if ($(trigger.data('address')).data('address') != undefined) {
							address = $(trigger.data('address')).data('address');
						} else {
							address = $(trigger.data('address')).text();
						}
					} else {
						address = trigger.data('address');
					}

					geocoder.geocode( { 'address': address}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							mapModalMap.setCenter(results[0].geometry.location);
							var marker = new google.maps.Marker({
									map: mapModalMap,
									position: results[0].geometry.location
							});
						} else {
							alert("Geocode was not successful for the following reason: " + status);
						}
					});

					modal.find('h3').text(address);
					modal.modal('show');
				});

				/* Listen for Google Directions Actions */
				// Modal Show Event
				$('[data-action="modal-directions"]').on('click', function (event) {
					event.preventDefault();

					var trigger = $(this);
					var modal = $('#modal_directions');

					if (trigger.data('address') != undefined && trigger.data('address').substring(0,1) == '#') {
						if ($(trigger.data('address')).data('address') != undefined) {
							address = $(trigger.data('address')).data('address');
						} else {
							address = $(trigger.data('address')).text();
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
						width: 'auto',
						'margin-left': function () { return -($(this).width() / 2); }
					});
				});

				// Modal Submit Event
				$('#modal_directions_submit').on('click', function (event) {
					event.preventDefault();

					var modal = $('#modal_directions');

					var origin = modal.find('#origin').val();
					var destination = modal.find('#destination').val();

					mapDirectionsService.route({
						origin:origin,
						destination:destination,
						travelMode: google.maps.TravelMode.DRIVING
					},
					function(response, status) {
						if (status == google.maps.DirectionsStatus.OK) {

							// Toggle Form
							modal.find('#modal_directions_form').fadeOut('fast', function () {
								// Render and Show
								mapDirectionsRenderer.setDirections(response);
								modal.find('#modal_directions_list').empty().fadeIn('slow');
							});
						}
					});
				});
			}
		}
	]);

}
else {
	/* Hide Page Loading Overlay */
	glab.portal.loading('hide');
}

/* LAYOUT: Masthead */
if ($('body').attr('id') == 'masthead') {

	/* Login Button */
	$('#btn-login').on('click', function () {

		// Show Loading Overlay
		glab.portal.loading('show');

		// Get OID URL Via AJAX
		$.getJSON(siteURL + '/login/oid_request')
			.success(function(data) {
				// Redirect to Provider
				window.location = data.result.provider_url;

			}).error(function() {
				// Hide Loading Overlay
				glab.portal.loading('hide');

				// Show Error Dialog
				alert('Could not access OpenID provider.');
			});
	});

}

/* Trigger Prepended Radio Buttons */
$('.input-prepend input').on('focus', function () {
	$(this).parent().find('.add-on input[type="radio"]').click();
});

/**
 * CONTROLLERS AND VIEWS
 */

/* Client Profile */
if ($('body').hasClass('client_profile')) {

	// Revoke Manager Dialog
	$('#managers button[data-action="revoke"]').on('click', function () {
		var trigger = $(this);
		bootbox.dialog(
			"Are you sure that you want to revoke access?",
			[{
				"label" : "Cancel"
			},
			{
				"label" : "Revoke",
				"class" : "btn-danger",
				"callback" : function() {
					trigger.closest('tr').remove();
				}
			}]
		);
	})

}

/* Dashboard */
if ($('body').hasClass('dashboard')) {

}

/* Preferences */
else if ($('body').hasClass('preferences')) {

	// Request and Display Authorization Code
	$('#device_request a.btn').on('click', function () {

		button = $(this);

		button.addClass('disabled');
		$('#device_loading').fadeIn();

		// Request Auth Code via AJAX
		$.getJSON(siteURL + '/ajax/brand/identities').success(function(data) {
			button.fadeOut().hide();
			$('#device_loading').fadeOut().hide();
			$('#device_response').slideDown();
		}).error(function() {
			alert('Could not retrieve authorization code due to an unknown error.  Please try again later.');
			button.removeClass('disabled');
			$('#device_loading').fadeOut();
		});
	});

}