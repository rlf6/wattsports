<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include("../database.php");

$active1 ='';
$active2 ='active';
$active3 ='';
$active4 ='';
$active5 ='';
$active6 ='';
$active7 ='';
$Title = "Wattsports";
$mobile ='';
include('./header.php');
?>
	<h2 class='scheduler' >Scheduler</h2>
<div class="center_div" border="2px solid">
			<div style='background-color:white; height:300px; margin-right:50px; ' >
			
			<br />
			<br />			
			
			<table style="width:880px; " >
				<tr>
					<td width='880' align='center' colspan='2' cellpadding='100px'><FORM METHOD="LINK" ACTION="./schedule_event.php">
					<INPUT TYPE="submit" class="btn-primary btn-large" VALUE="Create an Event">
					</FORM></td>
				</tr>
				<tr>
					<td width='440' align='center'><FORM  METHOD="LINK" ACTION="./schedule_hurdles.php">
						<INPUT  TYPE="submit" class="btn-primary btn-large" VALUE="Schedule Hurdling">
					</FORM></td>
				
					<td width='440' align='center'><FORM   METHOD="LINK" ACTION="./schedule_wattball.php">
						<INPUT TYPE="submit" class="btn-primary btn-large" VALUE="Schedule Wattball">
					</FORM>	
					</td>
				</tr>
			</table>	
			
	
 			</div>

</div>

</html>
