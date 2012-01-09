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

/* Execute jQuery Scripts onLoad */
$(document).ready(function()
{
	/* Hide Page Loading Overlay */
	glab.portal.loading('hide');

	/* Instanciate Bootstrap Methods */
	$('#header').dropdown();
	$(".alert-message").alert();

	/* Trigger Prepended Radio Buttons */
	$('.input-prepend input').on('focus', function () {
		$(this).parent().find('.add-on input[type="radio"]').click();
	});

	// LAYOUT: Masthead
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

});