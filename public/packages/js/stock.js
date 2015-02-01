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

var page = '';

(function ($){
	searchBoxFunctions();
	createButtonWatcher();
	tableButtonsWatcher();
})(jQuery);

function backButtonWatcher(){
	$('.breadcrumb li .back').on('click', function(e){
		$('.page-loader').fadeIn();
		$('#stock-view').fadeOut(500, function(){
			if(page[1] !== undefined){
				$('#stock-view').load(baseUrl+'/voorraadbeheer/?'+page[1] +' #stock-row', function(){
					$(this).slideDown(500);
						// the breaddcrumb manipulation
					var breadcrumb = $('body').find('.breadcrumb').first();

					breadcrumb.find('li.active').hide(function(){
						$(this).remove(); // remove the fucking breadcrumb
					});

					breadcrumb.find('.back').contents().unwrap();
					breadcrumb.find('.fa-check-square').parent('li').addClass('active');
					// // add the back button and the new ul 
					$('.page-loader').fadeOut();
					// NEED SOME FUCKEN WATCHERS
					createButtonWatcher();
					// going back to overview page
					searchBoxFunctions();
					tablebuttonsWatcher();

				});

			} else {
				$('#stock-view').load(baseUrl+'/voorraadbeheer/ #stock-row', function(){
					$(this).slideDown(500);
					// the breaddcrumb manipulation
					var breadcrumb = $('body').find('.breadcrumb').first();

					breadcrumb.find('li.active').hide(function(){
						$(this).remove(); // remove the fucking breadcrumb
					});

					breadcrumb.find('.back').contents().unwrap();
					breadcrumb.find('.fa-check-square').parent('li').addClass('active');
					// // add the back button and the new ul 
					$('.page-loader').fadeOut();

					// NEED SOME FUCKEN WATCHERS
					createButtonWatcher();
					searchBoxFunctions();
					tableButtonsWatcher();
				});
			}
		});
	});
}

/** gets called when the create page is loaded */
function createPageButtons(){
	backButtonWatcher();

	$('.btn-create-product').on('click', function(e){
		e.preventDefault();

		var product_name 	= $('input[name=product-naam]').val();
		var product_ean 	= $('input[name=ean-nummer]').val();
		var product_price 	= $('input[name=product-prijs]').val();
		var product_qty 	= parseInt($('input[name=product-hoeveelheid]').val());

		var product_priceParsed = product_price.replace(/([,.])+/g, ''); // pesky comma or dot

		$.ajax({
			type: 'POST',
			url: baseUrl + '/api/v1/product/create',
			dataType: 'json',
			data: {product_name: product_name, product_ean: product_ean, product_price: product_priceParsed, product_qty: product_qty},
			success: function(data){
				loadOverviewPage($('#product-view'));
			},
			error: function(data){
				console.log(data);
			}
		});
	});
}

/** gets called when the edit page is loaded */
function editPageButtonsWatchers(product_id){
	backButtonWatcher();

	$('.btn-update-product').on('click', function(e){
		e.preventDefault();

		var product_name 	= $('input[name=product-naam]').val();
		var product_ean 	= $('input[name=ean-nummer]').val();
		var product_price 	= $('input[name=product-prijs]').val();
		var product_qty 	= parseInt($('input[name=product-hoeveelheid]').val());

		var product_priceParsed = product_price.replace(/([,.])+/g, ''); // pesky comma or dot

		$.ajax({
			type: 'POST',
			url: baseUrl + '/api/v1/product/update/'+product_id,
			dataType: 'json',
			data: {product_name: product_name, product_ean: product_ean, product_price: product_priceParsed, product_qty: product_qty},
			success: function(data){
				loadOverviewPage($('#product-view'));
			},
			error: function(data){
				console.log(data);
			}
		});
	});
}

