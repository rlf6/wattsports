<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
include("../database.php");

$num_lanes = 8;

// ============================= SECOND DAY ================================

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
	
	// Add hurdlers to races in breadth first fashion
	$race_array = array( );
	
	// Initialise the array
	for( $i = 1; $i <= $num_races_today; $i++ )
	{
		$race_array[$i] = array( );
	}
	
	$i = 1;
	while( $row = mysql_fetch_array( $result ) )
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
	
	// SHUFFLE THE LANES
	// we've put all the hurdlers in races, so now we shuffle the lanes within those races
	// this is much simpler than adding the hurdlers to the array in a random order
	for( $i = 1; $i <= $num_races_today; $i++ )
	{
		shuffle( $race_array[$i] );
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