/**
 * Async Script Loading and Initialization
 */

Modernizr.load([
  /* jQuery */
  {
    load: '//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',
    complete: function()
    {
      if (!window.jQuery)
      {
        Modernizr.load('//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js');
      }

      $.holdReady(true);
    }
  },
  /* Portal Assets */
  {
    test: window.jQuery,
    both: [
      '/assets/global/js/global.js',
      '/assets/js/script.js'
    ],
    nope: function()
    {
      alert('Failed to load required system components (jQuery).');
    }
  }
]);
