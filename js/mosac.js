// minimum jQuery gallery
// click on thumbs nav system
jQuery(document).ready(function($) {
	$('.mosac-popup').hide();
	$('.mosac-item').hover(function(){
		$(this).find('div.item-text').fadeIn('slow');
		$(this).find('div.item-fondo').animate({
			'z-index': 999,
		}, 100, function() {
    			// Animation complete.
		});
	},
	function(){
		$(this).find('div.item-text').fadeOut('fast');
		$(this).find('div.item-fondo').animate({
			'z-index': -999,
		}, 100, function() {
    			// Animation complete.
		});
	});

});
