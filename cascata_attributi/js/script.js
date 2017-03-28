(function(){
  if( document.cookie.indexOf('device_pixel_ratio') == -1
      && 'devicePixelRatio' in window
      && window.devicePixelRatio == 2 ){
    var date = new Date();
    date.setTime( date.getTime() + 3600000 );
    document.cookie = 'device_pixel_ratio=' + window.devicePixelRatio + ';' +  ' expires=' + date.toUTCString() +'; path=/';
    if(document.cookie.indexOf('device_pixel_ratio') != -1) {
        window.location.reload();
    }
  }
})();

$(document).ready(function(){
	var dd = $('.vticker').easyTicker({
		direction: 'up',
		easing: 'easeInOutBack',
		speed: 'slow',
		interval: 5000,
		height: 'auto',
		visible: 1,
		mousePause: 0,
		controls: {
			up: '.up',
			down: '.down',
			toggle: '.toggle',
			stopText: 'Stop !!!'
		}
	}).data('easyTicker');

	cc = 1;
	$('.aa').click(function(){
		$('.vticker ul').append('<li>' + cc + ' Triangles can be made easily using CSS also without any images. This trick requires only div tags and some</li>');
		cc++;
	});

	$('.vis').click(function(){
		dd.options['visible'] = 3;

	});

	$('.visall').click(function(){
		dd.stop();
		dd.options['visible'] = 0 ;
		dd.start();
	});

    $(".height").equalHeights();

    $("#show").on('click', function() {
        $("#contenuto_usato").toggle();
    });

    $("#show").click(function() {
        $('html, body').animate({
            scrollTop: $("#contenuto_usato").offset().top
        });
    });

    $("#show2").on('click', function() {
       $(".contenuto_usato_iphone").toggle();
       $(".contenuto_usato_ipad").hide();
       $("#show2").toggleClass("active");
       $("#show3").removeClass("active");
    });

    $("#show3").on('click', function() {
       $(".contenuto_usato_ipad").toggle();
       $(".contenuto_usato_iphone").hide();
       $("#show3").toggleClass("active");
       $("#show2").removeClass("active");
    });

    $("#show2").click(function() {
        $('html, body').animate({
            scrollTop: $(".contenuto_usato_iphone").offset().top
        });
    });

    $("#show3").click(function() {
        $('html, body').animate({
            scrollTop: $(".contenuto_usato_ipad").offset().top
        });
    });
});
