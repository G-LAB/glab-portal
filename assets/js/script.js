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

Modernizr.load('/asset/bootstrap/js/bootstrap-transition.js');

/* Load Dropdown Menus */
Modernizr.load([
	{
		load: '/asset/bootstrap/js/bootstrap-dropdown.js',
		complete: function ()
		{
			$('.dropdown-toggle').dropdown();
		}
	}
]);

/* Activate Alert Close Buttons */
Modernizr.load([
	{
		load: '/asset/bootstrap/js/bootstrap-alert.js',
		complete: function ()
		{
			$('.alert-message').alert();
		}
	}
]);

/* LAYOUT: Default */
if ($('body').attr('id') == 'default') {

	/* Load Bootstrap Modal */
	Modernizr.load([
		{
			load: '/asset/bootstrap/js/bootstrap-modal.js',
			complete: function ()
			{
				/* Timeout Inactive Sessions After 6 Minutes */
				// Display Message After 5 Minutes
				setInterval(function () {
					console.log('Display session timeout dialog.');
					$('#modal_timeout').modal('show');
				},300000);

				// Redirect to Logout After 1 Minute
				$('#modal_timeout').on('shown', function () {

					console.log('Start forced logout timer.');

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
						window.location = '/login/destroy';
					}, 60000);
				});

				// Cancel Forced Logout
				$('#modal_timeout').on('hide', function () {
					console.log('Cancel forced logout.');
					clearTimeout(window.timeoutSession);
					clearInterval(window.timeoutCounter);
				});
			}
		}
	]);

	/* Load Bootstrap Tabs */
	Modernizr.load([
		{
			load: '/asset/bootstrap/js/bootstrap-tab.js',
			complete: function ()
			{
				$('.tabbable').tab();
			}
		}
	]);

}

/* LAYOUT: Masthead */
if ($('body').attr('id') == 'masthead') {

	/* Login Button */
	$('#btn-login').on('click', function () {

		// Show Loading Overlay
		glab.portal.loading('show');

		// Get OID URL Via AJAX
		$.getJSON('/login/oid_request')
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

/* Hide Page Loading Overlay */
glab.portal.loading('hide');

/* Trigger Prepended Radio Buttons */
$('.input-prepend input').on('focus', function () {
	$(this).parent().find('.add-on input[type="radio"]').click();
});

/**
 * CONTROLLERS AND VIEWS
 */

/* Preferences */
if ($('body').hasClass('preferences')) {

	$('#device_request a.btn').on('click', function () {

		button = $(this);

		button.addClass('disabled');
		$('#device_loading').fadeIn();

		// Request Auth Code via AJAX
		$.getJSON('/ajax/brand/identities').success(function(data) {
			button.fadeOut().hide();
			$('#device_loading').fadeOut().hide();
			$('#device_response').slideDown();
		}).error(function() {
			alert('Could not retrieve authorization code due to an unknown error.  Please try again later.');
			button.removeClass('disabled');
			$('#device_loading').fadeOut();
		});

	})
}