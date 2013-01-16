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


<div class="center_div" border="2px solid">
	<div class="scroll_h">
	<form>
	<table border="2px">
	<tr><th>Assoc ID</th><th>Team Name</th><th>Mgr Name</th><th>Mgr Surname</th><th>Email</th><th>Address</th><th>Captain</th><th>Badge</th></tr>
<?
	$Query = mysql_query("SELECT * FROM `wattball_team` ORDER BY  wattball_team.`team_name` ASC");
	
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

	
	echo "<tr><td><input id='".$r0."0' type='text' name='id' size='2' value='".$r0."'/></td><td><input id='".$r0."1' type='text' name='name' size='4' value='".$r1."'/></td><td><input id='".$r0."2' type='text' name='surname' size='4' value='".$r2."'/></td><td><input id='".$r0."3' type='text' name='address' size='24' value='".$r3."'/></td>
	<td><input id='".$r0."4' type='text' name='phone' size='11' value='".$r4."'/></td><td><input id='".$r0."5' type='text' name='email' size='25' value='".$r5."'/></td><td><input id='".$r0."6' type='text' name='dob' size='8' value='".$r6."'/></td><td><input id='".$r0."7' type='text' name='sex' size='4' value='".$r7."'/></td></tr>";

	}
	
?>
	</table>
	</form>
	<script>
	var id='';
	var id2='';
	var value='';
	
 function generate(layout) {
  	var n = noty({
  		text: 'Success',
  		type: 'success',
      dismissQueue: true,
	   timeout: '1000',
  		layout: layout,
  		theme: 'defaultTheme'
  	});
  	console.log('html: '+n.options.id);
  }


   
  
  

	
	
	
	$('input').click(function() { 
	
		value = event.target.value;  
		id = event.target.id;
	});

	
	$('input').blur(function(){
	 id2 = event.target.id;
	 var name = event.target.name;
	var value2 = event.target.value;
		if (value != value2 && id == id2){
			var id3 =id.substr(0,(id.length-1));

			var packet = id3+":"+name+":"+value2;
			
			$.post("./hurdlerupdate.php",{variable: packet},
			  function(data) {
				 generate('topRight');
			  });
		}

		});
		
	
	</script>
	</div>				
</div>

</div>
</html>

