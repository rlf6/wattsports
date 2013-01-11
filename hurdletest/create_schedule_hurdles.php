<?php
// ============================= FIRST DAY ================================
function schedule_first_day( )
{
	// Work out if the initial day is required
	$query = "SELECT * FROM hurdler WHERE previous_best IS NULL";
	$result = mysql_query( $query );
	$num_rows = mysql_num_rows( $result );
	if( mysql_num_rows( $result ) < 1 )
	{
		echo "Error: Tried to schedule first day, but all runners have a previous best.";
		exit;
	}
	
	// work out how many races need to be run
	// lane distribution not specified
	// so do it the same way as following days
	$num_races_today = $num_rows / $num_lanes
	
	if( ( $num_races_today % $num_lanes ) > 0 )
		$num_races_today++;
	
	// Add hurdlers to races in breadth first fashion
	$race_array = array( );
	$i = 1;
	while( $row = mysql_fetch_array( $results ) )
	{
		// GET RACE $race
		$race = $race_array['$i'];
		
		// ADD THIS RUNNER TO FIRST AVAILABLE LANE
		$j = 1;
		while( $j <= $num_lanes )
		{
			if( $race['$j'] == NULL ) // is this lane available?
			{
				$race['$j'] = $row['id'];
				break;
			}
			
			$j++; // try the next lane
		}
		
		// Error handling
		if( $j > $num_lanes )
		{
			echo "Error: Out of lanes to put hurdlers in; Not yet out of hurdlers to put in lanes.";
			exit;
		}
		
		// CHOOSE NEXT RACE
		// Wrap around to first race
		if( $i == $num_races_today )
			$i = 0;
			
		// Get next race
		$i++;
	}
	
	// PRINT OUTPUT
	echo "\n\n\n";
	foreach ($race_array as $race)
	{
		echo "RACE**********************\n";
		
		foreach ($race as $lane)
		{
			echo "Hurdler ID: " . $lane . "\n";
		}
		
		echo "\n";
	}
}

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

$query = "SELECT * FROM hurdler";
$result = mysql_query($query);
//$num_hurdlers = 50; // For testing purposes only
$num_hurdlers = mysql_num_rows( $result );

$num_lanes = 8; // MAKE THIS VARIABLE (probably not today though)

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

schedule_first_day( );

mysql_close( );
?>
