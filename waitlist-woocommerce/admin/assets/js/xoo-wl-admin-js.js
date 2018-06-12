jQuery(document).ready(function($){

	//Color Picker
	$(function(){
		$('.color-field').wpColorPicker();
	})


	//Tabs change
	$('.xoo-tabs li').on('click',function(){
		var tab_class = $(this).attr('class').split(' ')[0];
		$('li').removeClass('active-tab');
		$('.settings-tab').removeClass('settings-tab-active');
		$(this).addClass('active-tab');
		var class_c = $('[tab-class='+tab_class+']').attr('class');
		$('[tab-class='+tab_class+']').attr('class',class_c+' settings-tab-active');
	})

	//Hide button position if shop button is disabled
	$('#xoo-wl-gl-enshop').change(function(){
		if($(this).is(':checked')){
			$('select[name=xoo-wl-sy-posi]').prop('disabled',false);
		}
		else{
			$('select[name=xoo-wl-sy-posi]').prop('disabled',true);
		}
	})
	$('#xoo-wl-gl-enshop').trigger('change');

	//Remove Logo
	$('.xoo-remove-logo').click(function(e){
		e.preventDefault();
		$('#xoo-wl-emsy-logo').val('');
		$('.xoo-logo-name').html('');

	})

	//Logo name

	function xoo_logoname(){
		var image_url = $('#xoo-wl-emsy-logo').val();
		if(!image_url){return;}
		var index = image_url.lastIndexOf('/') + 1;
		var image_name = image_url.substr(index);
		$('.xoo-logo-name').html(image_name);
		return image_name;
	}
	xoo_logoname();

	//Valid email
	$('#submit').on('click',function(e){
		var email = $('#xoo-wl-emgl-frem').val();
		var name  = $('#xoo-wl-emgl-frnm').val();
		var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		if(!regex.test(email)){
			alert('Invalid Email Id');
			e.preventDefault();
		}
		else if(name.length < 1){
			alert('Email - From [name] Cannot be empty');
			e.preventDefault();
		}
	})

	
	//Media uploader
	var xoo_media;
	$('#xlogo-btn').on('click',function(e){
		e.preventDefault();
		if(xoo_media){
			xoo_media.open();
			return;
		}
		xoo_media = wp.media.frames.file_frame = wp.media({
			title: 'Select Logo',
			button: {
				text: 'Choose Logo'
			},
			multiple: false
		});

		xoo_media.on('select',function(){
			attachment = xoo_media.state().get('selection').first().toJSON();
			console.log(attachment);
			var allowed_types = ['jpeg','jpg','png'];
			if(allowed_types.indexOf(attachment.subtype) === -1){
				alert('Only jpeg/jpg & png allowed.');
				return false;
			}
			$('#xoo-wl-emsy-logo').val(attachment.url);
			 xoo_logoname();
		})
		xoo_media.open();
	})


	//Sidebar JS
	$(function(){
		var show_class 	= 'xoo-sidebar-show';
		var sidebar 	= $('.xoo-sidebar');
		var togglebar 	= $('.xoo-sidebar-toggle');

		//Show / hide sidebar
		if(localStorage.xoo_admin_sidebar_display){
			if(localStorage.xoo_admin_sidebar_display == 'shown'){
				sidebar.removeClass(show_class);
			}
			else{
				sidebar.addClass(show_class);
			}
			on_sidebar_toggle();
		}

		togglebar.on('click',function(){
			sidebar.toggleClass(show_class);
			on_sidebar_toggle();
		})

		function on_sidebar_toggle(){
			if(sidebar.hasClass(show_class)){
				togglebar.text('Show');
				var display = "hidden";
			}else{
				togglebar.text('Hide');
				var display = "shown";
			}
			localStorage.setItem("xoo_admin_sidebar_display",display);
		}
	});


})