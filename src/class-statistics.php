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
 * Class, method, and property naming conventions aligned with WordPress standards via @link
 * https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/#naming-conventions
 *
 *	Usage:
 *		1. Instantiate new object while simultaneously intitializing $array_from_client, $submission_type:
 *			$statistics_object = new Statistics( $array_of_numbers['numbers'], 'API' );
 *
 *		2. Send object to the method (getter function) get_all_statistics() and store output in an array
 *			$server_response['result'] = $statistics_object->get_all_statistics();
 *
 * @package    Fizz Buzz for Company NC001
 * @version    1.0.0 (June 15, 2019)
 * @since      0.0.1 (January 21, 2016)
 */


/**
 * Statistics Class using built-in PHP array functions
 *
 * Currently contains methods for computing basic stats functions.
 *
 * @since 0.0.1 (January 21, 2016)
 **/
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
	public $array_of_numbers; 	// this can be private. user modifying thi adds no value
	public $submission_type; 	// auto-sent by mmmr.php. Expected values: 'web-client' or 'API'
	
	//may optionally declare as 'protected' if we want to support inheritance 
	private $mean; 
	private $mode;
	private $median;
	private $range;
	private $statistics_array;	//built by get_all_statistics() method

	/*
	* Using  constructor for intitializing class globals. 
	* NB: '$this' is shorthand for 'apply to any created object' 
	* NB: $this' properties are available globally throughout the class.
	*/
	function __construct( $array_from_client, $submission_type='web-client' ) {

		$this->array_of_numbers  = $array_from_client; //setter
		$this->submission_type   = $submission_type; //setter
		
		//Initialize all private variables through method calls. 
		$this->set_all_statistics( $array_from_client );

	}

	/*
	* Set all statistics in bulk
	*/
	public function set_all_statistics( $array_of_numbers ) {

		$this->set_mean( $array_of_numbers );
		$this->set_mode( $array_of_numbers );
		$this->set_median( $array_of_numbers );
		$this->set_range( $array_of_numbers );

	}


	/*
	* Get all statistics in bulk and return to user as array
	*/
	public function get_all_statistics() {

		$statistics_array['Mean'] 	= $this->get_mean();
		$statistics_array['Mode'] 	= $this->get_mode();
		$statistics_array['Median']	= $this->get_median();
		$statistics_array['Range']	= $this->get_range();

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
	 * @param array $array_of_numbers Numbers used to calculate mean.
	 */
	public function set_mean( $array_of_numbers ) {

		$this->mean = round( array_sum( $array_of_numbers ) / count( $array_of_numbers ), 2) ;	

	}

	public function get_mean() {

		return $this->mean;	

	}


	/**
	 * Setter to compute mode by maximizing built-in PHP functions
	 *
	 * Mode: the number that occurs the most often. If no number is repeated, there is no mode
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
	 * 
	 * @param array $array_of_numbers Numbers used to calculate mode.
	 */
	public function set_mode( $array_of_numbers ) {

		$array_of_numbers_by_frequency = array_count_values( $array_of_numbers ); //original_num => frequency 

		$max_occurence = max( $array_of_numbers_by_frequency ); //max gives 'max' value in an array


		if ( $max_occurence === 1 ) { //if no mode. Forcing type recognition with ===

			/*
			* give an null or empty value if no mode exists.
			*/
			$this->mode = null; // or $this->mode = '';

		} else {

			//Give me all keys (original numbers) that equal $max_occurences 
			$mode_raw = array_keys( $array_of_numbers_by_frequency, $max_occurence ); 

			if ( count( $mode_raw ) === 1 ) { //if only a single mode exists. Forcing type recognition with ===

				$this->mode = $mode_raw[0];

			} else { //multiple modes exists

				$this->mode = null; //return a null value
			}

		}

	}

	public function get_mode() {

		return $this->mode;	

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
	 *  	b. If array size (n) is even (ie., n % 2 == 0): Two elements in the middle are medians at indexes 
	 * 	       floor((n-1)/2) and at n/2
	 * 
	 * Tutrials on computing median:
	 * 
	 * See section called "Searching for the Median"  @link http://www.drdobbs.com/parallel/finding-the-median-of-two-sorted-arrays/240169222
	 * Code Examples in popular languages: @link https://www.geeksforgeeks.org/program-for-mean-and-median-of-an-unsorted-array/
	 * This example will yield incorrect results b/c lack of sort @link https://gist.github.com/ischenkodv/262906
	 * @link https://www.google.com/search?q=what+is+median+of+an+array
	 * 
	 * @param array $array_of_numbers Numbers used to calculate median.
	 */
	public function set_median( $array_of_numbers ) {

		sort( $array_of_numbers );
		$array_length = count( $array_of_numbers );

		//check if odd (non-zero length modulo 2)
		if ( $array_length % 2 ) { 

			$this->median = $array_of_numbers[ floor( $array_length - 1 ) / 2 ];

		} else { //if even we have 2 medians

			$first_median = $array_of_numbers[ floor( $array_length - 1 ) / 2 ];

			$second_median = $array_of_numbers[ ( $array_length ) / 2 ];

			$this->median = ( $first_median + $second_median ) / 2;

		}

	}

	public function get_median() {

		return $this->median;	

	}


	/**
	 * Setter to compute distance between high and low numbers
	 *
	 * @param array $array_of_numbers Numbers used to calculate range.
	 */
	public function set_range( $array_of_numbers ) {

		$low = min( $array_of_numbers );
		$high = max( $array_of_numbers );

		$this->range = $high - $low; 

	}


	public function get_range() {

		return $this->range;	

	}	


} 






