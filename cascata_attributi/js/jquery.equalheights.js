/*!
 * Simple jQuery Equal Heights
 *
 * Copyright (c) 2013 Matt Banks
 * Dual licensed under the MIT and GPL licenses.
 * Uses the same license as jQuery, see:
 * http://docs.jquery.com/License
 *
 * @version 1.5.1
 */
(function($) {

  $.fn.equalHeights = function() {

    var elementi = $(this);

    $(window).on('resize load', function() {
      var maxHeight = 0;
      elementi.css('height', '');
      elementi.each(function() {
        var height = $(this).innerHeight();
        // console.log(height);
        if (height > maxHeight) { maxHeight = height; }
        // console.log(maxHeight);
      });
      // console.log(maxHeight);
      elementi.css('height', maxHeight);
    });
  };

})(jQuery);
