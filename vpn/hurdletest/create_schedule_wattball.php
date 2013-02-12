<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
include("../database.php");


// ========== Work out the start date for the desired event =========
$event_id = $_POST['event_id'];
$query = "SELECT * FROM event WHERE event_id='$event_id'";
$result_array = mysql_fetch_array( mysql_query( $query ) );

$event_name = $result_array['name']; 
$date_start_php = strtotime( $result_array['start_date'] );
$date_start_mysql = date( 'Y-m-d H:i:s', $date_start_php );
$date_end_php = strtotime( $result_array['end_date'] );
$date_end_mysql = date( 'Y-m-d H:i:s', $date_end_php );

// ============= Prep ================
$query = "SELECT * FROM wattball_team";
$result = mysql_query($query);
$num_teams = mysql_num_rows( $result );

if (($num_teams % 2)==0) //for an even number of teams
{
	$m = $num_teams;
	$rounds = $m - 1;
	//$games = 2d array ---skipping for now as php flexible enough to add to array without defining length
	$x = 1;	
	$slots = (($num_teams-1)/2)*$rounds;
	$p = 0; //variable for looping when pairing in round robin
}
else //for an odd number of teams
{
	$m = $num_teams + 1;
	$rounds = $num_teams;
	$x = 0; //0 becomes a dummy value and we will not count any games it is paired in
	$slots = ($num_teams/2)*$rounds;
	$p = 1; //justification -- we want to ignore the first pairing if we have dummy team 0
}
$y=0;
for($x; $x<=$num_teams; $x++)
{
	$players[$y]=$x;
	$y++;
}

// =============Pairing Algorithm ===============
$round = 1;
$x=0;
for($i=0; $i < $m/2; $i++)
{
	$part1[$i]=$players[$x];
	$x++;
	//echo $part1[$i];
}
//echo "<br>";
for($i=0; $i < $m/2; $i++)
{
	$part2[$i]=$players[$x];
	$x++;
	//echo $part2[$i];
}
$x=($round-1)*($m/2);

for($p; $p < ($m/2); $p++)
{
	$games[$x][0]=$part1[$p];
	$games[$x][1]=$part2[$p];
	$x++;
}
$round++;
//loop round 2 to number of rounds
for($round; $round <= $rounds; $round++)
{	
	//echo "Round: ". $round . "of " . $rounds . "<br>";
	//round robin algorithm
	$temp1 = $part1[1];
	for($j = 2; $j < ($m/2); $j++)
	{
		$temp2 = $part1[$j];
		$part1[$j] = $temp1;
		$temp1 = $temp2;
	}
	for($j=($m/2)-1; $j>=0; $j--)
	{
		$temp2 = $part2[$j];
		$part2[$j] = $temp1;
		$temp1 = $temp2;
	}
	$part1[1]=$temp1;
	$x = ($round-1)*($m/2)/2;
	
	if (($num_teams % 2) == 0)
	{ $p = 0;}
	else
	{ $p = 1;}
	
	for($p; $p < ($m/2); $p++)
	{
		$games[$x][0]=$part1[$p];
		$games[$x][1]=$part2[$p];
		//echo "Game ". $x . ": ". $games[$x][0] . " vs " . $games[$x][1] . "<br>";
		$x++;
	}
}

//=============calculate available slots====================
//calculate days
//our version of php possibly too old for this function

if (!($_POST['weekends']))
{
	$exclude=true;
}
else
{	$exclude=false;	}

		$daysArray= array();
    // d/m/Y
    try 
	{
		$start = new DateTime($date_start_mysql);
		$end = new DateTime($date_end_mysql);
		
		$oneday = new DateInterval("P1D");
		$x= 0;
		
		$days = array();

		/*Iterate from $start up to $end+1 day, one day in each iteration.
		We add one day to the $end date, because the DatePeriod only iterates up to,
		not including, the end date.*/
		foreach(new DatePeriod($start, $oneday, $end->add($oneday)) as $day) 
		{
			$day_num = $day->format("N"); //'N' number days 1 (mon) to 7 (sun) 
			if($exclude)
			{
				if($day_num < 6) { //weekday
					$days[$x] = $day->format("Y-m-d");
					$x++;
				} 
			}
			else
			{
					$days[$x] = $day->format("Y-m-d");
					$x++;
			}
		}
		$daysArray= $days;   
	}
	catch(Exception $e)
	{
		echo "TRY failed<br>";
		echo $e->getMessage() . "<br>";
	}

//==============Matches per day
//number of hours in a match day
$hour= $_POST['begin_h'];
$min= $_POST['begin_m'];
$time= $hour . ":" . $min;
$start_time = date ('H:i',strtotime($time));

$hour= $_POST['end_h'];
$min= $_POST['end_m'];
$time= $hour . ":" . $min;
$end_time = date ('H:i',strtotime($time));

