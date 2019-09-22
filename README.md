[![Build Status](https://travis-ci.org/codesport/php-rest-api.svg?branch=php-class-updates)](https://travis-ci.org/codesport/php-rest-api) [![BCH compliance](https://bettercodehub.com/edge/badge/codesport/php-rest-api?branch=php-class-updates)](https://bettercodehub.com/)

# 2019 Updates

1. Updated DocBlock in [`class-statistics.php`](/src/class-statistics.php) with instructions on how to use the class

2. Corrected [calculation of the median](src/class-statistics.php#L195) in  [`class-statistics.php`](src/class-statistics.php#L195)

3. ***Best Practice:*** Made [computed properties private](src/class-statistics.php#L46) for encapsulation purposes. Accessing of computed properties are now only allowed via setter and getter methods. To illustrate:

```php

	public $array_of_numbers; 	// this can be private. user modifying thi adds no value
	public $submission_type; 	// auto-sent by mmmr.php. Expected values: 'web-client' or 'API'
	//may optionally declare as 'protected' if we want to support inheritance 
	private $mean; 
	private $mode;
	private $median;
	private $range;
	private $statistics_array;
```

4. ***Best Practice:*** Installed composer and created a `tests/` folder for automated unit testing with PHPUnit. See the doc bloc in [`StatisticsTest.php`](tests/StatisticsTest.php) to learn how to deploy PHPUnit on your development box

5. Moved core PHP files to `src/` and deleted the `inc/` folder 

6. ***Best Practice:*** Added [`.travis.yml`](https://github.com/codesport/php-rest-api/blob/php-class-updates/.travis.yml/) (i.e., travis-ci configuration file) to automate unit testing

7. ~~Added the Better Code Hub [configuration](https://bettercodehub.com/docs/configuration-manual#excludingfilesanddirectoriesfromanalysis) file ([`.bettercodehub.yml`](.bettercodehub.yml/)) to exclude the tests/ folder from automated code quality review.~~

## Continuous Integration (CI)

Some of the most interesting updates is the use of autmated testing and continous integration. Here are the key terms

<dl>
  <dt>Continuous Integration (CI):</dt> <dd>a software development workflow which automates build creation and code testing.</dd> 

 <dt>Travis CI:</dt> <dd>at the most basic level, it tests your under various deployment environments. It then alerts developers of bugs, quality issues, and failures. 

<dt>Better Code Hub:</dt> <dd>a CI tool that checks your GitHub codebase against 10 engineering guidelines devised by the authority in software quality, Software Improvement Group..</dd>
</dl>


# Authorship and Credits
This PHP [Rest API](https:/google.com/search?q=Rest)<sup id="reference-1">[1](#footer-1)</sup> along with this `README` file was developed by **Marcus** as a part of a code challenge he was asked to complete in January 2016.  He has donated it to **[Code Sport](https://codesport.io?utm_medium=ext-website&utm_campaign=exams-online-apps-public&utm_content=codesport-link-1&utm_source=bitbucket-php-code-challenge&utm_term=code-sport-io)** for use in our small group, classroom instruction.  

The rewrite-rules were found back in 2013 from an unknown website, and have been reposted below in Part 3, Rewrite Rules.

# PHP Application Development Excercise Overview

Demonstrates understanding of Object Oriented PHP and structured application development. Naming conventions and formatting syntax **strongly adheres** to the [WordPress Coding Standards](http://make.wordpress.org/core/handbook/best-pratices/coding-standards/php). Tested and uploaded to a live LAMP server. Below are the two main files used along with the rewrite rules for "pretty" urls.

### 1. The Class Library File for Statistical Methods
 
**inc/class-statistics.php** This is the *Phase 1* request and contains a single class called Statistics. It serves as an Obect Oriented Programming (OOP) demonstration using built-in PHP array functions. Extra verbose commenting is used as this excercise will be used in future teaching session. 

### 2. Endpoint File (Pseudo-Controller)

**mmmr.php** This is the *Phase 2* request and is an API accepting POST requests that are either JSON or comma-space separated strings.  


#### Core Functionality: Accepts single JSON object with 'numbers' attribute. Then,
1. Converts JSON object to PHP array 
2. Sends array to Statistics Class
3. Converts array output from Statistics Class to JSON object
4. Echoes JSON object to stdout (terminal)

#### Ancillary Functionality: Accepts comma delimited string. Then 

1. Converts string of numbers (e.g. 2, 4, 5 7 9 2) to PHP array. Accepts comma AND space delimited or just space delimited numbers 
2. Sends array to Statistics Class
3. Echoes Class output to stdout (terminal)

#### Additional Developer Notes on Endpoint File `mmmr.php`

 * **Ancillary Functionality:** For testing and proof-of-concept pruposes, the application was first bulit using a View (i.e., an AJAX-ified web form) contained within an `index.php` file. However, this backend-end form processing logic has been left inside `mmmr.php` after project completion. The "leftover" form processing logic may aid in using this excercise as a platform for other applications as well as for educational purposes. See `.gitignore` for the full list of testing files used. 

* **Core Functionality:** The Core API functionallty is controlled by this block of code:

```php
	} else { //API on!


		$data_stream = file_get_contents('php://input'); //capture incoming data stream

		if ( is_JSON( $data_stream ) ) {

			$array_of_numbers = json_decode( $data_stream, true ); 
			//print_r($array_of_numbers['numbers']);

			$statistics_for_api = new Statistics( $array_of_numbers['numbers'], 'API' );

			$server_response['result'] = $statistics_for_api->get_all_statistics();

			echo json_encode( $server_response );

		} else {


			generate_500_error();

		}

	}
```

### 3. Rewrite Rules

Rewrite used for deploying on a live server are below. These rules manage extensionless files names.That is, the api may be accessed via `/mmmr`.


```text
RewriteEngine On
 RewriteBase /
 
 # remove .php; use THE_REQUEST to prevent infinite loops
 RewriteCond %{THE_REQUEST} ^GET\ (.*)\.php\ HTTP
 RewriteRule (.*)\.php$ $1 [R=301]
 
 # remove index
 RewriteRule (.*)/index$ $1/ [R=301]
 
 # remove slash if not directory
 RewriteCond %{REQUEST_FILENAME} !-d
 RewriteCond %{REQUEST_URI} /$
 RewriteRule (.*)/ $1 [R=301]
 
 # add .php to access file, but don't redirect
 RewriteCond %{REQUEST_FILENAME}.php -f
 RewriteCond %{REQUEST_URI} !/$
 RewriteRule (.*) $1\.php [L]

```

# PHP Application Development Excercise: Task Description

## Phase 1
A client has asked you to write a simple PHP library that will calculate the mean, median, mode, and range of a set of numbers. Your methods should accept an array of numbers and implement methods for mean, median, mode and range independently. All returned values should be rounded to a maximum of 3 decimal places. If a return value does not exist, your methods should return NULL.

## Phase 2
Your client has asked you to make this library available via an API. Your API should implement a single endpoint called "/mmmr" with no query string parameters. When a POST request is called to "/mmmr", a single JSON object will be passed with an attribute called "numbers". "numbers" is a JSON array of n numbers that should be processed. The script should process the mean, median, mode and range of the numbers and return back a JSON object.

* If any value does not exist, an empty string should be returned.
* Any system errors should be handled gracefully with a JSON response and a 500 error.
* If a request is sent to "/mmmr" that are is not a POST request, a JSON response and a 404 error should be returned.
___

<sup id="footer-1">[1](#reference-1)</sup> Representational State Transfer Application Programming Interface


