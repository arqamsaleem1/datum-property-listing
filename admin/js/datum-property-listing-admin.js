(function( $ ) {
	'use strict';
	
	jQuery( "#update-form-area" ).hide();

	/**
	 * Script to handle submit button onClick callback,
	 * it gathers the data from DOM and validate it, then
	 * shows error messages if required or send a post request
	 * using AJAX.
	 */
	$( '#datum-property-listing-submit' ).click( function() {

		let formData		= {};
		let validateForm 	= '';

		formData.name 		= $( 'input[name="name"]' ).val();
		formData.type 		= $( 'select[name="type"]' ).val();
		formData.price 		= $( 'input[name="price"]' ).val();
		formData.district 	= $( 'input[name="district"]' ).val();
		formData.latitude 	= $( 'input[name="latitude"]' ).val();
		formData.longitude 	= $( 'input[name="longitude"]' ).val();
		formData.picture 	= $( '#dpl_picture_url' ).val();
		
		validateForm = validateFormData( formData );

		if ( validateForm != '' ) {
			$( "form div.error-notices ul").html(validateForm);
			$( "form div.error-notices").addClass('show');
			return false;
		}
		
		$.ajax({
		
			url:  dpl_plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_save_form_data", 'postedData': formData, security: dpl_plugin_ajax_url.security },
			success: function( response ) {
				if( ! response == '' ) {
					if( response.success == false ) {

						$( "form div.error-notices ul" ).html( response.data );
						$( "form div.error-notices" ).addClass( 'show' );
					}
					else{
						//Removing existing notices
						$( '.success-message' ).remove();
						$( "form div.error-notices ul li" ).remove();
						$( "form div.error-notices" ).removeClass( 'show' );

						//Clear the previous data in the form
						$( 'form' ).find( "input[type=text],input[type=number], select" ).val("");
						//Show the success message
						$( "#dpl-wrapper" ).append( '<p class="success-message">' + response + '</p>' );
					}
				}
			}
		});
	});

	/**
	 * This script is responsible for showing WordPress Media uploader
	 * at upload picture button clicked in the admin area.
	 */
	$( '#dpl-picture-upload-btn' ).click( function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on( 'select' , function( e ) {
            
			// This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get( 'selection' ).first();
            
			// We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
			console.log(uploaded_image);

            var image_url = uploaded_image.toJSON().url;
            
			// Let's assign the url value to the input field
            $( '#dpl_picture_url' ).val( image_url );
			$( '#dpl-picture-upload-btn' ).closest( '.field-group' ).append( '<p class="success-message">Picture is selected</p>' )
        });
    });

	/**
	 * This script is responsible for handling import CSV file function.
	 * It will get the file and will post it to the backend via AJAX.
	 */
	$('#datum-csv-submit').click(function(e) {
		e.preventDefault();

		let csvFile = $( this ).closest('form').find('input[name=upload-csv]').prop('files')[0];
		let formData = new FormData();
        
		formData.append( 'dplFile', csvFile );
        formData.append( 'security', dpl_plugin_ajax_url.security );
        formData.append( 'action', "callback_import_csv_file" );

		$.ajax({
			url:  dpl_plugin_ajax_url.ajax_url,
			type: "POST",
			async: true, 
			processData: false,
			contentType: false,
			data: formData,
			success: function( response ) {
				if( ! response == '' ) {
					if( response.success == false ) {

						$("form div.error-notices ul").html( response.data );
						$("form div.error-notices").addClass('show');
					}
					else{
						//Show the success message
						$("#dpl-wrapper form").append( '<p class="success-message">' + response + '</p>' );
					}
				}
			}
		});
	});

	/**
	 * This script is responsible for delete property function.
	 * It will get the id of the property and will send request to backend via AJAX.
	 */
	jQuery(".dpl-entries-div").on('click', '#delete-property-btn', function() {

		const currentItemID = jQuery( this ).attr("data-entry-id");
		let result = confirm("Are you sure to delete this property?");
		if ( ! result ) {
			return false;
		}
		
    	jQuery.ajax({
		
			url:  dpl_plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_delete_property", 'rowID': currentItemID, security: dpl_plugin_ajax_url.security },
			success: function( response ) {
				console.log( response );
				if( ! response == '' ) {
					if( response.success == false ) {
						console.log( response );
					}
					else{
						
						console.log( response );
						$("#dpl-wrapper").prepend( '<p class="success-message">' + response + '</p>' );
						
					}
				}
			}
		});
	});
	
	/**
	 * This script is responsible for delete property function.
	 * It will get the id of the property and will send request to backend via AJAX.
	 */
	jQuery(".dpl-entries-div").on('click', '#edit-property-btn', function() {

		const currentItemID = jQuery( this ).attr("data-entry-id");
		
    	jQuery.ajax({
		
			url:  dpl_plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_edit_property", 'rowID': currentItemID, security: dpl_plugin_ajax_url.security },
			success: function( response ) {
				console.log( response );
				if( ! response == '' ) {
					if( response.success == false ) {
						console.log( response );
					}
					else{
						console.log( JSON.stringify( response ));
						jQuery("#update-form-area").show();
						/**
						 * Assign values to update form fields
						 */
						jQuery(".update-form-area").find('input[name=name]').val(response.name);
						jQuery(".update-form-area").find('select[name=type]').val(response.type);
						jQuery(".update-form-area").find('input[name=price]').val(response.price);
						jQuery(".update-form-area").find('input[name=district]').val(response.district);
						jQuery(".update-form-area").find('input[name=longitude]').val(response.longitude);
						jQuery(".update-form-area").find('input[name=latitude]').val(response.latitude);
						jQuery(".update-form-area").find('input[name=dpl_picture_url]').val(response.picture);
						jQuery(".update-form-area").find('input[name=property_id]').val(response.id);
						jQuery(".update-form-area").find('.dpl-image-thumb').html('<img src="' + response.picture + '">');

						jQuery('html, body').animate({
					        scrollTop: jQuery(".update-form-area").offset().top
					    }, 2000);
					}
				}
			}
		});
	});

	/**
	 * Script to handle Update property submit button Click callback,
	 * it gathers the data from DOM and validate it, then
	 * shows error messages if required or send a post request
	 * using AJAX.
	 */
	 $('#datum-property-listing-update-submit').click(function() {

		let formData		= {};
		let validateForm 	= '';

		formData.name 			= $( 'input[name="name"]' ).val();
		formData.propertyId 	= $( 'input[name="property_id"]' ).val();
		formData.type 			= $( 'select[name="type"]' ).val();
		formData.price 			= $( 'input[name="price"]' ).val();
		formData.district 		= $( 'input[name="district"]' ).val();
		formData.latitude 		= $( 'input[name="latitude"]' ).val();
		formData.longitude 		= $( 'input[name="longitude"]' ).val();
		formData.picture 		= $( '#dpl_picture_url' ).val();
		
		validateForm = validateFormData( formData );
		if ( formData.propertyId == '' ) {
			$("form div.error-notices ul").html('Property id is not present');
			$("form div.error-notices").addClass('show');
			return false;
		}
		if ( validateForm != '' ) {
			$("form div.error-notices ul").html(validateForm);
			$("form div.error-notices").addClass('show');
			return false;
		}
		
		$.ajax({
		
			url:  dpl_plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_update_property", 'postedData': formData, security: dpl_plugin_ajax_url.security },
			success: function( response ) {
				if( ! response == '' ) {
					if( response.success == false ) {

						$("form div.error-notices ul").html( response.data );
						$("form div.error-notices").addClass('show');
					}
					else {
						//Removing existing notices
						$( '.success-message' ).remove();
						$("form div.error-notices ul li").remove();
						$("form div.error-notices").removeClass('show');

						//Show the success message
						$("#update-form-area").append( '<p class="success-message">' + response + '</p>' );
					}
				}
			}
		});
	});

	/**
	 * Script to handle pagination.
	 */
	 $('.dpl-pagination .page-nav').click(function( e ) {
		
		e.preventDefault();

		let page = $( this ).attr('data-page-number');
		
		$.ajax({
		
			url:  dpl_plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_handle_page_change", 'page': page, security: dpl_plugin_ajax_url.security },
			success: function( response ) {
				if( ! response == '' ) {
					if( response.success == false ) {
						console.log('error')
					}
					else {
						console.log( 'new data', response );
						let preparedHTML = '';
						
						/**
						 * Preparing HTML for updating DOM
						 */

						for ( let i = 0; i < response[0].length; i++ ) {
							preparedHTML = preparedHTML +  '<div class="row">';
							preparedHTML = preparedHTML +  '<div class="col"><span>' + response[0][i].name + '</span></div>';
							preparedHTML = preparedHTML +  '<div class="col"><span>' + response[0][i].type + '</span></div>';
							preparedHTML = preparedHTML +  '<div class="col"><span>' + response[0][i].price + '</span></div>';
							preparedHTML = preparedHTML +  '<div class="col"><span>' + response[0][i].district + '</span></div>';
							preparedHTML = preparedHTML +  '<div class="col actions">';
							preparedHTML = preparedHTML +  '<button type="button" name="edit-btn" id="edit-property-btn" data-entry-id="' + response[0][i].id + '" class="action-btn button-secondary" >Edit</button>';
							preparedHTML = preparedHTML +  '<button type="button" name="delete-btn" id="delete-property-btn" data-entry-id="' + response[0][i].id + '" class="action-btn button-secondary" >Delete</button>';
							preparedHTML = preparedHTML +  '</div></div>';
						}

						//Updating DOM
						$(' .dpl-table-wrap .table-body' ).html( preparedHTML );
					}
				}
			}
		});
	});



})( jQuery );


/**
 * Function to validate form data, accepts form data object
 * and returns Error Messages
 * @param {Object} formData 
 * @returns 
 */
function validateFormData(formData) {

	let errorMessage 	= '';
	
	if ( formData.name == '' ) {
		errorMessage = errorMessage + "<li>Please provide Name</li>";
	}
	if ( formData.type == '' ) {
		errorMessage = errorMessage + "<li>Please select property type</li>";
	}
	if ( formData.price == '' ) {
		errorMessage = errorMessage + "<li>Please provide price</li>";
	}
	if ( formData.district == '' ) {
		errorMessage = errorMessage + "<li>Please provide district</li>";
	}
	if ( formData.longitude == '' ) {
		errorMessage = errorMessage + "<li>Please provide logitude</li>";
	}
	if ( formData.latitude == '' ) {
		errorMessage = errorMessage + "<li>Please provide latitude</li>";
	}
	
	return errorMessage;
}