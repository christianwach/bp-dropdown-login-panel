/**
 * Wait until the page is ready.
 *
 * @param object $ The jQuery object which can then be referenced with the $ alias
 * @return void
 */
jQuery(document).ready( function($) {

	/**
	 * Open button listener
	 *
	 * @param object event The event
	 * @return bool false Prevents event bubbling
	 */
	$('#bp-dropdown-login-open').click( function( event ) {
		event.preventDefault();
		$('#bp-dropdown-login-panel').slideDown( 'slow' );
		return false;
	});

	/**
	 * Close button listener
	 *
	 * @param object event The event
	 * @return bool false Prevents event bubbling
	 */
	$('#bp-dropdown-login-close').click( function( event ) {
		event.preventDefault();
		$('#bp-dropdown-login-panel').slideUp( 'slow' );
		return false;
	});

	/**
	 * Toggle the visibility of the open/close buttons
	 *
	 * @param object event The event
	 * @return bool false Prevents event bubbling
	 */
	$('#bp-dropdown-login-toggle a').click( function( event ) {
		event.preventDefault();
		$('#bp-dropdown-login-toggle a').toggle();
		return false;
	});

});
