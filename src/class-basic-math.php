<?php

/**
 * Math Class to extend Statistics Class performs rudimentry math operations
 *
 * This demosntrates PHP inhereitance.
 *  ‘override’ the parent methods, by declaring the same method in  te child class
 *  to access the parent class’  version of the method, use the scope resolution operaator
 * To add new functionality to an inherited method while keeping the original method intact,\
 *  use the parent keyword with the scope resolution operator (::)
 *      specifically name the class where you want PHP to search for a method:
 *      shortcut if you just want refer to current class’s parent – by using the ‘parent’ keyword
 *
 * @since 0.0.1 (July 4, 2019)
 **/
require_once 'class-statistics.php';

class BasicMath extends Statistics {

private $product = 1;

    public function __construct( $array_numbers ) {

        parent::__construct( $array_numbers );
        
        $this->set_product( $array_numbers );

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