<?php
/**
 * Functions are stored here
 *
 *
 * @package    Fizz Buzz for Company NC001
 * @version    0.0.1 (January 21, 2016)
 * @since      0.0.1 (January 21, 2016)
 */


function generate_500_error() {

    header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Malformed JSON string. Transaction aborted' );

	$server_response['error']['code'] = 500;
	$server_response['error']['message'] = 'Malformed JSON string. Transaction aborted';

	echo json_encode( $server_response );

}


function generate_400_error() {

    header( $_SERVER["SERVER_PROTOCOL"] . ' 400 Method'. $_SERVER['REQUEST_METHOD'] . ' not available on this endpoint' );

	$server_response['error']['code'] = 400;
	$server_response['error']['message'] = 'Method ' . $_SERVER['REQUEST_METHOD'] . ' not available on this endpoint';

	echo json_encode( $server_response );

}


//stackoverflow.com/a/6041773/946957
function is_JSON( $json ) {
	json_decode( $json );
	return ( json_last_error() == JSON_ERROR_NONE );
}