<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
include("../database.php");

$num_lanes = 8;

// ============================= FIRST DAY ================================

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
	$num_races_today = $num_rows / $num_lanes;
	
	if( ( $num_races_today % $num_lanes ) > 0 )
		$num_races_today++;
	
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
		echo "Hurdler: " . $row['id'] . "<br>";
		
		// GET RACE $race
		$race = $race_array[$i];
		
		// ADD THIS RUNNER TO FIRST AVAILABLE LANE
		$j = 1;
		while( $j <= $num_lanes )
		{
			if( !isset( $race[$j] ) ) // is this lane available?
			{
				echo "Added hurdler to lane " . $j . "\n";
				$race[$j] = $row['id'];
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
		if( $i < $num_races_today )
			$i++; // Get next race
		else
			$i = 1; // Wrap around to first race
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