jQuery(document).ready(function($){
	var advanced = $("#search-advanced");
	advanced.hide();
	$("#search-advanced-btn").on('click', function(e) {
		// prevent default anchor click behavior
		e.preventDefault();
		advanced.toggle();
	});
});
