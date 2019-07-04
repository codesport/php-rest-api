<?php

// static: allows properries and methods to be accessed without an instantiation of the class.

class ThrowExceptions {

    static function is_JSON( $json ) {
        json_decode( $json );
        return ( json_last_error() == JSON_ERROR_NONE );
    }  
  
 /*   */
    static function is_JSON2( $json ) {
        json_decode( $json );

        if ( json_last_error() == JSON_ERROR_NONE ) {
            
            return TRUE;

        } else {

            return FALSE;

        }

    }     


    static function throw_invalid_argument( $json ){

        json_decode( $json );

        if ( json_last_error() != JSON_ERROR_NONE ) {
            
            throw new InvalidArgumentException( $json . ' is not a valid JSON string.' );

        }
    }


    //useless
    static function return_self ( $json ){
        return new self($json);
    
    }
    
}