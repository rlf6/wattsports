<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

session_start();

if(empty($_SESSION["username"])){
	header('Location: http://vpn.wattsports.co.uk');
} 
//retrieve username and password
$user = $_SESSION['username'];


//connect to database
include("../database.php");


$result = mysql_query("SELECT * FROM admins WHERE `username` = '$user' ") or die(mysql_error());

$re = mysql_fetch_array($result)or die(mysql_error());

  // An authenticated user has logged out -- be polite and thank them for
  // using your application.
  // print($_SESSION["username"]);
  session_unset();
  session_destroy();
  setcookie("PHPSESSID",0, time());

  //print($_SESSION["username"]);
    echo " Thanks ".$re[0] ." for
                 using the website";


  // Destroy the session.


?>

<html>

<p> You have successfully Logged out, you will be redirected to the login page shortly
</p>
<meta http-equiv="refresh" content="2;url=http://vpn.wattsports.co.uk/">


</html>