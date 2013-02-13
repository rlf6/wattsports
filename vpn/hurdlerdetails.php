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
$active7 ='';
 $Title = "Wattsports";
$mobile ='';

include('./header.php');



?>
<script type="text/javascript" src="/js/details.js"></script>
	<h2 class='hurdler' >Hurdlers Details</h2>
<div class="center_div" border="2px solid">

	<div class="scroll_h">
	<form>
	<table border="2px" id='table'>
	<tr><th>ID</th><th>Name</th><th>Surname</th><th>Address</th><th>Mobile</th><th>Email</th><th>Dob</th><th>Sex</th><th>Previous Best</th><th></th></tr>
<?
	$Query = mysql_query("SELECT * FROM `hurdler` ORDER BY  `hurdler`.`id` ASC");
	
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
	
	echo "<tr id='t".$r0."'><td><input id='".$r0."0' type='text' name='hurdler:id' size='2' value='".$r0."'/></td><td><input id='".$r0."1' type='text' name='hurdler:name' size='4' value='".$r1."'/></td><td><input id='".$r0."2' type='text' name='hurdler:surname' size='4' value='".$r2."'/></td><td><input id='".$r0."3' type='text' name='hurdler:address' size='24' value='".$r3."'/></td>
	<td><input id='".$r0."4' type='text' name='hurdler:phone' size='10' value='0".$r4."'/></td><td><input id='".$r0."5' type='text' name='hurdler:email' size='25' value='".$r5."'/></td><td><input id='".$r0."6' type='text' name='hurdler:dob' size='8' value='".$r6."'/></td><td><input id='".$r0."7' type='text' name='hurdler:sex' size='2' value='".$r7."'/></td><td><input id='".$r0."8' type='text'name='hurdler:previous_best' size='7' value='".$r8."'/></td><td><img id='".$r0."' style='cursor: pointer; cursor: hand' src='/images/delete-icon.png' onclick='confirm(id)' height='18px' width='20px' /></td> </tr>";

	}
	
?>
	
	</table>
	
	<img id='0' style="cursor: pointer; cursor: hand" src='/images/add-icon.png' onclick='addRow()' width='50px' height='50px' />
	</form>

	</div>				
</div>

</div>
</html>

