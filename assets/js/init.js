/**
 * Async Script Loading and Initialization
 */

Modernizr.load([
	/* jQuery */
	{
		load: '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
		complete: function ()
		{
			if (!window.jQuery)
			{
				Modernizr.load('//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js');
			}
		}
	},
	/* jQuery UI */
	{
		load: '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js',
		complete: function ()
		{
			if (!window.jQuery.ui)
			{
				Modernizr.load('//ajax.aspnetcdn.com/ajax/jquery.ui/1.8.16/jquery-ui.min.js');
			}
		}
	},
	/* Portal Assets */
	{
		test: window.jQuery && window.jQuery.ui,
		both: [
			'/asset/global/js/global.js',
			'/asset/js/script.js'
		],
		nope: function ()
		{
			alert('Failed to load required system components.');
		}
	}
]);