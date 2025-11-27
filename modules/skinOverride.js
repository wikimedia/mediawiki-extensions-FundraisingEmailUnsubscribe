( function ( $ ) {
	$( () => {
		$( 'div#p-logo a' ).attr( 'href', '#' );

		// Cheating a bit, this deserves its own module.
		$( 'input#unsubscribe, input#continue' ).on( 'click', () => {
			$( '#execute' ).val( 1 );
		} );
	} );

}( jQuery ) );
