<?php
$active1 ='';
$active2 ='active';
$active3 ='';
$active4 ='';
$active5 ='';
$active6 ='';
$Title="Scheduler";
include("./header.php");
include("./database.php");

?>

<div class="center_div">
	<div class="scroll_h">
	   <form  method="POST" action="/scheduler/create_schedule_wattball.php">
	 	<fieldset>Event: <select name="event_id" style="width: 150px">
	 	<?php
	 	mysql_connect('localhost','wattspor','wattball10');
	 	mysql_select_db('wattspor_database');
		$query = "SELECT event_id, name FROM event WHERE event_type='wattball' ORDER BY event_id ASC";
		$result = mysql_query($query);
		echo $query;

		while( list($event_id, $event_name) = mysql_fetch_row($result) )
		{
	 		echo '<option value="'.$event_id.'">'.$event_name.'</option>';
	 	}
	 	?>
	 	</select>
		</fieldset>
		<fieldset>
		<h3> Options </h3>
		Tournament day begins (24h): 
			<select name="begin_h">
				<option>9</option> <option>10</option> <option>11</option> <option>12</option> <option>13</option> <option>14</option>
				<option>15</option> <option>16</option> <option>17</option> <option>18</option> <option>19</option> 
			</select>h  
			<select name="begin_m">
				<option> 00 </option> <option> 15 </option> <option> 30 </option> <option> 45 </option>
			</select>
			<br>
		Tournament day ends:
			<select name="end_h">
				<option>9</option> <option>10</option> <option>11</option> <option>12</option> <option>13</option> <option>14</option>
				<option>15</option> <option>16</option> <option>17</option> <option>18</option> <option>19</option> 
			</select>h 
			<select name="end_m">
				<option> 00 </option> <option> 15 </option> <option> 30 </option> <option> 45 </option>
			</select>
		<br>
		Match duration:
			<select name="duration">
				<option> 30 </option> <option> 45 </option> 
				<option> 60 </option> <option> 75 </option> <option> 90 </option>
			</select>minutes
		<br>
		Min gap between matches:
		<select name="gap">
			<option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option>
		</select>
		<br>
		Include weekends?:
		<input type="radio" name="weekend" value="Y" checked>Yes</input>  
		<input type="radio" name="weekend" value="N">No</input>
		</fieldset>
		<fieldset>
		<h3>Pitches</h3>
		
		<?php
		//allows user to select from locations in database- of type pitch- which they would like to include in the tournament
			$query = "SELECT location_id, location_name FROM location WHERE type='pitch' ORDER BY location_id ASC";
			$result = mysql_query($query);

			while($row = mysql_fetch_assoc($result) )
			{
				echo "location: ";//.$row['location'];
				echo '<input type="checkbox" name="check_list['.$row['location_id'].']" value="'.$row['location_id'].'" checked=true> '.$row['location_name'].'</input><br />';
			}
		?>
		</fieldset>
	
		<input type="submit" title="submit" />
	</form>
</div>
</div>
</html>

<script>

</script>