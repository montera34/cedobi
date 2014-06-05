var container = document.querySelector('#list');
var msnry;
// initialize Masonry after all images have loaded
imagesLoaded( container, function() {
	msnry = new Masonry( container, {
		itemSelector: '.list-item'
	});
});
