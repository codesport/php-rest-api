<?php

/**
 * API which accepts POST requests that are JSON objects or Comma delimited strings
 *
 * Core Function: Accepts single JSON object with 'numbers' attribute. Then,
 *  1. Converts JSON object to PHP array 
 *  2. Sends array to Statistics Class
 *  3. Converts array output from Statistics Class to JSON object
 *  4. Echoes JSON object to stdout (terminal)
 *
 * Secondary Function: Accepts comma delimited string. Then 
 *  1. Converts string to PHP array 
 *  2. Sends array to Statistics Class
 *  3. Echoes Class output to stdout (terminal)
 *
 * TODO: Add a new class file to accept additional functional (e.g., user authetication)
 *
 * @package    Fizz Buzz for Company NC001
 * @version    0.0.1 (January 21, 2016)
 * @since      0.0.1 (January 21, 2016)
 */

include 'inc/class-statistics.php';
include 'inc/functions.php';


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {


	if ( isset( $_POST['string'] ) ) {


	//use of 'htmlspecialchars' is an OCD habit to minimally sanitize html form submission. 
	$clean_numbers = trim( str_replace( ',', '', htmlspecialchars( $_POST['string'] ) ) ); 

	/*
	 * May further sanitize input by doing a foreach loop to check if numeric
	 * and other sanitziation techniques...
	 */

	$clean_numbers_array = explode( ' ', $clean_numbers);

	$statistics_for_view = new Statistics( $clean_numbers_array, htmlspecialchars( $_POST['submission_type'] ) );

	
	$server_response = $statistics_for_view->get_all_statistics();   //$server_response['result'] = $statistics_for_view->get_all_statistics();

	echo json_encode( $server_response );


	} elseif (isset( $_POST['json'] ) ) {


		if ( is_JSON( $_POST['json'] ) ) {

			$array_of_numbers = json_decode( $_POST['json'], true ); //'true' forces to 0-indexed array vs object

			$statistics_for_view = new Statistics( $array_of_numbers['numbers'], htmlspecialchars( $_POST['submission_type'] ) );

			/*
			 * Pedagogical Note:
			 *
			 * Since the below 2 lines are repeated in the ensuing 'else{ //API on!' block, 
			 * an argument can be made for placing them in a function to adhere to DRY principles. 
			 * However, they will remain here. Function encapsulation would obscure the logical
			 * flow of calling (getting the value of) our object. Code clarity ALWAYS trumps
			 * cleverness and cute tricks 
			 */
			$server_response['result']	= $statistics_for_view->get_all_statistics();

			echo json_encode( $server_response );

		} else { //if bad json, force ajax error callback

			generate_500_error();

		}


	} else { //API on!


		$data_stream = file_get_contents('php://input'); //capture incoming data stream

		if ( is_JSON( $data_stream ) ) {

			$array_of_numbers = json_decode( $data_stream, true ); 

			$statistics_for_api = new Statistics( $array_of_numbers['numbers'], 'API' );

			$server_response['result'] = $statistics_for_api->get_all_statistics();

			echo json_encode( $server_response );

		} else {


			generate_500_error();

		}

	}


} else {// if NOT POST

	generate_400_error();

}