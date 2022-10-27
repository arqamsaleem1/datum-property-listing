(function( $ ) {
	'use strict';

	let map; // It will keep the google maps object and will be accessible to other functions below.

	/**
	 * Get all properties and call function to display
	 * map in the sidebar with the Markets on the locations.
	 */
	 jQuery.ajax({
		
		url:  dpl_plugin_ajax_url.ajax_url,
		type: "post",
		async: true,
		data: { action: "callback_get_all_properties", security: dpl_plugin_ajax_url.security },
		success: function( response ) {
			if( ! response == '' ) {
				if( response.success == false  ) {
					console.log( response );
				}
				else{
					console.log( response );

					let preparedHTML = '';
					//let pagination = '';
						
					/**
					 * Preparing HTML for updating DOM
					 */
					for (let i = 0; i < response[0].length; i++) {
						preparedHTML = preparedHTML +  '<div class="dpl-col-4"><div class="card">';
						preparedHTML = preparedHTML +  '<div class="img-div"><img src="'+ response[0][i].picture +'" alt=""></div>';
						preparedHTML = preparedHTML +  '<div class="property-info"><span class="dpl-type">'+ response[0][i].type +'</span>';
						preparedHTML = preparedHTML +  '<h3 class="property-name">'+ response[0][i].name +'</h3>';
						preparedHTML = preparedHTML +  '<span class="dpl-price"> $<span class="amount">'+ response[0][i].price +'</span></span>';
						preparedHTML = preparedHTML +  '</div></div></div>';
					}
					preparedHTML = preparedHTML +  '<input type="hidden" id="currentPage" value="'+ response[2] +'">';

					/**
					 * Preparing HTML for pagination in the DOM
					 */
					 /* for (let page = 1; page <= response[1]; page++) {
						pagination = pagination +  '<a href="#" class="page-nav" data-page-number="'+ page +'"> '+ page +'</a>';
						
					} */

					//Updating DOM
					$(' .dpl-wrap .dpl-listing > .dpl-row' ).html( preparedHTML );
					//$(' .dpl-wrap .dpl-pagination' ).html( pagination );
					//triggerLazyLoading();
					displayMapWithMarkers( response[0] );
				}
			}
		}
	});

	/**
	 * Handles the Price slider field in the filter tab - START
	 */
	const rangeInput = document.querySelectorAll( ".range-input input" ),
	priceInput = document.querySelectorAll( ".price-input input" ),
	range = document.querySelector( ".slider .progress" );
	let priceGap = 1000;
	//let priceGap = rangeInput[0].getAttribute('max') / 100;
	priceInput.forEach( input =>{
		input.addEventListener( "input", e =>{
			let minPrice = parseInt( priceInput[0].value ),
			maxPrice = parseInt( priceInput[1].value );
			
			if( ( maxPrice - minPrice >= priceGap ) && maxPrice <= rangeInput[1].max ){
				if( e.target.className === "input-min" ){
					rangeInput[0].value = minPrice;
					range.style.left = ( ( minPrice / rangeInput[0].max ) * 100 ) + "%";
				}else{
					rangeInput[1].value = maxPrice;
					range.style.right = 100 - ( maxPrice / rangeInput[1].max ) * 100 + "%";
				}
			}
		});
	});
	rangeInput.forEach( input =>{
		input.addEventListener( "input", e =>{
			let minVal = parseInt( rangeInput[0].value ),
			maxVal = parseInt( rangeInput[1].value );
			if( ( maxVal - minVal ) < priceGap ){
				if( e.target.className === "range-min" ){
					rangeInput[0].value = maxVal - priceGap
				}else{
					rangeInput[1].value = minVal + priceGap;
				}
			} else{
				priceInput[0].value = minVal;
				priceInput[1].value = maxVal;
				range.style.left = ( ( minVal / rangeInput[0].max ) * 100 ) + "%";
				range.style.right = 100 - ( maxVal / rangeInput[1].max ) * 100 + "%";
			}
		} );
	});
	/**
	 * Handles the Price slider field in the filter tab - END
	 */


	/**
	 * Handle Filtering the property listings,
	 * carries an AJAX call to the backend.
	 */
	//$( '#dpl-filter-results' ).click( function( e ) {
	$( 'form.dpl-form input, form.dpl-form select' ).change( function( e ) {
		console.log( $( this ).val() );

		let filterParams		= {};

		filterParams.name 		= $( this ).closest( 'form' ).find( 'input[name="name"]' ).val();
		filterParams.type 		= $( this ).closest( 'form' ).find( 'select[name="type"]' ).val();
		filterParams.priceMin 	= $( this ).closest( 'form' ).find( 'input[name="price-min"]' ).val();
		filterParams.priceMax 	= $( this ).closest( 'form' ).find( 'input[name="price-max"]' ).val();
		filterParams.district 	= $( this ).closest( 'form' ).find( 'select[name="district"]' ).val();

		console.log( filterParams );
		//let currentPage = $(' #currentPage ').val();
		let currentPage = 1;
		jQuery.ajax({

			url:  dpl_plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_filter_properties", 
				filterParams: filterParams, 
				'page' : parseInt( currentPage ),
				security: dpl_plugin_ajax_url.security 
			},
			success: function( response ) {
				if( ! response == '' ) {
					if ( response.success == false  ) {
						console.log( response );
					}
					else {
						console.log( response );
						let preparedHTML = '';
						let pagination = '';

						/**
						 * Preparing HTML for updating DOM
						 */
						for (let i = 0; i < response[0].length; i++) {
							preparedHTML = preparedHTML +  '<div class="dpl-col-4"><div class="card">';
							preparedHTML = preparedHTML +  '<div class="img-div"><img src="'+ response[0][i].picture +'" alt=""></div>';
							preparedHTML = preparedHTML +  '<div class="property-info"><span class="dpl-type">'+ response[0][i].type +'</span>';
							preparedHTML = preparedHTML +  '<h3 class="property-name">'+ response[0][i].name +'</h3>';
							preparedHTML = preparedHTML +  '<span class="dpl-price"> $<span class="amount">'+ response[0][i].price +'</span></span>';
							preparedHTML = preparedHTML +  '</div></div></div>';
						}
						preparedHTML = preparedHTML +  '<input type="hidden" id="currentPage" value="'+ response[2] +'">';

						/**
						 * Preparing HTML for pagination in the DOM
						 */
						 for (let page = 1; page <= response[1]; page++) {
							pagination = pagination +  '<a class="page-nav" data-page-number="'+ page +'"> '+ page +'</a>';
						}

						//Updating DOM
						$(' .dpl-wrap .dpl-listing > .dpl-row' ).html( preparedHTML );
						//$(' .dpl-wrap .dpl-pagination' ).html( pagination );
						//Updating Map
						displayMapWithMarkers( response[0] );
					}
				}
			}
		});
	});

	/**
	 * Script to handle pagination.
	 */
	/* jQuery(".dpl-pagination").on('click', '.page-nav', function(e) {
	//$('.dpl-pagination .page-nav').click(function( e ) {
		
		e.preventDefault();
		let page = $( this ).attr('data-page-number');
		console.log('page change', page);
		
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
						let pagination = '';
							
						/**
						 * Preparing HTML for updating DOM
						 
						for (let i = 0; i < response[0].length; i++) {
							preparedHTML = preparedHTML +  '<div class="dpl-col-4"><div class="card">';
							preparedHTML = preparedHTML +  '<div class="img-div"><img src="'+ response[0][i].picture +'" alt=""></div>';
							preparedHTML = preparedHTML +  '<div class="property-info"><span class="dpl-type">'+ response[0][i].type +'</span>';
							preparedHTML = preparedHTML +  '<h3 class="property-name">'+ response[0][i].name +'</h3>';
							preparedHTML = preparedHTML +  '<span class="dpl-price"> $<span class="amount">'+ response[0][i].price +'</span></span>';
							preparedHTML = preparedHTML +  '</div></div></div>';
						}
						preparedHTML = preparedHTML +  '<input type="hidden" id="currentPage" value="'+ response[2] +'">';

						/**
						 * Preparing HTML for pagination in the DOM
						 
						for (let page = 1; page <= response[1]; page++) {
							pagination = pagination +  '<a class="page-nav" data-page-number="'+ page +'"> '+ page +'</a>';
							
						}

						//Updating DOM
						$(' .dpl-wrap .dpl-listing > .dpl-row' ).html( preparedHTML );
						$(' .dpl-wrap .dpl-pagination' ).html( pagination );
						//triggerLazyLoading();
						displayMapWithMarkers( response[0] );
					}
				}
			}
		});
	}); */

	let canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
	    bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts
 
	$(window).scroll(function(){
		
		let filterParams		= {};

		filterParams.name 		= $( '#dpl-filter-form' ).find( 'input[name="name"]' ).val();
		filterParams.type 		= $( '#dpl-filter-form' ).find( 'select[name="type"]' ).val();
		filterParams.priceMin 	= $( '#dpl-filter-form' ).find( 'input[name="price-min"]' ).val();
		filterParams.priceMax 	= $( '#dpl-filter-form' ).find( 'input[name="price-max"]' ).val();
		filterParams.district 	= $( '#dpl-filter-form' ).find( 'select[name="district"]' ).val();

		let currentPage = $(' #currentPage ').val();
		let data = {
			'action': 'callback_loadmore_properties',
			'page' : parseInt( currentPage )+1,
			filterParams: filterParams, 
			security: dpl_plugin_ajax_url.security
		};
		if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded == true ){
			$.ajax({
				url : dpl_plugin_ajax_url.ajax_url,
				data:data,
				type:'POST',
				beforeSend: function( xhr ){
					// you can also add your own preloader here
					// you see, the AJAX call is in process, we shouldn't run it again until complete
					canBeLoaded = false; 
				},
				success:function( response ) {
					if( response ) {
						console.log(response);
						
						let preparedHTML = '';
						//let pagination = '';
						$( '#currentPage' ).remove();	
						/**
						 * Preparing HTML for updating DOM
						 */
						for (let i = 0; i < response[0].length; i++) {
							preparedHTML = preparedHTML +  '<div class="dpl-col-4"><div class="card">';
							preparedHTML = preparedHTML +  '<div class="img-div"><img src="'+ response[0][i].picture +'" alt=""></div>';
							preparedHTML = preparedHTML +  '<div class="property-info"><span class="dpl-type">'+ response[0][i].type +'</span>';
							preparedHTML = preparedHTML +  '<h3 class="property-name">'+ response[0][i].name +'</h3>';
							preparedHTML = preparedHTML +  '<span class="dpl-price"> $<span class="amount">'+ response[0][i].price +'</span></span>';
							preparedHTML = preparedHTML +  '</div></div></div>';
						}

						preparedHTML = preparedHTML +  '<input type="hidden" id="currentPage" value="'+ response[2] +'">';
						$(' .dpl-wrap .dpl-listing > .dpl-row' ).append( preparedHTML );

						let infowindow = new google.maps.InfoWindow();
						let marker, i;
					
						for ( i = 0; i < response[0].length; i++ ) {  
							marker = new google.maps.Marker( {
								//position: new google.maps.LatLng( locations[ i ][1], locations[ i ][2] ),
								position: new google.maps.LatLng( response[0][ i ]['latitude'], response[0][ i ]['longitude'] ),
								map: map
							} );
					
							google.maps.event.addListener( marker, 'click', ( function( marker, i ) {
								return function() {
									infowindow.setContent( response[0][ i ]['name'] );
									infowindow.open( map, marker );
								}
							} )( marker, i ) );
						}
						
						canBeLoaded = true; // the ajax is completed, now we can run it again
					}
				}
			});
		}
	});

	/**
	 * Gets Locations array and show map
	 * with markers on the provided locations.
	 * @param {Array} locations 
	 */
	function displayMapWithMarkers ( locations ) {
		console.log( 'displayMapWithMarkers called' );
		
		map = new google.maps.Map( document.getElementById( 'dpl-map' ), {
			zoom: 6,
			center: new google.maps.LatLng( 30.8311495, 70.7432578 ),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		} );
	
		let infowindow = new google.maps.InfoWindow();
		let marker, i;
	
		for ( i = 0; i < locations.length; i++ ) {  
			marker = new google.maps.Marker( {
				//position: new google.maps.LatLng( locations[ i ][1], locations[ i ][2] ),
				position: new google.maps.LatLng( locations[ i ]['latitude'], locations[ i ]['longitude'] ),
				map: map
			} );
	
			google.maps.event.addListener( marker, 'click', ( function( marker, i ) {
				return function() {
					infowindow.setContent( locations[ i ]['name'] );
					infowindow.open( map, marker );
				}
			} )( marker, i ) );
		}
	}


})( jQuery );



