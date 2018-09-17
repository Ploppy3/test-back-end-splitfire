<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbName = 'twitter';

global $db;

try{
  $db = new PDO('mysql:host='.$host.';dbname='.$dbName, $username, $password);
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );// Error Handling
} catch (PDOException $ex) {
  die(json_encode(array(
    'status' => 500, 
    'message' => 'internal server error',
    'description' => "can't connect to the database",
  )));
}