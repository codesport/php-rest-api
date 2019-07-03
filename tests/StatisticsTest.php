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
*       c. Import PHPUnit class via: Use PHPUnit\Framework\TestCase;
* (5) Using command prompt
*       a. install PHPUnit with composer:  $    composer require --dev phpunit/phpunit ^5
*       b. Run PHP Unit via:               $  ./vendor/bin/phpunit tests
*
* @link https://phpunit.de/getting-started/phpunit-5.html
* @link https://www.learnhowtoprogram.com/php/behavior-driven-development-with-php/introduction-to-phpunit
* @link https://www.cloudways.com/blog/getting-started-with-unit-testing-php/
*/

require_once "src/class-statistics.php";

use PHPUnit\Framework\TestCase;

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


}