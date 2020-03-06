<?php

$host ='localhost';
$username = 'root';
$password = '';
$dbname = "user_admin";

$connection = new mysqli('localhost', 'root', '', 'user_admin');
//var_dump($mysqli);
// Oh no! A connect_errno exists so the connection attempt failed!
if ($connection->connect_errno) {
  // The connection failed. What do you want to do? 
  // You could contact yourself (email?), log the error, show a nice page, etc.
  // You do not want to reveal sensitive information

  // Let's try this:
  echo "Sorry, this website is experiencing problems.";

  // Something you should not do on a public site, but this example will show you
  // anyways, is print out MySQL error related information -- you might log this
  echo "Error: Failed to make a MySQL connection, here is why: \n";
  echo "Errno: " . $connection->connect_errno . "\n";
  echo "Error: " . $connection->connect_error . "\n";
  
  // You might want to show them something nice, but we will simply exit
  exit;
}
return $connection;


