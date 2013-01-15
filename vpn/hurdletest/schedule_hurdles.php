<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Schedule Event</title>
</head>

<body>
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
</body>
</html>
