<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include("../database.php");

$active1 ='';
$active2 ='';
$active3 ='active';
$active4 ='';
$active5 ='';
$active6 ='';
$Title = "Wattsports";
$mobile ='';

include('./header.php');



?>
<script type="text/javascript" src="/js/details.js"></script>
	<h2 class='watt'>Wattball Details</h2>
<div class="center_div" border="2px solid">

	<div class="scroll_w">
	<form>
	<table id='watt'>
	<tr><th></th><th>Assoc ID</th><th>Team</th><th>Mgr Name</th><th>Mgr Surname</th><th>Email</th><th>Address</th><th>Captain</th><th>Badge</th><th></th></tr>
<?
	$Query = mysql_query("SELECT * FROM `wattball_team` ORDER BY  `wattball_team`.`assoc_id` ASC");
	
	$num = mysql_num_rows($Query);
	
	for($x =0;$x < $num;$x++)
	{
	$r0 = mysql_result($Query,$x,0);
	$r1 = mysql_result($Query,$x,1);
	$r2 = mysql_result($Query,$x,2);
	$r3 = mysql_result($Query,$x,3);
	$r4 = mysql_result($Query,$x,4);
	$r5 = mysql_result($Query,$x,5);
	$r6 = mysql_result($Query,$x,6);
	$r7 = mysql_result($Query,$x,7);

	
	echo "<tr id='t".$r0."'><td><img id='".$r0."' style='cursor: pointer; cursor: hand' src='/images/open.png' onclick='expand(id)' height='18px' width='20px' /></td><td><input id='".$r0."0' type='text' name='team:assoc_id' size='6' value='".$r0."'/></td><td><input id='".$r0."1' type='text' name='team:team_name' size='7' value='".$r1."'/></td><td><input id='".$r0."2' type='text' name='team:mgr_name' size='6' value='".$r2."'/></td><td><input id='".$r0."6' type='text' name='team:mgr_surname' size='9' value='".$r3."'/></td>
	<td><input id='".$r0."4' type='text' name='team:email' size='16' value='".$r4."'/></td><td><input id='".$r0."5' type='text' name='team:address' size='20' value='".$r5."'/></td><td><input id='".$r0."6' type='text' name='team:captain' size='3' value='".$r6."'/></td><td><input id='".$r0."7' type='text' name='team:badge' size='16' value='".$r7."'/></td><td><img id='".$r0."' style='cursor: pointer; cursor: hand' src='/images/delete-icon.png' onclick='confirmW(id)' height='18px' width='20px' /></td></tr>";

	}
	
?>
	</table>
	<img id='0' style="cursor: pointer; cursor: hand" src='/images/add-icon.png' onclick='addTeam()' width='50px' height='50px' />
	</form>
	
	</div>				
</div>

</div>

</html>

