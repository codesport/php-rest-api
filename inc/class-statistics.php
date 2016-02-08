<?php

/**
 * Class library file for statistical methods
 *
 * Obect Oriented Programming (OOP) demonstration using built-in PHP array functions
 * Extra verbose commenting for usage in future teaching session. PHP coding standards
 * from @link https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/
 * and @link https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/
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
 * the class.  Give methods, add'ls parameters variables
 *
 * @since 0.0.1 (January 21, 2016)
 *
 */
class Statistics {

	/*
	 * First Declare any and all member variables (properties/class globals)
	 * used within the class. Set default values if needed
	 */
	public $array_of_numbers;
	public $array_length;
	public $statistics_array;
	public $submission_type; //web-client or API
	

	//Use constructor for intitializing class globals 
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

		$mean = array_sum( $this->array_of_numbers ) / $this->array_length ;	

		return $mean;

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

			return null;

		} elseif ( $max_occurence === 1 && $this->submission_type == 'API' ) { //Forcing type recognition. Forcing type recognition with ===

			return '';// can just leave this empty

		} else {

			//Give me all keys (original numbers) that equal $max_occurences 
			$mode = array_keys( $array_of_numbers_by_frequency, $max_occurence ); 

			if ( count( $mode ) === 1 ) { //if only a single mode exists. Forcing type recognition with ===

				return $mode[0];

			} else { //multiple modes exists

				return $mode; //return an array of modes
			}

		}

	}

	/**
	 * Setter to compute median
	 *
	 */
	public function set_median() {

		$middle_of_array = $this->array_length / 2 ;

		$median = $this->array_of_numbers[$middle_of_array - 1]; 

		return $median;

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






