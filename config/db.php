<?php

/* 
	Database credentials. 
	Assuming you are running MySQL
	server with default setting (user 'root' with no password) 
*/

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'investors');


# Attempt to connect to MySQL database;

$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
 
// Check connection

if( $link->error ) die( "ERROR: DATABASE CONNECTION FAILED: " . $link->error );

