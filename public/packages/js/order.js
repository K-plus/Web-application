(function ($){

	var page = '';
	tableButtonWatcher();

	function tableButtonWatcher(){
		$('.btn-view-order').on('click', function(e){
			var bon_id = $(this).closest('tr').data('order-id');
			page = window.location.href.split('?');

			$('.page-loader').fadeIn();
			
			$('#order-view').fadeOut(500, function(){
				$('#order-view').load(baseUrl+'/bonnen/'+bon_id + ' #order-view', function(){
					$('.page-loader').fadeOut();

					var breadcrumb = $('body').find('.breadcrumb').first();

					breadcrumb.find('li.active').hide(function(){
						$(this).remove(); // remove the fucking breadcrumb
					});
					// add the back button and the new ul 
					breadcrumb.append('<li><i class="fa fa-fw fa-file-text-o"></i><a class="back" href="#">Bonnen</a></li>');
					breadcrumb.append('<li class="active"><i class="fa fa-fw fa-edit"></i>Bon: '+bon_id+'</li>');

					$(this).fadeIn(500);
					backButtonWatcher();
				});
			});
		});
	}

	function backButtonWatcher(){
		$('.breadcrumb li .back').on('click', function(e){
			$('.page-loader').fadeIn();
			$('#order-view').fadeOut(500, function(){
				if(page[1] !== undefined){
					$('#order-view').load(baseUrl+'/bonnen/?'+page[1] +' #order-row', function(){
						$(this).slideDown(500);
							// the breaddcrumb manipulation
						var breadcrumb = $('body').find('.breadcrumb').first();

						breadcrumb.find('li.active').hide(function(){
							$(this).remove(); // remove the fucking breadcrumb
						});

						breadcrumb.find('.back').contents().unwrap();
						breadcrumb.find('.fa-file-text-o').parent('li').addClass('active');
						// // add the back button and the new ul 
						$('.page-loader').fadeOut();
						// going back to overview page
						tableButtonWatcher();
					});

				} else {
					$('#order-view').load(baseUrl+'/bonnen #order-row', function(){
						$(this).slideDown(500);
						// the breaddcrumb manipulation
						var breadcrumb = $('body').find('.breadcrumb').first();

						breadcrumb.find('li.active').hide(function(){
							$(this).remove(); // remove the fucking breadcrumb
						});

						breadcrumb.find('.back').contents().unwrap();
						breadcrumb.find('.fa-file-text-o').parent('li').addClass('active');
						// // add the back button and the new ul 
						$('.page-loader').fadeOut();
						tableButtonWatcher();
					});
				}
			});
		});
	}
})(jQuery);