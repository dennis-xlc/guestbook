<?php 
session_start(); 
if (isset($_GET['userid'])) {
    $userId = $_GET['userid'];

  include("../config/config.php");
  $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
  mysql_select_db($database, $conn) or die (mysql_error());


  $qry = "delete user, message from user left join message on user.id = message.user_id where user.id = ".$userId;
  $result = mysql_query($qry, $conn);
  mysql_close($conn);
}

header('Location:listusers.php');
?>