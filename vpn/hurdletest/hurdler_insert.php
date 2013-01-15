<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
$host = 'localhost'; // Host name (normally 'localhost')
$username = 'wattspor'; // MySQL login username
$password = 'wattball10'; // MySQL login password
$database = 'wattspor_database'; // Database name#

$hurdler_name = $_POST['hurdler_name'];
$hurdler_surname = $_POST['hurdler_surname'];
$hurdler_address = $_POST['hurdler_address'];
$hurdler_phone = $_POST['hurdler_phone'];
$hurdler_email = $_POST['hurdler_email'];
$hurdler_sex = $_POST['hurdler_sex'];
$hurdler_previous_best = $_POST['hurdler_previous_best'];

$phpdate = strtotime($_POST['hurdler_dob']); // convert date to PHP format
$hurdler_dob = date( 'Y-m-d H:i:s', $phpdate ); // convert PHP format to MySQL format

mysql_connect($host, $username, $password);
mysql_select_db($database);

$query = "INSERT INTO hurdler (name, surname, address, phone, email, dob, sex, previous_best) ";
$query = $query . "VALUES('$hurdler_name','$hurdler_surname','$hurdler_address','$hurdler_phone','$hurdler_email','$hurdler_dob','$hurdler_sex',";

// Handle the optional variable "Previous Best"
if( $hurdler_previous_best != "" )
{
	$query = $query . "'$hurdler_previous_best'";
}
else
{
	$query = $query . "NULL";
}

// Finish it off
$query = $query . ")";

// RUN DE INSERT
if( !mysql_query( $query ) )
{
	die( 'ERROR: ' . mysql_error( ) );
}

echo "Hurdler added";

mysql_close( );
?>
