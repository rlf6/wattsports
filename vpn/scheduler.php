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
				
			<table><tr>
				<td><FORM class="center" METHOD="LINK" ACTION="./schedule_hurdles.php">
					<INPUT TYPE="submit" class="btn-primary btn-large" VALUE="Schedule Hurdling">
				</FORM></td>
				
				<td><FORM class="center"  METHOD="LINK" ACTION="./schedule_wattball.php">
					<INPUT TYPE="submit" class="btn-primary btn-large" VALUE="Schedule Wattball">
				</FORM>	</td></tr></table>	
 			
			
			
			
						
</div>


</html>
