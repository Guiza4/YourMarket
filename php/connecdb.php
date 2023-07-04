<?php

$host = 'localhost';
$user = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'yourmarket'; //To be completed to connect to a database. The database must exist.
$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_errno) {
    die("Connect Error (" . $mysqli->connect_error);
}
return $mysqli;
