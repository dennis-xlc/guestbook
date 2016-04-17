<?php 
session_start(); 
if (isset($_GET['mid'])) {
    $messageId = $_GET['mid'];

  include("../config/config.php");
  $conn = mysql_connect($dbhost, $dbuser, $dbpassword, $database) or die (mysql_error());
  mysql_select_db($database, $conn) or die (mysql_error());


  $qry = "delete from message where id='".$messageId."'";
  $result = mysql_query($qry, $conn);
  mysql_close($conn);
}

header('Location:listmessages.php');
?>