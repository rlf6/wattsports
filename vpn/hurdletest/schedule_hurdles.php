<?php
$active1 ='';
$active2 ='active';
$active3 ='';
$active4 ='';
$active5 ='';
$active6 ='';
$Title="Scheduler";
include("../header.php");
include("../database.php");

$query = mysql_query("SELECT * FROM `location` WHERE `type`='track' ");
$num = mysql_num_rows($query);

?>

<div class="center_div">
	<div class="scroll_h">
<form method="POST" action="./create_schedule_hurdles.php">
<table> 
<tr>
	<th>Choose Time-Slots</th>
</tr>
<tr>
	<td>Tournament Start </td>
	<td><input name='start' type='date'></td>
	<td><input name='weekends' type='checkbox'></input> Include Weekends</td>
</tr>
<tr>
	<td>Tournament End </td>
	<td><input name='end' type='date'></td>
</tr>
<tr>
	<th>Number of Days </th>
</tr>
<tr>
	<td>Exclude date</td>
	<td><input name='exclude[]' type='date' value='yyyy-mm-dd'></td>
</tr>
<tr>
	<td>Minutes Between Races</td>
	<td> 
	<select name='mins_between' width='2'>
		<option value='00'>00</option>
		<option value='05'>05</option>
		<option value='10'>10</option>
		<option value='15'>15</option>
		<option value='20'>25</option>
		<option value='30'>30</option>
		<option value='45'>45</option>
		<option value='60'>60</option>
	</select>
	</td>
</tr>
<tr>
	<td>Races begin at</td>
	<td> 
	<select name='r_begins' width='2'> 
		<option value='07'>07</option>
		<option value='08'>08</option>
		<option value='09'>09</option>
		<option value='10'>10</option>
		<option value='11'>11</option>
		<option value='12'>12</option>
		<option value='13'>13</option>
		<option value='14'>14</option>
		<option value='15'>15</option>
		<option value='16'>16</option>
		<option value='17'>17</option>
		<option value='18'>18</option>
		<option value='19'>19</option>
		<option value='20'>20</option>
		<option value='21'>21</option>
		<option value='22'>22</option>
		<option value='23'>23</option>
	</select> : 
	<select name='r_begins_mins'>
		<option value='00'>00</option>
		<option value='05'>05</option>
		<option value='10'>10</option>
		<option value='15'>15</option>
		<option value='20'>25</option>
		<option value='30'>30</option>
		<option value='35'>35</option>
		<option value='40'>40</option>
		<option value='45'>45</option>
		<option value='50'>50</option>
		<option value='55'>55</option>
	</select>
	</td>
</tr>
<tr>
	<td>Races Finish at</td>
	<td> 
	<select name='r_ends' width='2'> 
		<option value='07'>07</option>
		<option value='08'>08</option>
		<option value='09'>09</option>
		<option value='10'>10</option>
		<option value='11'>11</option>
		<option value='12'>12</option>
		<option value='13'>13</option>
		<option value='14'>14</option>
		<option value='15'>15</option>
		<option value='16'>16</option>
		<option value='17'>17</option>
		<option value='18'>18</option>
		<option value='19'>19</option>
		<option value='20'>20</option>
		<option value='21'>21</option>
		<option value='22'>22</option>
		<option value='23'>23</option>
	</select> : 
	<select name='r_ends_mins'>
		<option value='00'>00</option>
		<option value='05'>05</option>
		<option value='10'>10</option>
		<option value='15'>15</option>
		<option value='20'>25</option>
		<option value='30'>30</option>
		<option value='35'>35</option>
		<option value='40'>40</option>
		<option value='45'>45</option>
		<option value='50'>50</option>
		<option value='55'>55</option>
	</select>
	</td>
</tr>
<tr><th>Tracks</th></tr>
<?	
for($x =0;$x < $num;$x++)
	{
	$r0 = mysql_result($query,$x,0);
	$r1 = mysql_result($query,$x,1);
	$r3 = mysql_result($query,$x,4);
	
	echo "<tr>
			<td><img src='".$r3."' width='150' height='100'/></td>
			<td><input name='track[]' type='checkbox' value='".$r0."' />".$r1."</td>
		  </tr>" ; 
	}

?>
<tr><td><input type="submit" ></td></tr>
</table>
</form>

</div>
</div>
</div>
</html>

<script>

</script>
