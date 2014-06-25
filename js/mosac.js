function isMobile(){
    return (
        (navigator.userAgent.match(/Android/i)) ||
		(navigator.userAgent.match(/webOS/i)) ||
		(navigator.userAgent.match(/iPhone/i)) ||
		(navigator.userAgent.match(/iPod/i)) ||
		(navigator.userAgent.match(/iPad/i)) ||
		(navigator.userAgent.match(/BlackBerry/))
    );
}
function projectThumbInit() {
	
	if(!isMobile()) {		
	
		jQuery(".mosac-hover .inside a").hover(
			function() {
				jQuery(this).find('img:last').stop().fadeTo("fast", .2);
				jQuery(this).find('img:last').attr('title','');	
			},
			function() {
				jQuery(this).find('img:last').stop().fadeTo("fast", 1);	
		});
			
		jQuery(".mosac-hover .inside").hover(	
			function() {				
				jQuery(this).find('.mosac-item-text').stop().fadeTo("fast", 1);
				jQuery(this).find('.mosac-item-type').stop().fadeTo("fast", 1);
				jQuery(this).find('img:last').attr('title','');				
			},
			function() {				
				jQuery(this).find('.mosac-item-text').stop().fadeTo("fast", 0);							
				jQuery(this).find('.mosac-item-type').stop().fadeTo("fast", 0);							
		});
		
	}
	
//	jQuery(".mosac-item").css("opacity", "1");
	jQuery(".mosac-hover .mosac-item-text").css("opacity", "0");
	jQuery(".mosac-hover .mosac-item-type").css("opacity", "0");
}

jQuery(document).ready(function(){
	projectThumbInit();
});
