/**
 * Handle the document ready event from the cart page. 
 */
(function ($) {

	// Watcher for the add product button
	$('.btn-add-product').on('click', function(e){
		// get the product id
		var product_row = $(this).closest('tr');
		var product_id = $(this).closest('tr').data('product-id');

		// check if the request is already made
        if (typeof updateRequest !== 'undefined') {
            updateRequest.abort();
        }

        // Get results and reinit pagination
        updateRequest = $.ajax({
        	type: 'POST',
        	url : baseUrl +'/api/v1/cart/product/update',
        	dataType: 'json',
        	data: {
        		id: product_id,
        		qty: 1,
        	},
        	success: function (data){
        		// update the table qty for the product
        		var qty_parsed = parseInt(product_row.closest('tr').find('.item-qty').text()) + 1;
        		product_row.find('.item-qty').text(qty_parsed);
        		
        		var item_price = parseFloat(product_row.closest('tr').find('.item-price').text());

        		// update the total qty for the table
        		var qty_parsed = parseInt($('.total-qty').text()) + 1;
        		$('.total-qty').text(qty_parsed); 
        		
        		// get the previous total price
        		var total_price_parsed = parseFloat($('.total-price').text());

        		// add the new product price  
        		$('.total-price').text(Math.round((total_price_parsed + item_price) * 100) / 100);
        	},
        	error: function (data) {
        		// console.log(data);
        	}
        })
  	});
	
	// Watcher for the minus button
	$('.btn-substract-product').on('click', function(e){
		// get the product id
		var product_row = $(this).closest('tr').first();
		var product_id = $(this).closest('tr').data('product-id');

		// check if the request is already made
        if (typeof updateRequest !== 'undefined') {
            updateRequest.abort();
        }

        // Get results and reinit pagination
        updateRequest = $.ajax({
        	type: 'POST',
        	url : baseUrl +'/api/v1/cart/product/substract',
        	dataType: 'json',
        	data: {
        		id: product_id,
        		qty: 1,
        	},
        	success: function (data){
        		// update the table qty for the product
        		var qty_parsed = parseInt(product_row.find('.item-qty').text()) - 1;
        		var item_price = parseFloat(product_row.find('.item-price').text());

        		if(qty_parsed == 0){
        			$(product_row).fadeOut(500, function(){
        				$(this).remove();
        				lastProductDeleted();
        			});
        		} else {
        			product_row.find('.item-qty').text(qty_parsed);
        		}

        		// update the total qty for the table
        		var qty_parsed = parseInt($('.total-qty').text()) - 1;
        		$('.total-qty').text(qty_parsed); 

        		var total_price_parsed = parseFloat($('.total-price').text());
        		$('.total-price').text(Math.round((total_price_parsed - item_price) * 100) / 100);
        		
        	},
        	error: function (data) {
        		// console.log(data);
        	}
        })
	});

	$('.btn-delete-product').on('click', function(e){
		var product_row = $(this).closest('tr').first();
		var product_id = $(this).closest('tr').data('product-id');

		// check if the request is already made
        if (typeof deleteRequest !== 'undefined') {
            deleteRequest.abort();
        }

        // Get results and reinit pagination
        deleteRequest = $.ajax({
        	type: 'POST',
        	url : baseUrl +'/api/v1/cart/product/delete',
        	dataType: 'json',
        	data: {
        		id: product_id,
        	},
        	success: function (data){
        		// update the table qty for the product
        		var qty_parsed = parseInt(product_row.find('.item-qty').text());
        		var item_price_parsed = parseFloat(product_row.find('.item-price').text());
        		var total_price_item = qty_parsed * item_price_parsed;


        		// update the total qty for the table
        		var total_qty_parsed = parseInt($('.total-qty').text());
        		var total_price_parsed = parseFloat($('.total-price').text());

        		$(product_row).fadeOut(500, function(){
        			$('.total-qty').text(total_qty_parsed - qty_parsed);
        			$('.total-price').text(Math.round((total_price_parsed - total_price_item) * 100) / 100);
        			$(this).remove();
        			lastProductDeleted();
        		});
          	},
        	error: function (data) {
        		// console.log(data);
        	}
        })
	})

	function lastProductDeleted() {
		var table_rows = $('.cart-table').find('tbody tr');
		// check if table is empty
		if(table_rows.length == 1 && table_rows.hasClass('warning')){
			$('#cart-view').fadeOut(1000, function(){
				$('#cart-view').load(baseUrl+'/boodschappenlijst #cart-row', function(){
					$(this).fadeIn(1000);
				});
			});
		}
	}

})(jQuery);