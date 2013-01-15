<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Schedule Event</title>
</head>

<body>

<h1>Create the schedule for a wattball event</h1>
	   <form  method="POST" action="./create_schedule_wattball.php">
	 	<fieldset>Event: <select name="event_id">
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
				<option> 15 </option> <option> 30 </option> <option> 45 </option> 
				<option> 60 </option> <option> 75 </option> <option> 90 </option>
			</select>minutes
		<br>
		Min gap between matches:
		<select name="gap">
			<option> 10 </option> <option> 20 </option> <option> 30 </option> <option> 40 </option>
		</select>
		<br>
		Include weekends?:
		<input type="radio" name="weekends" value="Y">Yes</input>  
		<input type="radio" name="weekends" value="N">No</input>
		</fieldset>
		<fieldset>
		<h3>Pitches</h3>
		
		<?php
		//allows user to select from locations in database- of type pitch- which they would like to include in the tournament
			$query = "SELECT location_id, locatin_name FROM location WHERE type='pitch' ORDER BY location_id ASC";
			$result = mysql_query($query);
			echo $query;

			while( list($event_id, $event_name) = mysql_fetch_row($result) )
			{
				echo "location: ".$row['location'];
				echo '<input type="checkbox" value="'.$row['location_id'].'" checked=true>'.$row['location_name'].'</input><br />';
			}
		?>
		</fieldset>
	
		<input type="submit" title="submit" />
	</form>
</body>
</html>