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
}
$x=0;
for($i=0; $i < $m/2; $i++)
{
	$part2[$i]=$players[$x];
	$x++;
}
$x=($round-1)*($m/2)

for($p; $p < ($m/2); $p++)
{
	games[$x][0]=part1[$p];
	games[$x][1]=part2[$p];
	$x++;
}
$round++
//loop round 2 to number of rounds
for($round; $round <= $rounds; $round++)
{
	//round robin algorithm
	$temp1 = $part1[1];
	for($j = 2; $j < (m/2); $j++)
	{
		$temp2 = $part1[$j];
		$part1[$j] = $temp1;
		$temp1 = $temp2;
	}
	for($j; $j>=0; $j--)
	{
		$temp2 = $part2[$j];
		$part2[$j] = $temp1;
		$temp1 = $temp2;
	}
	$part1[1]=$temp1;
	$x = ($round-1)*($m/2)	
	if (($num_teams % 2) == 0)
	{ $p = 0;}
	else
	{ $p = 1;}
	for($p; $p < ($m/2)
	{
		games[$x][0]=part1[$p];
		games[$x][1]=part2[$p];
		$x++;
	}
	$round++;
}

//=============calculate available slots====================
//calculate days
//our version of php possibly too old for this function
public function getNumberOfDays($startDate, $endDate, $exclude)
{
    // d/m/Y
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $oneday = new DateInterval("P1D");
	$x= 0;
	
    $days = array();

    /*Iterate from $start up to $end+1 day, one day in each iteration.
    We add one day to the $end date, because the DatePeriod only iterates up to,
    not including, the end date.*/
    foreach(new DatePeriod($start, $oneday, $end->add($oneday)) as $day) {
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

    return $days;       
}

if (!($_POST['weekends']))
{
	$exclude=true;
}
else
{	$exclude=false;	}

$daysArray = getNumberOfDays($date_start_php, $date_end_php, $exclude);
/* back-up incase we do not have new enough version of php to run above function
$days = floor(abs($date_end_php - $date_start_php) / 86400); //floor gives num full days

if (!($_POST['weekends']))
{
	$exclude=true;
}
else
{	$exclude=false;	}*/
//==============Matches per day
//number of hours in a match day
$hour= $_POST['begin_h'];
$min= $_POST['behin_m'];
$date= $hour . ":" . $min;
$start_time = date ('H:i',strtotime($date));

$hour= $_POST['end_h'];
$min= $_POST['end_m'];
$date= $hour . ":" . $min;
$end_time = date ('H:i',strtotime($date));

//$time = $end_time - $start_time; //returns time in seconds
$time = ($end_time - $start_time)/60; //returns time in minutes
$halfday = date("H:i", strtotime('+'. $time/2 .' minutes', $start_time));
$duration = $_POST['duration'];
$gap =  $_POST['gap'];
$matchtime = $duration + $gap; //time needed per match (in minutes)
$pitches = 4;//test value
/*
============here need to figure out how many pitches were selected on previous page
*/
//how many matches may be played per day?
$matches = (($time/2)/$matchtime)*$pitches*2;

//available slots
$available = $matches*count($daysArray);

if($available < $slots) //slots variable is the minimum number we need to play all games in round robin tournament
{
	echo "You do not have enough slots to play all matches in a round-robin tournament, you may need to add dates or pitches";
	//==============here need to add option to cancel schedule creation or alter input
}

//=============producing scheduling details===============================
$played = array();
//initialise an array representing whether each team has played this half day
$played[$0] = true;
for ($x = 1; $x < $num_teams; $x++)
{
	$played[$x] = false; //set to false
}
$newDay = true;
$newAfternoon = false;
$match_date = $date_start_php;

for($i=0; $i< $slots; $i++)
{
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
			$match_start = date("H:i", strtotime('+'. $gap .' minutes', $previous_end));
		}
		
		$match_end = date("H:i", strtotime('+'. $duration .' minutes', $match_start));
		//if match starts in morning but ends in afternoon
		//new afternoon
		if(($match_start < $halfday) && ($match_end > $halfday))
		{
			$newAfternoon = true;
			for ($x = 1; $x < $num_teams; $x++)
			{
				$played[$x] = false; //set to false
			}			
		}		
		//if match ends after day
		//new day		//match_date next day
		elseif($match_end > $end_time)
		{
			$newDay = true;
			for ($x = 1; $x < $num_teams; $x++)
			{
				$played[$x] = false; //set to false
			}
			$prev = $match_date;
			$match_date = strtotime("+1 day",strtotime($prev))
		}
		else
		{
			$found = true; //exit while loop
		}
	}
}

?>
