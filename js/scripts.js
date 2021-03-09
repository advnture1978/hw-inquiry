/**
 * Main javascript file.
 * 
 * It includes all the javascript functions.
 * 
 * @author Harry Wang <nicewebworkbest@gmail.com>
 * @since 1.0.0
 */
( function( $ ) {

	'use strict';

	// Submit inquiry form
	$( '.inquiry-form' ).on( 'submit', function( e ) {
		e.preventDefault();

		var $this = $( this );
		
		$.ajax( {
			type: 'post',
			dataType: 'json',
			url: ajax_data.ajaxurl,
			data: {
				action: 'hw_send_inquiry_info',
				nonce: ajax_data.ajax_nonce,
				first_name: $this.find( '#first-name' ).val(),
				last_name: $this.find( '#last-name' ).val(),
				email: $this.find( '#email' ).val(),
				subject: $this.find( '#subject' ).val(),
				message: $this.find( '#message' ).val()
			},
			success: function( response ) {
				
				var position;

				if ( response.result == 'success' ) {
					$this.parent()
						.html( '<p class="success">' + response.message + '</p>' );

					position = $( '.success' ).offset().top - 50;
					$( 'html, body' ).animate(
						{ scrollTop: position },
						300
					);
				} else {
					position = $( '.error' ).offset().top - 50;
					$this.prepend( '<p class="error">' + response.message + '</p>' );
					$( 'html, body' ).animate(
						{ scrollTop: position },
						300
					);
				}
			}
		} );

		return false;
	} );

	// Ajax pagination
	$( document ).on( 'click', '.inquiry-pagination a.page-numbers', function( e ) {
		e.preventDefault();

		var position,
			listContainer = $( this ).closest( '.inquiry-list' );

		const urlParams = new URLSearchParams( $( this ).attr( 'href' ) );

		$( '.inquiry-details' ).hide();		

		$.ajax( {
			type: 'post',
			dataType: 'json',
			url: ajax_data.ajaxurl,
			data: {
				action: 'hw_get_inquiry_list',
				nonce: ajax_data.ajax_nonce,
				page: urlParams.get( 'page' ),
				per_page: urlParams.get( 'per_page' )
			},
			success: function( response ) {
				if ( response.result == 'success' ) {
					position = listContainer.offset().top - 50;
					listContainer.html( response.html );
					$( 'html, body' ).animate(
						{ scrollTop: position },
						300
					);
				} else {
					position = $( '.error' ).offset().top - 50;
					listContainer.html( '<p class="error">' + response.message + '</p>' );
					$( 'html, body' ).animate(
						{ scrollTop: position },
						300
					);
				}
			}
		} );

		return false;
	} );

	// Get inquiry information
	$( document ).on( 'click', '.inquiry-list .inquiry-item', function( e ) {
		e.preventDefault();

		var position,
			$this = $( this );

		$.ajax( {
			type: 'post',
			dataType: 'json',
			url: ajax_data.ajaxurl,
			data: {
				action: 'hw_get_inquiry_info',
				nonce: ajax_data.ajax_nonce,
				inquiry_id: $this.data( 'inquiry-id' )
			},
			success: function( response ) {
				if ( response.result == 'success' ) {
					$( '.inquiry-details' ).html( response.html );
				} else {
					$( '.inquiry-details' ).html( '<p class="error">' + response.message + '</p>' );
				}

				position = $( '.inquiry-details' ).offset().top - 50;
				$( '.inquiry-details' ).show();
				$( 'html, body' ).animate(
					{ scrollTop: position },
					300
				);
			}
		} );

		return;
	} );

} )( window.jQuery ); 
