jQuery(document).ready(function($){

	var product_table_elem    = $('#xoo-wl-products'),
		users_table_elem = $('#xoo-wl-users');

	var product_table = product_table_elem.DataTable({
		'columnDefs': [{
         'targets': [0,1,5],
         'searchable': false,
         'orderable': false,
         'ordering': false,
         'className': 'dt-body-center',
      }],
      'order': [],
      'initComplete': function(){toolbar_action_buttons_html()}
	});


	var users_table = users_table_elem.DataTable({
		'columnDefs': [{
         'targets': [0,1,4,5],
         'searchable': false,
         'orderable': false,
         'ordering': false,
         'className': 'dt-body-center',
      }],
      'order': [],
      'initComplete': function(){toolbar_action_buttons_html()}
	});


	function toolbar_action_buttons_html(action){
		$(
			'<div class="xoo-wl-tbar-actions">'+
			'<a class="button xoo-wl-email-btn xoo-wl-act-btn" data-action="email">Send Email</a>'+
			'<a class="button xoo-wl-delete-btn xoo-wl-act-btn" data-action="delete">Delete Users</a>'+
			'</div>'
		).insertAfter('.dataTables_length');
	}


	// Handle click on "Select all" control
	$('#example-select-all').on('click', function() {
	    // Check/uncheck all checkboxes in the table
	    $(this).parents('table').find('.xoo-wl-table-chkbox').prop('checked', this.checked);
	});

	

	function get_rows_data(action_btn,action_scope){

		if(action_scope == 'global'){//Global action (Checkbox)
			var checkboxes = $('.xoo-wl-table-chkbox:checked');

			var rows_data = [];

			checkboxes.each(function(){
				rows_data.push($(this).val());
			});

		}
		else{//Single
			var rows_data = [action_btn.parents('tr').find('.xoo-wl-table-chkbox').val()];
		}

		return rows_data
	}

	var loading_class = 'xoo-wl-loading';
	var table_notice = $('.xoo-wl-table-notice');

	$('.xoo-wl-act-btn').on('click',function(e){
		e.preventDefault();

		var _this = $(this),
			table_wrapper = _this.parents('.dataTables_wrapper'),
			table = table_wrapper.find('.xoo-wl-table');

		//If table has product id -> Users table
		var product_id = table.length ? parseInt(table.data('product_id')) : null;


		var table_type   = product_id ? 'user' : 'product', // Get table type
			action_scope = _this.parent().hasClass('xoo-wl-tbar-actions') ? 'global' : 'single',
			action_type  = _this.data('action'), // Delete or email
			datatable 	 = table_type == 'user' ? users_table : product_table;

		//Verify delete action on product table
		var checkboxes = $('.xoo-wl-table-chkbox:checked');

		if(action_scope == 'global' && checkboxes.length === 0){
			alert('Select at least one row');
			return;
		}

	
		if(table_type == 'product' || action_scope == 'global'){
			if(!confirm('Are you sure ?')) return;
		}

		//Get rows data
		var rows_data = get_rows_data(_this,action_scope);

		if(!rows_data) return;



		//Add preloader
		_this.addClass(loading_class);
		//Protect sibling action buttons from click
		_this.siblings('a.xoo-wl-act-btn').css('pointer-events','none');

		table_notice.hide();

		var ajax_data = {
			action: 'xoo_wl_admin_actions',
			xoo_wl_rows_data: rows_data
		}

		//Set action type
		ajax_data.xoo_wl_action_type =  table_type == 'user' ? action_type+'_user' : action_type+'_product';

		//If user table , send product id
		if(product_id){
			ajax_data.xoo_wl_product_id = product_id;
		}


		//Make ajax request
		$.ajax({
			url: xoo_wl_admin_lz.adminurl,
			data: ajax_data,
			type: 'POST',
			success: function(response){
				console.log(response);
				_this.removeClass(loading_class);
				_this.siblings('a.xoo-wl-act-btn').css('pointer-events','auto');

				if(response === true){
					var notice = (action_type == 'email' ? 'Email sent' : 'User removed')+', waitlist updated successfully';
					var removable_rows = action_scope == 'global' ? checkboxes.parents('tr') : _this.parents('tr');
					datatable.rows(removable_rows).remove().draw();
				}
				else{
					var notice = 'Something went wrong , please refresh the page & try again.';
				}

				table_notice.html(notice).fadeIn().css('display','block');
			}
		})
	})


})