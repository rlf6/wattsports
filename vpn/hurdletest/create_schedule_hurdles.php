<?php
	error_reporting(E_ALL); 
	ini_set('display_errors', 1); 

	include("../database.php");

	//=====================================================///
	// POST Data Received from hurdle schedule form ///

	$php_start = $_POST['start']; //event begins date - inclusive
	$php_end = $_POST['end'];	 //event ends date - inclusive
	
	if(isset($_POST['weekends']))
		$php_weekends = $_POST['weekends'];	// include weekends bool(Null or "on")
	else
		$php_weekends = 'off'; // if NULL set as default to "off" otherwise you get undefined index Notice
	
	$php_exclude = $_POST['exclude'];	// array of dates to exclude 
	$php_mins_between = $_POST['mins_between']; //mins between races
	$php_r_begins = $_POST['r_begins']; //races begin hours
	$php_r_begins_mins = $_POST['r_begins_mins']; //races begin mins
	$php_r_ends = $_POST['r_ends']; // races end hours
	$php_r_ends_mins = $_POST['r_ends_mins']; //races end mins
	
	if(!isset($_POST['track']))
		$php_track = $_POST['track']; //tracks selected array with location_id		
	else
		$php_track = array( 1 ); // TESTING ONLY
		// $php_track = array( );
	
	
	//$php_event_name = $result_array['name']; // name of the event
	$php_event_name = "Test Hurdlers (400m)";
	//$php_sex = $_POST['sex']); // gender this hurdle race is restricted to
	$php_sex = 'm';
	
	//die();
	//^^REMOVE DIE^^^^////////////////////////////////////////////////////////////
	
	// EXECUTIVE DECISION - EVENTS ARE NO LONGER CREATED SEPERATELY FROM RACES
	// AND THUS MUST BE CREATED HERE
	//$event_id = $_POST['event_id'];
	$event_id = 1; // TESTING ONLY
	/*$query = "SELECT * FROM event WHERE event_id='$event_id'";
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

	$result_array = mysql_fetch_array( $result );*/
	
	// ========== Work out the start date for the desired event =========	
	$date_start_php = strtotime( $php_start );
	$date_start_mysql = date( 'Y-m-d H:i:s', $date_start_php );
	$date_end_php = strtotime( $php_end );
	$date_end_mysql = date( 'Y-m-d H:i:s', $date_end_php );

	// Count the number of registered participants
	$sex = $php_sex;
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
	$opening_time = array( $php_r_begins, $php_r_begins_mins, 0 );
	$closing_time = array( $php_r_ends, $php_r_ends_mins, 0 );
	$time_between_races = array( 0, $php_mins_between, 0 );
	
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
			echo " at " . date("g:i a", $race_times[$i][$j]) . "<br>";
			
			// Set race_time to be asap (i.e. now + downtime)
			$race_time[0] += $time_between_races[0]; //H
			$race_time[1] += $time_between_races[1]; //M
			$race_time[2] += $time_between_races[2]; //S
		}
		
		$race_date[0]++; // Increment days by 1
	}
	
	// CREATE QUERIES FOR INSERTING THE RACES
	$location_id = $php_track[0]; // TESTING ONLY - get only the first track
	$umpire_id = 1;
	
	for( $day = 1; $day <= count( $race_times ); $day++ )
	{	
		for( $race = 1; $race <= count( $race_times[$day] ); $race++ )
		{	
			$race_time = date("H:i:s", $race_times[$day][$race] );
			$race_date = date("Y-m-d", $race_times[$day][$race] );
		
			echo "<p> \$query = ";
		
			$query = "INSERT INTO race(race_name, location_id, time, date, event_event_id, umpire, day)";
			$query = $query." VALUES('TEST', $location_id, '$race_time', '$race_date', $event_id, $umpire_id, $day)";
		
			echo $query."<br>";
		}
	}
	
	/*
	// INSERT
	if( !mysql_query( $query ) )
		die( 'ERROR: ' . mysql_error( ) );
		
	echo "Race added!";*/
	
	mysql_close( );
?>