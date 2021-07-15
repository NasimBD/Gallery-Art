<?php
// This file provides the information for accessing the database.and connecting to MySQL.
// First, we define the constants:
define('DB_HOST', 'localhost');
define('DB_USER', 'yourUserName');
define('DB_PASSWORD', 'yourPassword');
define('DB_NAME', 'customdb');
define('USERS', 'users');


$RESERVES = 'reserves_info';

// Next we assign the database connection to a variable that we will call $dbcon: #2
try {
    $dbcon = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $dbcon->set_charset('utf8');
} catch (Exception $e) // We finally handle any problems here #3
{
// print "An Exception occurred. Message: " . $e->getMessage();
    print "The system is busy please try later";
} catch (Error $e) {
//print "An Error occurred. Message: " . $e->getMessage();
    print "The system is busy please try again later.";
}

