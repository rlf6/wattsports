<?php
	error_reporting(E_ALL); 
	ini_set('display_errors', 1); 
		
	include("../database.php");

	// ========== Work out the start date for the desired event =========	
	//$event_id = $_POST['event_id'];
	$event_id = 1; // TESTING ONLY
	$query = "SELECT * FROM event WHERE event_id='$event_id'";
	$result = mysql_query( $query );
	if( mysql_num_rows( $result ) < 1 ) // this may happen
	{
		echo "Error: Event with id '" . $event_id . "' does not exist";
		return;
	}
	else if( mysql_num_rows( $result ) > 1 ) // this should never happen
	{
		echo "Error: More than one event with id '" . $event_id . "' exists";
		return;
	}

	$result_array = mysql_fetch_array( $result );

	$event_name = $result_array['name']; 
	$date_start_php = strtotime( $result_array['start_date'] );
	$date_start_mysql = date( 'Y-m-d H:i:s', $date_start_php );
	$date_end_php = strtotime( $result_array['end_date'] );
	$date_end_mysql = date( 'Y-m-d H:i:s', $date_end_php );

	// Count the number of registered participants
	$sex = 'm'; // TESTING ONLY
	//$query = "SELECT * FROM hurdler WHERE sex = '" . $sex . "'";
	//$result = mysql_query($query);
	//$num_hurdlers = mysql_num_rows( $result );
	$num_hurdlers = 50; // TESTING ONLY

	$num_lanes = 8; // MAKE THIS VARIABLE (probably not today though)
					// MOVE THIS TO SETTINGS

	// ========== Work out how many days will be needed for the competition ==========
	$num_days = 0;
	$num_hurdlers_today = $num_hurdlers;

	// Check that this competition is valid at all
	// If there are *any* participants, then it will take at least one day
	if( $num_hurdlers > 0 )
		$num_days++;
	else
	{
		echo "Error: No hurdlers registered for tournament.";
		return;
	}

	// Work out if the initial day is required
	$query = "SELECT * FROM hurdler WHERE previous_best IS NULL";
	$result = mysql_query( $query );
	$num_rows = mysql_num_rows( $result );
	if( mysql_num_rows( $result ) > 0 )
	{
		echo "Information: " . $num_rows . " hurdler(s) with no previous best time on record.<br>
				The initial day will be required.<p>";
		$num_days++;
	}

	// Loop through days until everyone fits on the same track
	// which indicates that this is the final race
	while( !($num_hurdlers_today <= $num_lanes) )
	{
		// Half the number of hurdlers
		$num_hurdlers_today = ( $num_hurdlers_today / 2 );
		
		// Round up to the nearest multiple of $num_lanes
		if( ( $num_hurdlers_today % $num_lanes ) > 0 )
		{
			$num_hurdlers_today += ( $num_lanes - ( $num_hurdlers_today % $num_lanes ) );
		}

		// Add this day
		$num_days++;
	}

	echo "Number of days needed for hurdle tournament: ".$num_days;


	mysql_close( );
?>
