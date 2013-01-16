<?php
include('../../../database.php');
$id = $_GET['id'];
$team = mysql_query("SELECT * FROM `wattball_team_members` where `team_assoc_id` ='$id' ORDER BY  `shirt_num` ASC  ");


?>



<html>
<head>
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/bootstrap.min.css"/> 
		
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/docs.css"/>


</head>
<body>

<div class="center_div" >
<h1>  Team</h1>
<table  border="2px" cellpadding="2px"  >
<tr>
			<th>First name</th>
			<th>Last name</th>
			<th>Position</th>
			<th>D.o.b</th>
			<th>Shirt Number</th>
</tr>
<?
		while($row = mysql_fetch_array($team))
			  {
			  echo "<tr>";
			  echo "<td ALIGN=CENTER>" . $row['name'] . "</td>";
			  echo "<td ALIGN=CENTER>" . $row['surname'] . "</td>";
			  echo "<td ALIGN=CENTER>" . $row['position'] . "</td>";
			   echo "<td ALIGN=CENTER>" . $row['dob'] . "</td>";
			   echo "<td ALIGN=CENTER>" . $row['shirt_num'] . "</td>";
			  echo "</tr>";
			  }
			  
?>

</table>
<a class="center" href="./pitch.php<?echo "?id=$id";?> ">Pitch view</a>



</body>
</html>