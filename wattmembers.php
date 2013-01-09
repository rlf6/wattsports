<?php
$name = $_POST['name'];
$assoc = $_POST['associd'];
$email = $_POST['email'];
$addre = $_POST['address'];
$no_mem = $_POST['no_mem'];
$no = 0;


$str = array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','Ninth','Tenth','Eleventh','Twelfth','Thirteenth','Fourteenth','Fifteenth','Sixteenth','Seventeenth','Eighteenth','Nineteenth','Twentieth');

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register Team Members</title>
</head>

<body>
<h1> Register your Teams Members. </h1>
<h3> Thanks <? echo $name ?> your almost there. </h3>
<form action='./registermembers.php' method='POST'>

<?
if($no_mem == null or $no_mem == '0')
{
	 echo 'You have 0 Members in your team go back to fix it.';
	 die();
}

while($no < $no_mem)
{
	
		echo ' Your '.$str[$no].' Players Details
		<p> Name <input name="name'.$no.'" type="text" /></p>
		<p> Surname <input name="surname'.$no.'" type="text" /></p>
		<p> Email Address <input name="email'.$no.'" type="text" /></p> 
		<p> Address <input name="address'.$no.'" type="text" /></p>
		<p> Phone Number <input name="phone'.$no.'" type="text" /></p>
		<p> Date of Birth <input name="dob'.$no.'" type="text" /></p>
		<p> Position <input name="position'.$no.'" type="text" /></p>
		<hr />';
		
		$no++;
}


?>
<input type="hidden"name='team_name' value='<?echo $name;?>' />
<input type="hidden"name='no_mem' value='<?echo $no_mem;?>' />
<input type="hidden"name='assoc' value='<?echo $assoc;?>' />
<input type="hidden"name='addre' value='<?echo $addre;?>' />
<input type="hidden"name='email' value='<?echo $email;?>' />
<input type='submit' title="Submit" />
</form>

<hr />
</body>
</html>
