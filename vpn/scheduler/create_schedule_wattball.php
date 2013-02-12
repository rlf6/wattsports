<?php
$active1 ='';
$active2 ='active';
$active3 ='';
$active4 ='';
$active5 ='';
$active6 ='';
$Title="Schedule Details";
include("../header.php");

echo "<div class='center_div'><div class='scroll_h'>";
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
$query = "SELECT * FROM wattball_team ORDER BY assoc_id ASC"; //extend to teams registered for *specific* events later
$result = mysql_query($query);
$team = 1;
while($row = mysql_fetch_assoc($result) )
{
	$teams[$team] = $row['assoc_id'];
	$tname[$team] = $row['team_name'];
	$team++;
}
$query = "SELECT * FROM wattball_team";//add WHERE event_id = $event_id when extended functionality
$result = mysql_query($query);
$num_teams = mysql_num_rows( $result );

if (($num_teams % 2)==0) //for an even number of teams
{
	$m = $num_teams;
	$rounds = $m - 1;
	$x = 1;	
	$slots = (($num_teams-1)/2)*$rounds;
	$p = 0; //variable for looping when pairing in round robin
}
else //for an odd number of teams
{	
	$m = $num_teams + 1;
	$rounds = $num_teams;
	$x = 0; //0 becomes a dummy value and we will not count any games it is paired in
	$slots = ($num_teams-1/2)*$rounds;
	$p = 1; //justification -- we want to ignore the first pairing when we have dummy team 0
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
/*	putting half of the players in 1 array and the other half in a second array we can easily achieve the round robin format
	e.g
	1234
	5678	
*/
for($i=0; $i < $m/2; $i++) 
{
	$part1[$i]=$players[$x];
	$x++;
}
for($i=0; $i < $m/2; $i++)
{
	$part2[$i]=$players[$x];
	$x++;
}
$x=0;

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
	//Round-Robin algorithm
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
	$x = count($games);
	
	if (($num_teams % 2) == 0)
	{ $p = 0;}
	else
	{ $p = 1;}
	
	for($p; $p < ($m/2); $p++)
	{
		$games[$x][0]=$part1[$p];
		$games[$x][1]=$part2[$p];
		$x++;
	}
}

//=============calculate available slots====================
//calculate days
$selected = (string)$_POST['weekend'];
if ($selected == 'N')
{	$exclude=true;	}
else
{	$exclude=false;	}

$daysArray= array();

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
			if($day_num < 6) //weekday
			{ 
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
$hour= $_POST['begin_h']; $min= $_POST['begin_m'];
$time= $hour . ":" . $min;
$start_time = date ('H:i',strtotime($time));

$hour= $_POST['end_h']; $min= $_POST['end_m'];
$time= $hour . ":" . $min;
$end_time = date ('H:i',strtotime($time));

$time = ($end_time - $start_time); //returns time in minutes
$half = $time/2;
$halfday = date("H:i:s", strtotime($start_time)+($half*60*60));
$duration = $_POST['duration'];
$gap =  $_POST['gap'];
$matchtime = $duration + $gap; //time needed per match (in minutes)

$pitches = array();
$query = "SELECT location_id, location_name FROM location WHERE type='pitch' ORDER BY location_id ASC";
$result = mysql_query($query);
$pitch = 0;
while($row = mysql_fetch_assoc($result))
{
	if(isset($_POST['check_list'][$row['location_id']]))
	{
		$pitches[$pitch] = $row['location_id'];
		$pname[$pitch] = $row['location_name'];
		$pitch++;
	}
}

//how many matches may be played per day?
$matches = floor((($time/2)*60)/$matchtime)*count($pitches)*2;
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
$played[0] = true; //0 is a dummy value and as such should always appear as 'played'
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
for($x=0; $x<count($games); $x++)
{
	$gPlayed[$x] = false;
}

$i=0;
while($i <= count($games) && $today < count($daysArray)-1)
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
		}
		$match_end = date("H:i:s", strtotime($match_start)+($duration*60));
		
		//if match starts in morning but ends in afternoon
		if(($match_start < $halfday) && ($match_end > $halfday))
		{
			$newAfternoon = true;
			for ($x = 1; $x <= $num_teams; $x++)
			{
				$played[$x] = false; //none of the teams have now played this half-day
			}			
		}	
		elseif($match_end > $end_time)//if match ends after day end
		{
			$newDay = true;
			for ($x = 1; $x <= $num_teams; $x++)
			{
				$played[$x] = false; 
			}
			$today += 1;
			$match_date = $daysArray[$today];
		}
		else
		{
			$previous_end = $match_end;
			
			//we may use these start/end times for as many matches as there are pitches
			$gameCount = 0;
			for($x=0; $x < count($pitches); $x++)
			{
				if($gameCount == -1)
				{
					break;
				}
				$pair = false;
				$gameCount = 0;
				//loop for all games to find pair where neither have played this half day, for as many games as pitches			
				while($pair == false && $gameCount < count($games))
				{
					$t1 = $games[$gameCount][0];
					$t2 = $games[$gameCount][1];
					
					if ($played[$t1] == false && $played[$t2] == false && $gPlayed[$gameCount] == false)
					{
						$i++;
						$pair = true;
						$played[$t1] = true;
						$played[$t2] = true;
						$gPlayed[$gameCount] = true;
						$location = $pitches[$x];

						echo 'date: '.$match_date . "<br>";
						echo 'start time: '.$match_start . "<br>";
						echo 'location: '.$pname[$x] . "<br>";						
						$team1 = $teams[$t1] . ": " . $tname[$t1];
						echo 'teamA: '.$team1 . "<br>";
						$team2 = $teams[$t2] . ": " . $tname[$t2];
						echo 'teamB: '.$team2 . "<br>";
						//=========referee needed!
						
						//Insert values to database						
						$sql = "INSERT INTO `wattspor_database`.`match`(`match_id`, `location_id`, `kick_off`, `date`, `photo_path`,`event_event_id`, `team_A`, `team_B`, `referee`)
						VALUES
						('','$location', '$match_start', '$match_date', '', '$event_id', '$team1', '$team2', '1')";
						echo $sql."<br>";
						if (!mysql_query($sql))
						{
							die('<br>Error: '. mysql_error());
						}
						echo "match: ".$tname[$t1] ." vs ". $tname[$t2] ." added.<br><br>";
					}
					else
					{
						if($gameCount < count($games)-1)
						{
							$gameCount += 1;
						}
						else
						{
							$gameCount = -1;
							break;
						}
					}
				}
				//$i++;
			}
			$found = true; //exit while loop
		}
	}
}
echo "</div></div>";
?>

