<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
include("../database.php");


// ========== Work out the start date for the desired event =========
$event_id = $_POST['event_id'];
$query = "SELECT * FROM event WHERE event_id='$event_id'";
$result_array = mysql_fetch_array( mysql_query( $query ) );

$event_name = $result_array['name']; 
$date_start_php = strtotime( $result_array['start_date'] );
$date_start_mysql = date( 'Y-m-d H:i:s', $date_start_php );
$date_end_php = strtotime( $result_array['end_date'] );
$date_end_mysql = date( 'Y-m-d H:i:s', $date_end_php );



?>
