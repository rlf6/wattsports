<?php
	// IN - The number of hurdlers registered for this event, the number of those with no previous best on record
	// OUT - an array of the number of races needed for each day
	function num_days( $num_hurdlers, $hurdlers_no_best )
	{
		global $num_lanes;
		
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
		if( $hurdlers_no_best > 0 )
		{
			echo "Information: " . $hurdlers_no_best . " hurdler(s) with no previous best time on record.<br>
					The initial day will be required.<p>";
					
			$num_days++;
			
			// work out how many races need to be run
			$days[$num_days] = ceil( $hurdlers_no_best / $num_lanes ); // round up because we can't have half a race
		}

		// Loop through days until everyone fits on the same track
		// which indicates that this is the final race	
		$num_hurdlers_today = $num_hurdlers;
		$i = 0;
		while( $num_hurdlers_today >= $num_lanes && ($i < 10) ) // TESTING ONLY - hard limit of 10 days
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
			
		return $days;
	}

	// IN: Array of predefined races, Array of hurdlers (by ID) to be 'lane-d'
	// OUT: Array of races with hurdlers in lanes
	function allocate_lanes_basic( $race_array, $hurdlers )
	{
		global $num_lanes;
		
		// Add hurdlers to races in breadth first fashion	
		$race = 1;
		for( $i = 1; $i <= count( $hurdlers ); $i++ )
		{		
			// GET RACE $race
			$race_copy = $race_array[$race];
			
			// ADD THIS RUNNER TO FIRST AVAILABLE LANE
			for( $j = 1; $j <= $num_lanes; $j++ )
			{
				if( !isset( $race_copy[$j] ) ) // is this lane available?
				{
				//	echo "Added hurdler '" . $hurdlers[$i] . "' to lane " . $j . " of race " . $race . "<br>";
					$race_array[$race][$j] = $hurdlers[$i]; // $race_copy does not exist outside of this loop, stupid. $race_array does.
					break;
				}
			}
			
			// Error handling
			if( $j > $num_lanes )
			{
			//	echo "Error: Out of lanes to put hurdlers in; Not yet out of hurdlers to put in lanes.";
				exit;
			}
			
			// CHOOSE NEXT RACE
			// Wrap around to first race
			if( $race >= count($race_array) )
				$race = 0; 
				
			// Get next race
			$race++;
		}

		// return the array of races and hurdlers
		return $race_array;
	}

	function shuffle_assoc($array)
	{
		// Initialize
		$shuffled_array = array();

		// Get array's keys and shuffle them.
		$shuffled_keys = array_keys($array);
		shuffle($shuffled_keys);

		// Create same array, but in shuffled order.
		foreach ( $shuffled_keys AS $shuffled_key )
			$shuffled_array[  $shuffled_key  ] = $array[  $shuffled_key  ];

		// Return
		return $shuffled_array;
	}

	// IN: An array of hurdlers to allocate to lanes, and "day" (style of allocation: random, non-random, etc.)
	// OUT: Array of races with hurdlers in *correct* lanes
	function allocate_lanes( $hurdlers, $day )
	{
		global $num_lanes;
		
		// Check $day is valid
		if( $day < 1 )
		{
			echo "Error: Tried to allocate lanes for an invalid day!";
			return;
		}

		// work out how many races need to be run
		$num_races_today = ceil( count( $hurdlers ) / $num_lanes ); // round up because we can't have half a race
		
		// Initialise the array
		$race_array = array( );
		for( $i = 1; $i <= $num_races_today; $i++ )
		{
			$race_array[$i] = array( );
		}
		
		// ALLOCATE HURDLERS TO RACES
		$race_array = allocate_lanes_basic( $race_array, $hurdlers );
		
		// Special cases for days greater than 1
		if( $day == 2 )
		{
			// SHUFFLE LANES - NOW WITH THE CORRECT KEYS
			// we've put all the hurdlers in races, so now we shuffle the lanes within those races
			// this is much simpler than adding the hurdlers to the array in a random order
			for( $i = 1; $i <= count( $race_array ); $i++ )
			{
				// Copy the lanes
				$race_copy = $race_array[$i];
				
				// Create an array of the keys and shuffle them
				$keys = array_keys( $race_array[$i] );
				shuffle( $keys );
				
				// Take the values and add them to the array in the new order
				for( $j = 0; $j < count( $keys ); $j++ )
					$race_array[$i][$j+1] = $race_copy[$keys[$j]];

				//shuffle( $race_array[$i] );
			}
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
				$negative = 1; // oh dear. well, at least it works
				for( $j = 1; $j < count( $race_array[$i] ); $j++ )
				{
					$lane = $center_lane + ( $negative * ceil($j / 2) );
					$new_race_array[$i][$lane] = $race_array[$i][$j+1]; // Urgh. Arrays are out of sync.
					
					//echo "Added hurdler '" . $race_array[$i][$j+1] . "' to lane " . $lane . " of race " . $i . "<br>";

					$negative *= -1;
				}
			}
			
			$race_array = $new_race_array;
		}
		
		// Return the lane-d races
		return $race_array;
	}
?>