/**
 * Async Script Loading and Initialization
 */

Modernizr.load([
	{
		load: [
			'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
			'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js'
		],
		complete: function ()
		{
			if (!window.jQuery)
			{
				Modernizr.load('https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js');
			}

			if (!window.jQuery.ui)
			{
				Modernizr.load('https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.16/jquery-ui.min.js');
			}

			Modernizr.load({
				load: [
					'/asset/global/js/global.js',
					'/asset/js/script.js'
				]
			});
		}
	}
]);