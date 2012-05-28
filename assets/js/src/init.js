/**
 * Async Script Loading and Initialization
 */

/**
 * Get Codeigniter Environment
 * @return {string} Name of environment.
 */
function getEnvironment () {
  var nameEQ = 'ci_environment=';
  var ca = document.cookie.split(';');

  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];

    while (c.charAt(0) === ' ') {
      c = c.substring(1, c.length);
    }

    if (c.indexOf(nameEQ) === 0) {
      return c.substring(nameEQ.length, c.length);
    }
  }
  return null;
};

var assets = [];

if (getEnvironment() === 'development') {
  assets = [
    '/assets/global/js/global.js',
    '/assets/js/src/script.js'
  ]
}
else {
  assets = [
    '/assets/js/dist/script.min.js'
  ]
}


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
    both: assets,
    nope: function()
    {
      alert('Failed to load required system components (jQuery).');
    }
  }
]);
