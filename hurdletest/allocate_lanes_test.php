<?php
	error_reporting(E_ALL); 
	ini_set('display_errors', 1); 
	
	include("../database.php");

	$num_lanes = 8; // This should be moved to a settings file somewhere	

	// IN: Array of predefined races, Array of hurdlers to be 'lane-d'
	// OUT: Array of races with hurdlers in lanes
	function allocate_lanes_basic( $race_array, $hurdlers )
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
			if( $i >= count($race_array) )
				$i = 0; 
				
			// Get next race
			$i++;
		}
		
		// return the array of races and hurdlers
		return $race_array;
	}

	// IN: A "day" to allocate
	// OUT: Array of races with hurdlers in *correct* lanes
	function allocate_lanes( $day )
	{
		// Check $day is valid
		if( $day < 1 )
		{
			echo "Error: Tried to allocate lanes for an invalid day!";
			return;
		}
		
		$race_array = array( );
		
		// Build the query
		$query = "";
		if( $day == 1 )
			$query = "SELECT * FROM hurdler WHERE previous_best IS NULL";	
		else if( $day == 2 )
			$query = "SELECT * FROM hurdler ORDER BY previous_best ASC";
		else if( $day >= 3 )
		{
			// number of competitors today is
			// ((number of competitors on previous day / 2 ) rounded up to nearest multiple of number of lanes)
			$query = "SELECT * FROM hurdler ORDER BY previous_best ASC"; // <------------------------------THIS IS WRONG--------------------------
		}
		
		$result = mysql_query( $query );
		$num_rows = mysql_num_rows( $result );
		if( mysql_num_rows( $result ) < 1 )
		{
			echo "Error: Tried to allocate lanes on day '" . $day . "', but no hurdlers to schedule!";
			return;
		}
		
		// work out how many races need to be run
		$num_races_today = ceil( $num_rows / $num_lanes ); // round up because we can't have half a race
		
		// Initialise the array
		for( $i = 1; $i <= $num_races_today; $i++ )
		{
			$race_array[$i] = array( );
		}
		
		// ALLOCATE LANES
		$race_array = schedule_day( $race_array, $result );
		
		if( $day == 2 )
		{
			// SHUFFLE LANES
			// we've put all the hurdlers in races, so now we shuffle the lanes within those races
			// this is much simpler than adding the hurdlers to the array in a random order
			for( $i = 1; $i <= count( $race_array ); $i++ )
				shuffle( $race_array[$i] );
		}
		else if( $day >= 3 )
		{
			// NON-RANDOM LANE ALLOCATION
			// Query returned hurdlers in desc. order of speed
			// So fastest should be at the top
			$center_lane = ceil( $num_lanes / 2 );
			
			// Create a new array, same dimensions as $race_array
			$new_race_array = array( );
			for( $i = 1; $i <= count( $race_array ); $i++ )
				$new_race_array[$i] = array( );
			
			// Now put the hurdlers into the new array in the *right* lanes
			for( $i = 1; $i <= count( $race_array ); $i++ )
			{
				// Put the fastest hurdler in the center
				$new_race_array[$i][$center_lane] = $race_array[$i][1];
				echo "Added hurdler '" . $race_array[$i][1] . "' to lane " . $center_lane . " of race " . $i . "<br>";
				
				// Put the next fastest hurdler in Center + (i / 2) rounded up
				// And the one after that in Center - (i+1 / 2) rounded up
				$negative = 1;
				for( $j = 1; $j < count( $race_array[$i] ); $j++ ) // oh dear.
				{
					$lane = $center_lane + ( $negative * ceil($j / 2) );
					$new_race_array[$i][$lane] = $race_array[$i][$j+1]; // Urgh. Arrays are out of sync.
					
					echo "Added hurdler '" . $race_array[$i][$j+1] . "' to lane " . $lane . " of race " . $i . "<br>";

					$negative *= -1;
				}
			}
			
			$race_array = $new_race_array;
		}
		
		// Return the lane-d races
		return $race_array;
	}
	
	//==================================MAIN ALGORITHM==================================
	$race_array = allocate_lanes( 1 );
	
	// PRINT OUTPUT
	echo "<br><br><br>";
	for( $i = 1; $i <= count( $race_array ); $i++ ) // had problems with foreach
	{
		echo "RACE**********************<br>";
		
		for( $j = 1; $j <= count( $race_array[$i] ); $j++ )
		{
			echo "Hurdler ID: " . $race_array[$i][$j] . "<br>";
		}
		
		echo "<br>";
	}
	
	mysql_close( );
?>