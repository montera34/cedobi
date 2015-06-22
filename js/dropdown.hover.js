jQuery(window).ready(function($){
	$(".menu-item-has-children>a").append(" <span class='glyphicon glyphicon-chevron-down'></span>");
	$(".menu-item-has-children").click(function(){
		if ( ! $(this).children(".sub-menu").hasClass("sub-active") ) {
			$(".sub-active").slideToggle('medium').removeClass("sub-active");
		}
		$(this).children(".sub-menu").slideToggle('medium').toggleClass("sub-active");
	});
});
