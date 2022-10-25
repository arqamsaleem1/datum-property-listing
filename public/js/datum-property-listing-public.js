(function( $ ) {
	'use strict';

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
					console.log( response )
					/* $( "form div.error-notices ul" ).html( response.data );
					$( "form div.error-notices" ).addClass( 'show' ); */
				}
				else{
					console.log( response )
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

	$( '#dpl-filter-results' ).click( function( e ) {
		let filterParams		= {};

		filterParams.name 		= $( this ).closest( 'form' ).find( 'input[name="name"]' ).val();
		filterParams.type 		= $( this ).closest( 'form' ).find( 'select[name="type"]' ).val();
		filterParams.priceMin 	= $( this ).closest( 'form' ).find( 'input[name="price-min"]' ).val();
		filterParams.priceMax 	= $( this ).closest( 'form' ).find( 'input[name="price-max"]' ).val();
		filterParams.district 	= $( this ).closest( 'form' ).find( 'select[name="district"]' ).val();

		console.log( filterParams );

		jQuery.ajax({

			url:  dpl_plugin_ajax_url.ajax_url,
			type: "post",
			async: true,
			data: { action: "callback_filter_properties", 
				filterParams: filterParams, 
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
						

						for (let i = 0; i < response[0].length; i++) {
							preparedHTML = preparedHTML +  '<div class="dpl-col-4"><div class="card">';
							preparedHTML = preparedHTML +  '<div class="img-div"><img src="'+ response[0][i].picture +'" alt=""></div>';
							preparedHTML = preparedHTML +  '<div class="property-info"><span class="dpl-type">'+ response[0][i].type +'</span>';
							preparedHTML = preparedHTML +  '<h3 class="property-name">'+ response[0][i].name +'</h3>';
							preparedHTML = preparedHTML +  '<span class="dpl-price"> $<span class="amount">'+ response[0][i].price +'</span></span>';
							preparedHTML = preparedHTML +  '</div></div></div>';
						}
						$(' .dpl-wrap .dpl-listing > .dpl-row' ).html( preparedHTML );

						displayMapWithMarkers( response[0] );
					}
				}
			}
		});
	});

})( jQuery );


/**
 * Gets Locations array and show map
 * with markers on the provided locations.
 * @param {Array} locations 
 */
function displayMapWithMarkers ( locations ) {
	console.log( 'displayMapWithMarkers called' );
	/* var locations = [
		['Bondi Beach', -33.890542, 151.274856, 4],
		['Coogee Beach', -33.923036, 151.259052, 5],
		['Cronulla Beach', -34.028249, 151.157507, 3],
		['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
		['Maroubra Beach', -33.950198, 151.259302, 1]
	]; */
	
	var map = new google.maps.Map( document.getElementById( 'map' ), {
		zoom: 6,
		center: new google.maps.LatLng( 30.8311495, 70.7432578 ),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	} );

	var infowindow = new google.maps.InfoWindow();
	var marker, i;

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
/**
 * Accepts an Array of parameters and and 
 * creates an Ajax request to plugin backend.
 * Returns resonse by Ajax request.
 * @param {Array} params 
 */
/*  function getAllPropertiesData (  ) {
	return;
} */