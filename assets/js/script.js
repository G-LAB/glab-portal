/* Global Variables */
siteURL = unescape(glab.cookie.get('ci_siteurl')) + '/';
console.log(siteURL);
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
				'/assets/bootbox/bootbox.js'
			],
			complete: function ()
			{
				/* Hide Page Loading Overlay */
				glab.portal.loading('hide');

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

				$('a[title]').tooltip();
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

	// Revoke Manager
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
					console.log(trigger);
				}
			}]
		);
	})

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