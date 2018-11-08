<?php

$hostname = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'darts';

$dbc = mysqli_connect($hostname, $username, $password, $dbname) OR die ('could not connect ' . mysqli_connect_error());

mysqli_set_charset($dbc, 'utf8');

?>