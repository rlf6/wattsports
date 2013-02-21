<?php
$active1 ='';
$active2 ='active';
$active3 ='';
$active4 ='';
$active5 ='';
$active6 ='';
$Title="Wattsports";
include("./header.php");
include("./database.php");
/*
$query = mysql_query("SELECT * FROM `location` WHERE `type`='track' ");
$num = mysql_num_rows($query);
*/
if($_POST)
{
$name = $_POST['name'];
$start = $_POST['start'];
$end = $_POST['end'];
$type = $_POST['type'];
	if(mysql_query("INSERT INTO `wattspor_database`.`event` (`event_id`, `name`, `event_type`, `start_date`, `end_date`)  VALUES ('', '$name','$type', $start ,$end)"))
	{
		$event =1;
	}
}

?>

<div class="center_div">
<h2>Create an Event</h2>
	<div class="scroll">
<? 
if($event == 1)
{
Echo "<br /><p>A new Event has been created.<br /> The Following Details will be added into the database:<br />
		Name: $name , Type: $type , Start Date: $start, End Date: $end.
		<br /> </p>";
}
else{
echo"
<form method='POST' action='./schedule_event.php'>
<table style='margin-left:50px; width='600px'> 
<tr align='center'>
	<th>Event Name</th>
	<td><input name='name' type='text'></td>
</tr>
<tr  align='center'>
	<th>Event Start </th>
	<td><input name='start' type='date'></td>
	<td><input name='weekends' type='checkbox'></input> Include Weekends</td>
</tr>
<tr  align='center'>
	<th>Event End </th>
	<td><input name='end' type='date'></td>
</tr>


<tr  align='center'>
	<th>Event Type</th>
	<td> 
	<select  name='type'  width='170px' style='width:170px;'>
		<option value='Wattball(Round Robin)'>Wattball(Round Robin)</option>
		<option value='Hurdles 400m (M)'>Hurdles 400m (M)</option>
		<option value='Hurdles 400m (F)'>Hurdles 400m (F)</option>
		<option value='Hurdles 200m (M)'>Hurdles 200m (M)</option>
		<option value='Hurdles 200m (F)'>Hurdles 200m (F)</option>
		<option value='Hurdles 100m (M)'>Hurdles 100m (M)</option>
		<option value='Hurdles 100m (F)'>Hurdles 100m (F)</option>
		
	</select>
	</td>
</tr>

<tr  align='center'><td colspan='3'><input type='submit' ></td></tr>
</table>
</form>";
}
?>
</div>
</div>
</div>
</html>

<script>

</script>
