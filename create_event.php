<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
$host = 'localhost'; // Host name (normally 'localhost')
$username = 'wattspor'; // MySQL login username
$password = 'wattball10'; // MySQL login password
$database = 'wattspor_database'; // Database name#

$date_start_php = strtotime( $_POST['date_start'] ); // convert date to PHP format
$date_start_mysql = date( 'Y-m-d H:i:s', $date_start_php ); // convert PHP format to MySQL format

$date_end_php = strtotime( $_POST['date_end'] );
$date_end_mysql = date( 'Y-m-d H:i:s', $date_end_php );

$event_name = $_POST['event_name'];
$event_type = $_POST['event_type'];

mysql_connect($host, $username, $password);
mysql_select_db($database);

// Work out if the initial day is required
$query = "INSERT INTO event (name, event_type, start_date, end_date) VALUES('$event_name', '$event_type', '$date_start_mysql', '$date_end_mysql')";
$result = mysql_query( $query );

echo "Event added";

mysql_close( );
?>
