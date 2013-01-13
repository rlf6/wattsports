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
	// ================ And how many races will be needed on each day ================
	$days = array( );
	$num_days = 0;

	// Check that this competition is valid at all
	// If there are *any* participants, then it will take at least one day
	if( $num_hurdlers < 1 )
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
		
		// work out how many races need to be run
		$days[$num_days] = ceil( $num_rows / $num_lanes ); // round up because we can't have half a race
	}

	// Loop through days until everyone fits on the same track
	// which indicates that this is the final race	
	$num_hurdlers_today = $num_hurdlers;
	$i = 0;
	while( $num_hurdlers_today >= $num_lanes && ($i < 10) )
	{
		// Add this day
		$num_days++;
		
		// work out how many races need to be run
		$days[$num_days] = ceil( $num_hurdlers_today / $num_lanes );
		
		// if we've reached the last day (only one race for this day) then break.
		if( $days[$num_days] == 1 )
			break;
		
		// Half the number of hurdlers
		$num_hurdlers_today = ( $num_hurdlers_today / 2 );
		
		// Round up to the nearest multiple of $num_lanes (unless it's smaller than the number of lanes
		if( ( $num_hurdlers_today % $num_lanes ) > 0 )
			$num_hurdlers_today += ( $num_lanes - ( $num_hurdlers_today % $num_lanes ) );
			
		$i++;
	}

	// PRINT OUTPUT
	echo "Number of days needed for hurdle tournament: ".$num_days . "<br>";	
	for( $i = 1; $i <= count( $days ); $i++ )
		echo "Day " . $i . " has " . $days[$i] . " races<br>";

	// ==================== Work out the times and dates for the races ====================	
	// Facility opening hours (hours, minutes, seconds)
	$opening_time = array( 9, 0, 0 ); // TESTING ONLY
	$closing_time = array( 15, 0, 0 ); // TESTING ONLY
	$time_between_races = array( 0, 30, 0 ); // TESTING ONLY
	
	// CALCULATE EARLIEST POSSIBLE RACE SLOT
	$date_start_array = explode(" ", date("j n Y", $date_start_php));
	echo "<p>Start Date: " . $date_start_array[0] . " / " . $date_start_array[1] . " / " . $date_start_array[2] . "<br>";
	
	// Create a new 2d-array to hold the start timedates for each race
	$race_times = array( );
	for( $i = 1; $i <= count( $days ); $i++ )
		$race_times[$i] = array( );
	
	// Add however many races are needed on each of the days
	$race_date = $date_start_array;
	for( $i = 1; $i <= count( $days ); $i++ )
	{
		$race_time = $opening_time;		
		for( $j = 1; $j <= $days[$i]; $j++ )
		{
			$race_times[$i][$j] = mktime( $race_time[0], $race_time[1], $race_time[2], $race_date[1], $race_date[0], $race_date[2]);
			echo "Day " . $i . ", race " . $j . " scheduled on: " . date("F j Y", $race_times[$i][$j]);
			echo ", at " . date("g:i a", $race_times[$i][$j]) . "<br>";
			
			// Set race_time to be asap (i.e. now + downtime)
			$race_time[0] += $time_between_races[0]; //H
			$race_time[1] += $time_between_races[1]; //M
			$race_time[2] += $time_between_races[2]; //S
		}
		
		$race_date[0]++; // Increment days by 1
	}
	
	mysql_close( );
?>
