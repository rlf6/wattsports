<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include("../database.php");

$active1 ='';
$active2 ='active';
$active3 ='';
$active4 ='';
 $Title = "Wattsports";
$mobile ='';
include('./header.php');
?>

<div class="center_div" border="2px solid">
				
	<h1>Create the schedule for a hurdle event</h1>
        <form  method="POST" action="./create_schedule_hurdles.php">
	 	Event: <select name="event_id">
	 	<?php
	 	mysql_connect('localhost','wattspor','wattball10');
	 	mysql_select_db('wattspor_database');
		$query = "SELECT event_id, name FROM event WHERE event_type='hurdles400' ORDER BY event_id ASC";
		$result = mysql_query($query);
		echo $query;

		while( list($event_id, $event_name) = mysql_fetch_row($result) )
		{
	 		echo '<option value="'.$event_id.'">'.$event_name.'</option>';
	 	}
	 	?>
	 	</select>
		<input type="submit" title="submit" />
  	</form>
	<br>
	
</div>


</html>

