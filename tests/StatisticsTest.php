<?php

/**
* Class to perform testing with PHPUnit
*
* Steps for using PHP Unit:
*    
* (1) Install composer as a global resource: https://getcomposer.org/download/
* (2) Create a folder named tests within project folder 
* (3) Give all test files and test classes the suffix "Test". For example, if testing Statistics.php 
*     name the test file StatisticsTest.php. If a class is called Employee, the test class
*      should be named EmployeeTest
* (4) Within test class:
*       a. Use 'require_once' to import any classes to be tested. 
*          NB: It's convention to save php files in a folder called 'src'
*       b. Prefix all test methods with "test":  test_get_all_statistics()
*       c. Import PHPUnit namespace via: Use PHPUnit\Framework\TestCase;
* (5) Using command prompt
*       a. install PHPUnit with composer:  $    composer require --dev phpunit/phpunit ^5
*       b. Run PHP Unit via:               $  ./vendor/bin/phpunit tests
*
*   Using tests instead of tests/ClassNameTest would instruct the PHPUnit command-line 
*   test runner to execute all tests found declared in *Test.php sourcecode files in the tests directory
*
* @link https://phpunit.de/getting-started/phpunit-5.html
* @link https://www.learnhowtoprogram.com/php/behavior-driven-development-with-php/introduction-to-phpunit
* @link https://www.cloudways.com/blog/getting-started-with-unit-testing-php/
*/

require_once "src/class-statistics.php";
require_once "src/class-basic-math.php";
require_once "src/class-throw-exceptions.php";

use PHPUnit\Framework\TestCase;

/*
* PHP 5 introduces the final keyword, which prevents child classes 
* Therefore the class cannot be extended. 
*/
final class StasticsTest extends TestCase {

    public function test_get_all_statistics() {

        //Arrange: (1) assign property values to variable, (2) create instance of class 
        $input = [5, 6, 8, 7, 5];
        $test_statistics = new Statistics ( $input );

        //Act: Call a method of the newly instiated object and store output in '$result'
        $result = $test_statistics->get_all_statistics();

        //Assert: compare desired result with actual result
        $this->assertEquals( array( "Mean"=>6.2,"Mode"=>5,"Median"=>6,"Range"=>3 ), $result) ;
    }

/*
Non-static method Statistics::get_mode() should not be called statically, assuming $this from incompatible context

    public function test_get_mode() {

        //Shorthand: arrange, act, assert combined into a single line
        $this->assertInstanceOf( Statistics::class, Statistics::get_mode( 5 ) );

    }

*/

    public function test_get_median() {

        //Arrange: (1) assign property values to variable, (2) create instance of class 
        $input = [ 1, 3, 4, 2, 7, 5, 8, 6 ];
        $test_statistics = new Statistics ( $input );

        //Act: Call a method of the newly instiated object and store output in '$result'
        $result = $test_statistics->get_median();

        //Assert: compare desired result with actual result
        $this->assertEquals( 4.5, $result) ;
    }    

}


final class BasicMathTest extends TestCase {

    public function test_get_product() {

        //Arrange: (1) assign property values to variable, (2) create instance of class 
        $input = [5, 6, 8, 7, 5];
        $test_basic_math = new BasicMath( $input );

        //Act: Call a method of the newly instiated object and store output in '$result'
        $result = $test_basic_math->get_product();

        //Assert: compare desired result with actual result
        $this->assertEquals( 8400, $result) ;
    }  

}

final class ThrowExecptionsTest extends TestCase {

    public function test_can_i_be_instantiated() {

        //$input = [5, 6, 8, 7, 5];
        $input = '5';
        /*
        * assertInstanceOf($expected, $actual)
        *
        * gives error if $actual != $expected in this case just test if a class can be 
        * created from an arbitrary function that instantiates a class. Pretty useless.
        *
        *@link https://phpunit.de/manual/6.5/en/appendixes.assertions.html#appendixes.assertions.assertInstanceOf
        */
        $this->assertInstanceOf( ThrowExceptions::class, ThrowExceptions::return_self( $input ) );
    
    }

    public function test_is_JSON_false() {

        //$input = [5, 6, 8, 7, 5];
        $input = 'dog';
        //Shorthand: arrange, act, assert combined into a single line and check if returned is truthy
        $this->assertFalse( ThrowExceptions::is_JSON( $input ) );
    
    }

    public function test_is_JSON_true() {

        //$input = [5, 6, 8, 7, 5];
        $input = 5;
        //Shorthand: arrange, act, assert combined into a single line and check if returned is falsey
        $this->assertTrue( ThrowExceptions::is_JSON( $input ) );
    
    }

    /**
    * @link https://stackoverflow.com/questions/5683592/phpunit-assert-that-an-exception-was-thrown/5683605#5683605
    */
    public function test_throw_invalid_argument() {

        //$input = [5, 6, 8, 7, 5];
        $input = 'dog';
        //call php super close
        $this->expectException(InvalidArgumentException::class); //;

        //test code that actually throws literally throws a 'InvalidArgumentException' exception
        ThrowExceptions::throw_invalid_argument( $input );
    
    }    

}
/*
public function testCannotBeCreatedFromInvalidInput() { 
    

    $this->expectException(InvalidArgumentException::class); //built-in php validator class
    $this->expectException(MyCustomException::class); // your own-custom validator class

    ClassName::functionName( $invalid_input_to_produce_exception )
    Email::fromString('invalid');

        //...and then add your test code that generates the exception 
        exampleMethod( $invalid_input_to_produce_exception );    
}
*/