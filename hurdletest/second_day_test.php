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
		echo "Error: No hurdlers to schedule";
		exit;
	}
	
	// work out how many races need to be run
	// lane distribution: random
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
		
		// Count the number of free lanes
		$j = 0;
		$free = 0;
		while( $j < $num_lanes )
		{
			if( $race['$j'] == NULL )
				$free++;
				
			$j++;
		}
		
		// Check there are free lanes in this race
		if( $free < 1 )
		{
			echo "Error: No free lanes in race " . $i . ".";
			return;
		}
				
		// ADD THIS RUNNER TO RANDOM LANE (unless it's full)
		$j = rand(1, $num_lanes);
		$tried = 0;
		while( $tried <= 100 ) // don't try forever
		{
			if( $race['$j'] == NULL ) // is this lane available?
			{
				$race['$j'] = $row['id'];
				break;
			}
			
			$j = rand(1, $num_lanes); // try the next lane
			$tried++;
		}
		
		// Error handling
		if( $tried = 100 )
		{
			echo "Error: Tried one hundred times to find the free lane in race " . $i . ".";
			return;
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
	
	mysql_close( );
?>