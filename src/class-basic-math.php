<?php

/**
 * Basic math class to extends Statistics classby perforing rudimentry math operations
 *
 * This class example demontrates PHP inheritance. It should however be a parent class!
 * 
 *  1. Override parent methods by declaring the same method in thee child class
 *  
 *  2. To access the parent class version of the method, use the scope resolution operaator
 * 
 * To add new functionality to an inherited method while keeping the original method intact, 
 * use the parent keyword with the scope resolution operator (::)
 *      
 *  Specifically: name the class where you want PHP to search for a method: 
 *      Statistics::get_mode( $array_numbers );
 *      
 *  Shortcut: if you just want refer to current class’s parent use the 'parent' keyword 
 *      parent:get_mode( $array_numbers );
 *
 * @since 0.0.1 (July 4, 2019)
 **/

require_once 'class-statistics.php';

class BasicMath extends Statistics {

private $product = 1;
private $sum = 0;


    //override parent constructor
    public function __construct( $array_from_client, $submission_type='parent_class_test' ) {

        // uncomment to restore parent method
        // parent::__construct( $array_from_client, $submission_type );

		$this->array_of_numbers  = $array_from_client; //setter
		$this->submission_type   = $submission_type; //setter

    }

    function set_product( $array_numbers ){

        foreach ( $array_numbers as $key => $value) {
            $this->product = $value * $this->product;
        }
        
    } 

    function get_product() {

        return $this->product;

    }

    function set_sum( $array_numbers ){

        foreach ( $array_numbers as $key => $value) {
            $this->sum = $value + $this->sum;
        }

    } 

    function get_sum() {

        return $this->sum;

    }

    /*
    * Housekeeping before script ends 
    *
    * To call a housekeeping function when the end of your script
    * is reached, use the __destruct() magic method. Useful for class cleanup 
    * (closing a database connection, for instance).
    *
    * @link http://us2.php.net/manual/en/language.oop5.magic.php
    * @link 
    

    public function __destruct()
    {
        echo 'The class "', __CLASS__, '" was destroyed.';
    }
   */ 
}