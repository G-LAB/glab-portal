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

	/* Load Modal */
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
					window.timeoutSession = setTimeout(function () {
						window.location = '/login/destroy';
					}, 60000);
				});
				// Cancel Forced Logout
				$('#modal_timeout').on('hide', function () {
					console.log('Cancel forced logout.');
					clearTimeout(window.timeoutSession);
				});
			}
		}
	]);

}

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