<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Belgrade');


session_start();

$counter = array();
$member = "";

include('db_config.php');
$connection;

if(!empty($_GET['member'])){
  $member = $_GET['member'];

  $sql = "DELETE FROM users WHERE id='$member'";

    if (mysqli_query($connection, $sql)) {
        echo "Record deleted successfully";
          
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }

}
if(!empty($_POST['check_list'])){
  $counter =  $_POST['check_list'];
  foreach($counter as $value){
    $sql = "DELETE FROM users WHERE id='$value'";
    
    if (mysqli_query($connection, $sql)) {
        echo "Record deleted successfully";
          
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
    
}


}



mysqli_close($connection);

header("Location: index.php");
?>


