( function ( $ ) {
	$( function () {
		$( 'div#p-logo a' ).attr( 'href', '#' );
		 
		// Cheating a bit, this deserves its own module.
		$( 'input#unsubscribe' ).on( 'click', function () {
			$( '#execute' ).val( 1 );
		} );
	} );
} )( jQuery );