//$time = $end_time - $start_time; //returns time in seconds
$time = ($end_time - $start_time); //returns time in minutes
$half = $time/2;
//$halfday = strtotime("+". $half ." minutes'", $start_time);
$halfday = date("H:i:s", strtotime($start_time)+($half*60*60));
$duration = $_POST['duration'];
$gap =  $_POST['gap'];
$matchtime = $duration + $gap; //time needed per match (in minutes)
$pitches = 1;//test value
/*
============here need to figure out how many pitches were selected on previous page
*/
//how many matches may be played per day?
$matches = floor((($time/2)*60)/$matchtime)*$pitches*2;
//available slots
$available = $matches*count($daysArray);

if($available < $slots) //slots variable is the minimum number we need to play all games in round robin tournament
{
	echo "Available: " . $available . " Slots: " . $slots . "<br>";
	echo "You do not have enough slots to play all matches in a round-robin tournament, you may need to add dates or pitches<br>";
	//==============here need to add option to cancel schedule creation or alter input
}

//=============producing scheduling details===============================
$played = array();
//initialise an array representing whether each team has played this half day
$played[0] = true;
for ($x = 1; $x <= $num_teams; $x++)
{
	$played[$x] = false; //set to false
}
$newDay = true;
$newAfternoon = false;
$today=0;
$match_date = $daysArray[$today];

//array to ensure a game isn't played more than once
$gPlayed = array();
for($x=0; $x<=count($games); $x++)
{
	$gPlayed[$x] = false;
}

for($i=0; $i<= count($games); $i++)
{
	$found = false;
	//set start and end times
	while($found == false)//loop until valid times found
	{
		if($newDay == true)
		{
			$match_start = $start_time;
			$newDay = false;
		}
		elseif ($newAfternoon == true)
		{
			$match_start = $halfday;
			$newAfternoon = false;
		}
		else
		{
			$match_start = date("H:i:s", strtotime($previous_end)+($gap*60));
			//$match_start = date("H:i", strtotime('+'. $gap .' minutes', $previous_end));
		}
		
		$match_end = date("H:i:s", strtotime($match_start)+($duration*60));
		//if match starts in morning but ends in afternoon
		if(($match_start < $halfday) && ($match_end > $halfday))
		{
			$newAfternoon = true;
			for ($x = 1; $x <= $num_teams; $x++)
			{
				$played[$x] = false; //set to false
			}			
		}		
		//if match ends after day end
		elseif($match_end > $end_time)
		{
			$newDay = true;
			for ($x = 1; $x <= $num_teams; $x++)
			{
				$played[$x] = false; //set to false
			}
			
			$today += 1;
			$match_date = $daysArray[$today];
		}
		else
		{
			$previous_end = $match_end;
			//loop for all games to find pair where neither have played this half day, for as many games as pitches
			//we may use these start/end times for as many matches as there are pitches
			for($x=1; $x <= $pitches; $x++)
			{
				$pair = false;
				$gameCount = 0;
				//======put into nextPair function??
				
				while($pair == false && $gameCount < count($games))
				{
					$t1 = $games[$gameCount][0];
					$t2 = $games[$gameCount][1];
					print_r($played);
					if ($played[$t1] == false && $played[$t2] == false && $gPlayed[$gameCount] == false)
					{
						$pair = true;
						$played[$t1] = true;
						$played[$t2] = true;
						$gPlayed[$gameCount] = true;
					}
					else
					{
						if($gameCount < count($games)-1)
						{
							$gameCount += 1;
						}
						else
						{
							break;
						}
					}
				}
			
				//vvv-----will require re-think-----vvvvvv
				$location = "pitch".$x; //this requires a naming convention of pitchX pitchY ...etc
				echo 'Game: ' . $gameCount . "<br>";
				echo 'date: '.$match_date . "<br>";
				echo 'start time: '.$match_start . "<br>";
				echo 'location: '.$location . "<br>";
				$team1 = $t1;//games[$i][0];
				//==============need to match up number of team to row number in database
				echo 'teamA: '.$team1 . "<br>";
				$team2 = $t2;//$games[$i][1];
				echo 'teamB: '.$team2 . "<br>";
				//=========referee needed!
				
				/* //Insert values to database
				if ($played[$team1]==false && $played[$team2]==false)
				{
					$sql = "INSERT INTO match (location_id, kick_off, date, team_A, team_B)
					VALUES
					('$location', '$match_start', '$match_date', '$team1', '$team2')";
					if (!mysql_query($sql))
					{
						die('Error: '. mysql_error());
					}
					//
					echo "match: ".$team1 ." vs ". $team2 ." added.";
				}
				*/
				$i++;
			}
			$found = true; //exit while loop
		}
	}

}

?>
