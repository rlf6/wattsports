<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
include("../database.php");

$num_lanes = 8;

// IN: Array of prescheduled races, Array of hurdlers to be 'lane-d'
// OUT: Array of races with hurdlers in lanes
function lane_day_initial( $race_array, $hurdlers )
{
	// Add hurdlers to races in breadth first fashion	
	$i = 1;
	while( $row = mysql_fetch_array( $hurdlers ) )
	{		
		// GET RACE $race
		$race = $race_array[$i];
		
		// ADD THIS RUNNER TO FIRST AVAILABLE LANE
		$j = 1;
		while( $j <= $num_lanes )
		{
			if( !isset( $race[$j] ) ) // is this lane available?
			{
				echo "Added hurdler '" . $row['id'] . "' to lane " . $j . " of race " . $i . "<br>";
				$race_array[$i][$j] = $row['id']; // $race does not exist outside of this loop, stupid. $race_array does.
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
		if( $i >= $num_races_today )
			$i = 0; 
			
		// Get next race
		$i++;
	}
	
	// return the array of races and hurdlers
	return $race_array;
}

function lane_day( $day )
{
	$race_array = array( );
	
	// ZERO-TH DAY
	if( $day == 1 )
	{
		$query = "SELECT * FROM hurdler WHERE previous_best IS NULL";
		$result = mysql_query( $query );
		$num_rows = mysql_num_rows( $result );
		if( mysql_num_rows( $result ) < 1 )
		{
			echo "Error: Tried to schedule first day, but all runners have a previous best.";
			exit;
		}
		
		// work out how many races need to be run
		$num_races_today = ceil( $num_rows / $num_lanes ); // round up because we can't have half a race		
		
		// Initialise the array
		for( $i = 1; $i <= $num_races_today; $i++ )
		{
			$race_array[$i] = array( );
		}
		
		$race_array = schedule_day( $race_array, $result );
	}
	// FIRST DAY
	else if( $day == 2 )
	{
		// order by ascending previous_best
		// so that the hurdlers are added in that order
		$query = "SELECT * FROM hurdler ORDER BY previous_best ASC";
		$result = mysql_query( $query );
		$num_rows = mysql_num_rows( $result );
		if( mysql_num_rows( $result ) < 1 )
		{
			echo "Error: No hurdlers to schedule.";
			exit;
		}
		
		// work out how many races need to be run
		// lane distribution: random
		$num_races_today = ceil( $num_rows / $num_lanes ); // round up because we can't have half a race
		
		// Initialise the array
		for( $i = 1; $i <= $num_races_today; $i++ )
		{
			$race_array[$i] = array( );
		}
		
		$race_array = schedule_day( $race_array, $result );
		
		// SHUFFLE THE LANES
		// we've put all the hurdlers in races, so now we shuffle the lanes within those races
		// this is much simpler than adding the hurdlers to the array in a random order
		for( $i = 1; $i <= $num_races_today; $i++ )
		{
			shuffle( $race_array[$i] );
		}
	}
	else if( $day >= 3 )
	{
		// number of competitors today is
		// ((number of competitors on previous day / 2 ) rounded up to nearest multiple of number of lanes)
		$query = "SELECT * FROM hurdler ORDER BY previous_best ASC"; // <-----------THIS IS WRONG--------------------------
		$result = mysql_query( $query );
		$num_rows = mysql_num_rows( $result );
		if( mysql_num_rows( $result ) < 1 )
		{
			echo "Error: No hurdlers to schedule.";
			exit;
		}
		
		// work out how many races need to be run
		// lane distribution: random
		$num_races_today = ceil( $num_rows / $num_lanes ); // round up because we can't have half a race
		
		// Initialise the array
		for( $i = 1; $i <= $num_races_today; $i++ )
		{
			$race_array[$i] = array( );
		}
		
		$race_array = schedule_day( $race_array, $result );
		
		// NON-RANDOM LANE RE-ALLOCATION
		// we've put the hurdlers in the races
		// now we just need to put them in the right place		
		$center_lane = ceil( $num_lanes / 2 );
		echo "Center Lane: " .$center_lane . "<br>";	
		
		// Create a new array, same dimensions as $race_array
		$new_race_array = array( );
		for( $i = 1; $i <= count( $race_array ); $i++ )
			$new_race_array[$i] = array( );
		
		// Hurdlers were added in order of descending speed
		// So fastest should be at the top
		for( $i = 1; $i <= count( $race_array ); $i++ )
		{
			// Put the fastest hurdler in the center
			$new_race_array[$i][$center_lane] = $race_array[$i][1];
			
			// Put the next fastest hurdler in Center + (i / 2) rounded up
			// And the one after that in Center - (i+1 / 2) rounded up
			for( $j = 2; $j <= count( $lanes ); $j++ )
			{
				$lane = $center_lane + ceil($j / 2);
				$new_race_array[$i][$lane] = $race_array[$i][$j];
				
				$j++;
				$lane = $center_lane - ceil($j / 2);
				$new_race_array[$i][$lane] = $race_array[$i][$j];
			}		
		}

		$race_array = $new_race_array;
	}
	
	// Return the lane-d races
	return $race_array;
}


	// PRINT OUTPUT
	echo "<br><br><br>";
	foreach ($race_array as $race)
	{
		echo "RACE**********************<br>";
		
		foreach ($race as $lane)
		{
			echo "Hurdler ID: " . $lane . "<br>";
		}
		
		echo "<br>";
	}
	
	mysql_close( );
?>