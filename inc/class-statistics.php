<?php

/**
 * Class library file for statistical methods
 *
 * Obect Oriented Programming (OOP) demonstration using built-in PHP array functions
 *
 * In PHP we typically use explicit getter and setter methods. "Getters" gather and package
 * the information computed by "setter" methods.
 *
 * Extra verbose commenting for usage in future teaching session. PHP coding standards
 * from @link https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/
 * and @link https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/
 *
 *	Usage:
 *		1. Instiate new object while simultaneously intitializing $array_from_client, $submission_type:
 *			$statistics_object = new Statistics( $array_of_numbers['numbers'], 'API' );
 *
 *		2. Send object to the method (getter function) get_all_statistics() and store output in an array
 *			$server_response['result'] = $statistics_object->get_all_statistics();
 *
 *
 * @package    Fizz Buzz for Company NC001
 * @version    0.0.1 (January 21, 2016)
 * @since      0.0.1 (January 21, 2016)
 */


/**
 * Statistics Class using built-in PHP array functions
 *
 * Currently contains methods for computing basic stats functions.
 *
 * TODO: Allow statistical methods to be called individually outside 
 * the class.  Give methods parameters variables to accept 'array of numbers'
 *
 * @since 0.0.1 (January 21, 2016)
 */
class Statistics {

	/*
	 * First Declare any and all member variables (properties/class globals)
	 * used within the class. Set default values if needed
	 * 
	 * All class globals should probably be made either private or protected
	 * since they will only be modified and set from within the class, and not from 
	 * external class calling or instantiation
	 * 
	 */
	public $array_of_numbers; 	// sent by client
	public $array_length;		// calculated by constructor
	public $statistics_array;	// built by get_all_statistics() method
	public $submission_type; 	// auto-sent by mmmr.php.  Values: 'web-client' or 'API'
	
	//may optionally declare as 'protected' if we want to support inheritance 
	private $mean; 
	private $mode;
	private $median;
	private $range;

	//Use constructor for intitializing class globals. '$this' is shorthand for  'apply to any created object' 
	function __construct( $array_from_client, $submission_type ) {
	
		$this->array_of_numbers  = $array_from_client;
		$this->array_length 	 = count( $this->array_of_numbers );
		$this->submission_type   = $submission_type;

	}


	public function get_all_statistics() {

		$statistics_array['Mean'] 	= round( $this->set_mean(), 3);
		$statistics_array['Mode'] 	= $this->set_mode();
		$statistics_array['Median']	= round( $this->set_median(), 3);
		$statistics_array['Range']	= round( $this->set_custom_range(), 3);

		return $statistics_array;

	}

	
	/**
	 * Setter to compute mean by maximizing built-in PHP functions 
	 *
	 * count — Count all elements in an array (array length)
	 * @link http://php.net/manual/en/function.count.php
	 *
	 * array_sum — Calculate the total of all values in an array
	 * @link http://php.net/manual/en/function.array-sum.php*
	 *
	 * @param none
	 * @return integer || float	 
	 */
	public function set_mean() {

		$this->mean = array_sum( $this->array_of_numbers ) / $this->array_length ;	

	}


	/**
	 * Setter to compute mode by maximizing built-in PHP functions
	 *
	 * array_keys — returns keys or a subset of the keys of an array. Orig array keys become values
	 * shall use a subset specified by the first key of the asorted $array_of_numbers_by_frequency variable
	 * 
	 * Example:
	 *  array_keys ( $array  [, give_all_keys_referencing_this_value [, (bool)evaluate by type ]] )
	 *
	 * @link http://php.net/manual/en/function.array-keys.php
	 *
	 * array_count_values - returns associative array. Values of orig array are keys and their counts are values
	 * @link http://php.net/manual/en/function.array-count-values.php
	 *
	 * array_search — searches the array for $needle and returns the corresponding key if successful
	 * @link http://php.net/manual/en/function.array-search.php
	 */
	public function set_mode() {

		$array_of_numbers_by_frequency = array_count_values( $this->array_of_numbers ); //original_num => frequency 

		$max_occurence = max( $array_of_numbers_by_frequency ); //max gives 'max' value in an array


		if ( $max_occurence === 1 && $this->submission_type == 'web-client' ) { //if no mode. Forcing type recognition with ===

			$this->mode = null;

		} elseif ( $max_occurence === 1 && $this->submission_type == 'API' ) { //Forcing type recognition. Forcing type recognition with ===
			/*
			* If client is using via api, just give hime
			* an empty value if no mode exists.
			*/
			$this->mode = '';

		} else {

			//Give me all keys (original numbers) that equal $max_occurences 
			$mode_raw = array_keys( $array_of_numbers_by_frequency, $max_occurence ); 

			if ( count( $mode_raw ) === 1 ) { //if only a single mode exists. Forcing type recognition with ===

				$this->mode = $mode_raw[0];

			} else { //multiple modes exists

				$this->mode = $mode_raw; //return an array of modes
			}

		}

	}

	/**
	 * Setter to compute median
	 * 
	 *  How to compute:
	 * 
	 *  1. Array most be sorted first
	 *  2. Goal is find position (i.e, index) of median
	 * 	3. Assume 0-indexed array structure. Therefore:
	 *  	a. If array size (n) is odd: Median is at index (n-1)/2 
	 * 		   NB: subtract 1 to make 0-indexed positioning
	 *  	b. If array size (n) is even: Two elements in the middle are medians at indexes 
	 * 	       floor((n-1)/2) and at n/2
	 * 
	
	 * 
	 *
	 */
	public function set_median() {

		$sorted_array = sort( $this->array_of_numbers );

		//check if odd (non-zero length modulo 2)
		if ( $this->array_length % 2 ) { 

			$this->median = $sorted_array[ floor( $this->array_length - 1 ) / 2 ];

		} else { //if even we have 2 medians

			$first_median = $sorted_array[ floor( $this->array_length - 1 ) / 2 ];

			$second_median = $sorted_array[ floor( $this->array_length ) / 2 ];

			$this->median = ( $first_median + $second_median ) / 2;

		}

	}


	/**
	 * Setter to compute distance between high and low numbers
	 *
	 */
	public function set_custom_range() {

		$low = min( $this->array_of_numbers );
		$high = max( $this->array_of_numbers );

		$range = $high - $low; 

		return $range;

	}


} 