/** gets called when the table refreshes the content and on dom ready */
function tableButtonsWatcher(){
	/** The button to add the product to your cart **/
	$('.btn-edit-product').on('click', function(e){
		var product_row = $(this).closest('tr').first();
		var product_name = $(product_row).find('.product-name').text();
		var product_id = $(product_row).data('product-id');
		page = window.location.href.split('?');

		$('.page-loader').fadeIn();
		$('#stock-view').fadeOut(500, function(){
			$('#stock-view').load(baseUrl+'/voorraadbeheer/product/'+product_id+ '#stock-row', function(){

				$(this).slideDown(500);
				// the breaddcrumb manipulation
				var breadcrumb = $('body').find('.breadcrumb').first();

				breadcrumb.find('li.active').hide(function(){
					$(this).remove(); // remove the fucking breadcrumb
				});
				// add the back button and the new ul 
				breadcrumb.append('<li><i class="fa fa-fw fa-check-square"></i><a class="back" href="#">Voorraadbeheer</a></li>');
				breadcrumb.append('<li class="active"><i class="fa fa-fw fa-edit"></i>Product: '+product_name+'</li>');

				$('.page-loader').fadeOut();
				editPageButtonsWatchers(product_id);
			});
		});
	});

	/** The button to add the product to your cart **/
	$('.btn-delete-product').on('click', function(e){
		var product_row = $(this).closest('tr').first();
		var product_name = $(product_row).find('.product-name').text();
		var product_id = $(product_row).data('product-id');

		$.ajax({
			type: 'GET',
			url: baseUrl + '/api/v1/product/delete/'+product_id,
			dataType: 'json',
			success: function(data) {
				$(product_row).fadeOut(500, function(){
					$(this).remove();
					$.bootstrapGrowl(product_name +' is verwijderd', {
						ele: 'body',
						type: 'success',
						offset: {from: 'bottom', amount: 10},
						align: 'right',
						delay: 2000,
						allow_dismiss: true,
						stackup_spacing: 10
					});
				});
			},
			error: function(data){
				$.bootstrapGrowl(product_name +' iets fout gegaan.', {
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

function createButtonWatcher(){
	/** The button to add the product to create  a new product **/
	$('.btn-create-product').on('click', function(e){
		var product_row = $(this).closest('tr').first();
		var product_name = $(product_row).find('.product-name').text();
		var product_id = $(product_row).data('product-id');
		page = window.location.href.split('?');

		$('.page-loader').fadeIn(); // fucken loading icons

		$('#stock-view').fadeOut(500, function(){
			$('#stock-view').load(baseUrl+'/voorraadbeheer/nieuw/product/', function(){
				$(this).slideDown(500);
				// the breaddcrumb manipulation
				var breadcrumb = $('body').find('.breadcrumb').first();

				breadcrumb.find('li.active').hide(function(){
					$(this).remove(); // remove the fucking breadcrumb
				});
				// add the back button and the new ul 
				breadcrumb.append('<li><i class="fa fa-fw fa-check-square"></i><a class="back" href="#">Voorraadbeheer</a></li>');
				breadcrumb.append('<li class="active"><i class="fa fa-fw fa-square-o"></i>Nieuw product</li>');

				createPageButtons(); // those fucken watchers
				$('.page-loader').fadeOut();
			});
		});
	});
}

function loadOverviewPage(currentPage) {
	$('.page-loader').fadeIn();
	$(currentPage).fadeOut(500, function(){
		if(page[1] !== undefined){
			$('#stock-view').load(baseUrl+'/voorraadbeheer/?'+page[1] +' #stock-row', function(){
				$(this).slideDown(500);
					// the breaddcrumb manipulation
				var breadcrumb = $('body').find('.breadcrumb').first();

				breadcrumb.find('li.active').hide(function(){
					$(this).remove(); // remove the fucking breadcrumb
				});

				breadcrumb.find('.back').contents().unwrap();
				breadcrumb.find('.fa-check-square').parent('li').addClass('active');
				// // add the back button and the new ul 
				$('.page-loader').fadeOut();
				// NEED SOME FUCKEN WATCHERS
				createButtonWatcher(); // watch the create button upon loading
				searchBoxFunctions();
				tableButtonsWatcher();
			});

		} else {
			$('#stock-view').load(baseUrl+'/voorraadbeheer/ #stock-row', function(){
				$(this).slideDown(500);
				// the breaddcrumb manipulation
				var breadcrumb = $('body').find('.breadcrumb').first();

				breadcrumb.find('li.active').hide(function(){
					$(this).remove(); // remove the fucking breadcrumb
				});

				breadcrumb.find('.back').contents().unwrap();
				breadcrumb.find('.fa-check-square').parent('li').addClass('active');
				// // add the back button and the new ul 
				$('.page-loader').fadeOut();

				// NEED SOME FUCKEN WATCHERS
				createButtonWatcher(); // watch the create butotn upn loading
				searchBoxFunctions();
				tableButtonsWatcher();
			});
		}
	});
}


function searchBoxFunctions() { 
	// if the browser doesn't empty the field. -- scumbag browser --cache issue :/
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
		 								tableRows += searchResult[i].stock;
		 								tableRows += '</td>';
		 								tableRows += '<td>';
		 								tableRows += '<button class="btn btn-edit-product btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></button> ';
		 								tableRows += '<button class="btn btn-delete-product btn-sm btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>';
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
			tableButtonsWatcher();
		});
	} else {
		// tableButtonsWatcher();
	}

	$('.search-box').keyup(function(){
		var searchQuery = $('.search-box').val();
		var page = window.location.href.split('?');

		if(searchQuery.length == 0){
			$('.loading-icon').show();
			$('#table-space').slideUp(500, function(){
				var path = 
				$('#table-space').load(baseUrl+'/voorraadbeheer?'+page[1]+' #table-with-pagination', function(){
					$(this).slideDown(500);
					tableButtonsWatcher();
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
		 								tableRows += searchResult[i].stock;
		 								tableRows += '</td>';
		 								tableRows += '<td>';
		 								tableRows += '<button class="btn btn-edit-product btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></button> ';
		 								tableRows += '<button class="btn btn-delete-product btn-sm btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>';
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
			tableButtonsWatcher();
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
		 								tableRows += searchResult[i].stock;
		 								tableRows += '</td>';
		 								tableRows += '<td>';
		 								tableRows += '<button class="btn btn-edit-product btn-sm btn-warning"><i class="fa fa-fw fa-edit"></i></button> ';
		 								tableRows += '<button class="btn btn-delete-product btn-sm btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>';
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
			tableButtonsWatcher();
		});
	});
}