(function(){
$.fn.enterKey = function (fnc) {
    return this.each(function () {
        $(this).keypress(function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        })
    })
}
})(jQuery);

(function ($){
	// if the browser doesn't empty the field. -- scumbag browser
	if($('.search-box').val().length != 0){
		var searchQuery = $('.search-box').val();
		// clear the table 
		var tableBody = $('.product-table').find('tbody');
		var searchEncoded = escape(searchQuery);
		$('.loading-icon').show();
		
		$.ajax({
			type: 'GET',
			url: baseUrl + '/api/v1/product/search/' + escape(searchQuery),
			dataType: 'json',
			success: function(data){
				tableBody.find('tr').remove();
				searchResult = data.data;
				var tableRows = '';
				for(var i = 0; i < searchResult.length; i++){
				 		tableRows += '<tr data-product-id="'+searchResult[i].id+'">'+
				 						'<td>'+searchResult[i].ean+'</td>'+
				 						'<td><span class="product-name">'+searchResult[i].name+'</span></td>'+
				 						'<td><i class="fa fa-fw fa-euro"></i>'+searchResult[i].price / 100 +'</td>'+
				 						'<td class="text-center">';
		 								if(searchResult[i].stock > 0){
	                      					tableRows += '<i class="fa fa-fw fa-check-circle" style="color: green !important;"></i>';
		 								} else {
	                      					tableRows += '<i class="fa fa-fw fa-times" style="color: red !important;"></i>';
		 								}
		 								tableRows += '</td>'
		 								tableRows += '<td>'
		 								if( searchResult[i].stock > 0) {
		 									if($('.user-menu').text() == ' Gast'){
		 										tableRows += '<a href="'+baseUrl+'/login" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>';
		 									} else {
		 										tableRows += '<button class="btn btn-sm btn-success btn-add-product"><i class="fa fa-fw fa-plus"></i></button>';
		 									}
		 								} else {
		 									tableRows += '<fieldset disabled="">'+
		                      					'<button class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></button>'+
		                      				'</fieldset>';
		 								}
		 								tableRows +='</td>';
	 								tableRows +='</tr>';
		 				
				}
				$('.pagination').hide();
				tableBody.append(tableRows);
			},
			error: function(data){
				tableBody.find('tr').remove();
				var tableRow = '<tr class="text-center"><td colspan="5">Geen producten gevonden, pas uw zoekopdracht aan.</td></tr>';
				tableBody.append(tableRow);
				$('.loading-icon').hide();
				$('.pagination').hide();
			}
		}).done(function(){
			$('.loading-icon').hide();
			buttonWatchers();
		});
	} else {
		buttonWatchers();
	}

	$('.search-box').keyup(function(){
		var searchQuery = $('.search-box').val();
		var page = window.location.href.split('?');

		if(searchQuery.length == 0){
			$('.loading-icon').show();
			$('#table-space').slideUp(500, function(){
				var path = 
				$('#table-space').load(baseUrl+'/producten?'+page[1]+' #table-with-pagination', function(){
					$(this).slideDown(500);
					buttonWatchers();
					$('.loading-icon').hide();	
				})
			});
		}
	});

	/** The input search field to perform the search through the products **/
	$('.search-button').on('click', function(e){
		var searchQuery = $('.search-box').val();
		// clear the table 
		var tableBody = $('.product-table').find('tbody');
		var searchEncoded = escape(searchQuery);

		$('.loading-icon').show();

		$.ajax({
			type: 'GET',
			url: baseUrl + '/api/v1/product/search/' + escape(searchQuery),
			dataType: 'json',
			success: function(data){
				tableBody.find('tr').remove();
				searchResult = data.data;
				var tableRows = '';
				for(var i = 0; i < searchResult.length; i++){
				 		tableRows += '<tr data-product-id="'+searchResult[i].id+'">'+
				 						'<td>'+searchResult[i].ean+'</td>'+
				 						'<td><span class="product-name">'+searchResult[i].name+'</span></td>'+
				 						'<td><i class="fa fa-fw fa-euro"></i>'+searchResult[i].price / 100 +'</td>'+
				 						'<td class="text-center">';
		 								if(searchResult[i].stock > 0){
	                      					tableRows += '<i class="fa fa-fw fa-check-circle" style="color: green !important;"></i>';
		 								} else {
	                      					tableRows += '<i class="fa fa-fw fa-times" style="color: red !important;"></i>';
		 								}
		 								tableRows += '</td>'
		 								tableRows += '<td>'
		 								if( searchResult[i].stock > 0) {
		 									if($('.user-menu').text() == ' Gast'){
		 										tableRows += '<a href="'+baseUrl+'/login" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>';
		 									} else {
		 										tableRows += '<button class="btn btn-sm btn-success btn-add-product"><i class="fa fa-fw fa-plus"></i></button>';
		 									}
		 								} else {
		 									tableRows += '<fieldset disabled="">'+
		                      					'<button class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></button>'+
		                      				'</fieldset>';
		 								}
		 								tableRows +='</td>';
	 								tableRows +='</tr>';	
				}
				$('.pagination').hide();
				tableBody.append(tableRows);
				buttonWathcers();
			},
			error: function(data){
				tableBody.find('tr').remove();
				var tableRow = '<tr class="text-center"><td colspan="5">Geen producten gevonden, pas uw zoekopdracht aan.</td></tr>';
				tableBody.append(tableRow);
				$('.loading-icon').hide();
				$('.pagination').hide();
			}
		}).done(function(){
			$('.loading-icon').hide();
		})
	});

	$('input.search-box').enterKey(function(){
		var searchQuery = $('.search-box').val();
		var tableBody = $('.product-table').find('tbody');

		$('.loading-icon').show();

		$.ajax({
			type: 'GET',
			url: baseUrl + '/api/v1/product/search/' + escape(searchQuery),
			dataType: 'json',
			success: function(data){
				tableBody.find('tr').remove();
				searchResult = data.data;
				var tableRows = '';
				for(var i = 0; i < searchResult.length; i++){
				 		tableRows += '<tr data-product-id="'+searchResult[i].id+'">'+
				 						'<td>'+searchResult[i].ean+'</td>'+
				 						'<td><span class="product-name">'+searchResult[i].name+'</span></td>'+
				 						'<td><i class="fa fa-fw fa-euro"></i>'+searchResult[i].price / 100 +'</td>'+
				 						'<td class="text-center">';
		 								if(searchResult[i].stock > 0){
	                      					tableRows += '<i class="fa fa-fw fa-check-circle" style="color: green !important;"></i>';
		 								} else {
	                      					tableRows += '<i class="fa fa-fw fa-times" style="color: red !important;"></i>';
		 								}
		 								tableRows += '</td>'
		 								tableRows += '<td>'
		 								if( searchResult[i].stock > 0) {
		 									if($('.user-menu').text() == ' Gast'){
		 										tableRows += '<a href="'+baseUrl+'/login" class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></a>';
		 									} else {
		 										tableRows += '<button class="btn btn-sm btn-success btn-add-product"><i class="fa fa-fw fa-plus"></i></button>';
		 									}
		 								} else {
		 									tableRows += '<fieldset disabled="">'+
		                      					'<button class="btn btn-sm btn-success"><i class="fa fa-fw fa-plus"></i></button>'+
		                      				'</fieldset>';
		 								}
		 								tableRows +='</td>';
	 								tableRows +='</tr>';
		 				
				}

				$('.pagination').hide();
				tableBody.append(tableRows);
				buttonWatchers();
			},
			error: function(data){
				tableBody.find('tr').remove();
				var tableRow = '<tr class="text-center"><td colspan="5">Geen producten gevonden, pas uw zoekopdracht aan.</td></tr>';
				tableBody.append(tableRow);

				$('.loading-icon').hide();
				$('.pagination').hide();
			}
		}).done(function(){
			$('.loading-icon').hide();
		});
	});
	
	function buttonWatchers(){
		/** The button to add the product to your cart **/
		$('.btn-add-product').on('click', function(e){
			var product_row = $(this).closest('tr').first();
			var product_name = $(product_row).find('.product-name').text();
			var product_id = $(product_row).data('product-id');

			$.ajax({
				type: 'POST',
				url: baseUrl + '/api/v1/cart/product/add',
				dataType: 'json',
				data: {id: product_id},
				success: function(data) {
					$.bootstrapGrowl(product_name +' is toegevoegd.', {
						ele: 'body',
						type: 'success',
						offset: {from: 'bottom', amount: 10},
						align: 'right',
						delay: 2000,
						allow_dismiss: true,
						stackup_spacing: 10
					});
				},
				error: function(data){
					$.bootstrapGrowl(product_name +' is niet toegevoegd. Probeer opnieuw.', {
						ele: 'body',
						type: 'danger',
						offset: {from: 'bottom', amount: 10},
						align: 'right',
						delay: 2000,
						allow_dismiss: true,
						stackup_spacing: 10
					});
				}
			});
		});
	}
})(jQuery);