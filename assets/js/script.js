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

// Load Dropdown Menus
Modernizr.load([
	{
		load: '/asset/bootstrap/js/bootstrap-dropdown.js',
		complete: function ()
		{
			$('.dropdown-toggle').dropdown();
		}
	}
]);

// Activate Alert Close Buttons
Modernizr.load([
	{
		load: '/asset/bootstrap/js/bootstrap-alert.js',
		complete: function ()
		{
			$('.alert-message').alert();
		}
	}
]);

/* Hide Page Loading Overlay */
glab.portal.loading('hide');

/* Trigger Prepended Radio Buttons */
$('.input-prepend input').on('focus', function () {
	$(this).parent().find('.add-on input[type="radio"]').click();
});

/* Execute Scripts onLoad */
$(document).ready(function()
{



});