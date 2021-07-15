<?php
$host = 'localhost';
$dbname = 'customdb';

define('DB_USER', 'yourUsername');
define('DB_PASSWORD', 'yourPassword');

try {
    $dbcon = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8;",DB_USER,DB_PASSWORD);
}
catch (PDOException $error){
    die("Error: ").$error->getMessage();
}

