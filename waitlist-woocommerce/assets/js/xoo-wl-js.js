jQuery(document).ready(function($){

	var waitlist_form = $('.xoo-wl-form');

	//Show Waitlist Form on button click
	$('body').on('click','.xoo-wl-btn',function(e){
		e.preventDefault();
		$('.xoo-wl-success , .xoo-wl-error').empty().hide();
		$('.xoo-wl-form-id').val($(this).attr('data-xoo_product_id'));
		$('.xoo-wl-qty').val($(this).attr('data-min_qty'))
		$('.xoo-wl-container').addClass('xoo-wl-active');
	
		if(xoo_wl_localize.animation == 'slide-down' || xoo_wl_localize.animation == 'bounce-in'){
			var inmodal_height = ($(window).height())/2 + ($('.xoo-wl-inmodal').height())/2;
			$('.xoo-wl-inmodal').css('top',-inmodal_height);
		}
	})


	//Close Waitlist Form
	function close_form(event){
		$.each(event.target.classList,function(key,value){
			if(value != 'xoo-wl-inmodal' && (value == 'xoo-wl-close' || value == 'xoo-wl-modal')){
				$('.xoo-wl-container , body').removeClass('xoo-wl-active');
				$('.xoo-wl-main').show();
				return false;
			}
		})
	}

	$('body').on('click','.xoo-wl-close , .xoo-wl-modal',close_form);



	//WooCommerce Product Variation on select
	$('body').on( 'change', '.variation_id', function(){
		var _this = $(this),
			form = _this.parents('form.variations_form'),
			wl_btn = form.parent().find('.xoo-wl-btn'),
			variation_id = _this.val(),
			variation_data = form.data('product_variations');

		if(!variation_id) wl_btn.hide();
		
		if(variation_data){
			$.each(variation_data,function(key,variation){
				if(variation.variation_id != variation_id) return true; // return if variation id not matched

				if(variation.is_in_stock === false){
					wl_btn.attr('data-xoo_product_id',variation_id).attr('data-min_qty',variation.min_qty || 1).show();
				}
				else{
					wl_btn.attr('data-xoo_product_id','').hide();
				}
				
				return false;

			})
		}
	})




	//Wait list ajax call on submit form.
	$('.xoo-wl-form').on('submit',function(e){
		e.preventDefault();

		//Clear notices
		$('.xoo-wl-success , .xoo-wl-error').empty().hide();

		var _this 	     = $(this),
			email 		 = _this.find('.xoo-wl-email').val(),
			qty_elem  	 = _this.find('.xoo-wl-qty'),
			qty_value  	 = parseFloat(qty_elem.val()),
			wl_form_data = _this.serializeArray(),
			error_elem   = $('.xoo-wl-error'),
			errors 		 = [];

		var regex_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    	if(!email){
    		errors.push(xoo_wl_localize.e_empty_email);
    	}
    	else if(!regex_email.test(email)){
    		errors.push(xoo_wl_localize.e_invalid_email);
    	}

    	if(qty_elem.length > 0){
    		!qty_value && errors.push(xoo_wl_localize.e_min_qty);
    	}
		
		if(errors.length > 0){
			$.each(errors,function(key,value){
				$('.xoo-wl-error').append(value+'<br>');
			})
			$('.xoo-wl-error').show();
			return;
		}

		wl_form_data.push({name: 'action' , value: 'xoo_wl_add_waitlist_user'});

		//Send ajax request
		$.ajax({
			url: xoo_wl_localize.adminurl,
			method: 'POST',
			data: $.param(wl_form_data),
		   	beforeSend: function(){
		   		$('.xoo-wl-inmodal').addClass('xoo-wl-form-loading');
		   		$('.xoo-wl-submit').prop('disabled',true);
		   	},
			success: function(response){
				if(response.success){
					$('.xoo-wl-success').html(response.success).show();
					$('.xoo-wl-main').hide();
				}
				else if(response.error){
					var errors_string = '';

					$.each(response.error,function(key,error){
						errors_string += error+'<br>';
					})
	
					error_elem.html(errors_string).show();
				}
				else{
					console.log(response);
				}

				$('.xoo-wl-inmodal').removeClass('xoo-wl-form-loading');
		   		$('.xoo-wl-submit').prop('disabled',false);
		   		
			}
		})
	})

})