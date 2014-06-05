var container = document.querySelector('#mosac');
var msnry;
// initialize Masonry after all images have loaded
imagesLoaded( container, function() {
	msnry = new Masonry( container, {
		itemSelector: '.mosac-item'
	});
});
