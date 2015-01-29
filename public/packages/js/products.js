(function ($){
	$('.search-button').on('click', function(e){
		var searchQuery = $('.search-box').val();
		console.log(searchQuery);
	});
})(jQuery);