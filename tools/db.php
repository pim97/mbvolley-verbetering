<?php

//Server data
$url = 'localhost';
$userid = 'projec1q_mbvolley';
$password = 'projec1q_mbvolley';
$database = 'projec1q_mbvolley';

//Nieuwe mysqli object
$mysqli = new mysqli ( $url, $userid, $password, $database );

//Checkt of kan connecten, zo niet, dan een error
if ($mysqli->connect_errno) {
	die ( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error );
}

//Returned de mysqli pool
function get_mysqli() {
    global $mysqli;
    return $mysqli;
}

?>