jQuery(window).ready(function($){
	$(".menu-item-has-children>a").append(" <span class='glyphicon glyphicon-chevron-down'></span>");
	$(".menu-item-has-children>a").click(function(e){
		e.preventDefault();
		if ( ! $(this).parent().children(".sub-menu").hasClass("sub-active") &&
		     ! $(this).parent().hasClass("sub-btn") ) {
			$(".sub-active").slideToggle('medium').removeClass("sub-active");
		}
		$(this).parent().children(".sub-menu").slideToggle('medium').toggleClass("sub-active");
	});
});
