<?php
include('../database.php');

$id = $_POST['variable'];

$Query = mysql_query("SELECT * FROM `wattball_team_members` WHERE `team_assoc_id` = $id ORDER BY  `wattball_team_members`.`member_id` ASC");
	
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
	$r8 = mysql_result($Query,$x,8);
	
	echo "<tr id='t".$r0."'><td><input id='".$r0."0' type='text' name='watt:member_id' size='2' value='".$r0."'/></td><td><input id='".$r0."1' type='text' name='watt:name' size='7' value='".$r1."'/></td><td><input id='".$r0."2' type='text' name='watt:surname' size='6' value='".$r2."'/></td><td><input id='".$r0."6' type='text' name='watt:address' size='13' value='".$r3."'/></td>
	<td><input id='".$r0."4' type='text' name='watt:dob' size='7' value='".$r4."'/></td><td><input id='".$r0."5' type='text' name='watt:phone' size='8' value='0".$r5."'/></td><td><input id='".$r0."6' type='text' name='watt:email' size='18' value='".$r6."'/></td><td><input id='".$r0."7' type='text' name='watt:position' size='8' value='".$r7."'/></td><td><input id='".$r0."8' type='text' name='watt:shirt_num' size='5' value='".$r8."'/></td><td><img id='".$r0."' style='cursor: pointer; cursor: hand' src='/images/delete-icon.png' onclick='confirmW(id)' height='18px' width='20px' /></td></tr>";
	}
	?>