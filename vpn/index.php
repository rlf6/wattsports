<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include("../database.php");
if(isset($_POST['admin']))
{
	session_start();
	$user = $_POST['admin'];
	$pass = $_POST['password'];

	$encpass = md5($pass);
	$Q = "SELECT * FROM `admins` WHERE `username` = '$user' AND `password` = '$encpass' ";
	$re = mysql_query($Q);
	$num = mysql_num_rows($re);
		session_set_cookie_params(0,'/','.wattsports.co.uk/');
		$_SESSION['username'] = $user;
		$_SESSION['md5str'] = $encpass;
		session_write_close();
	
	if($num > 0)
	{
		echo '<meta http-equiv="Refresh" content="5;url=http://vpn.wattsports.co.uk/home.php">';
		ECHO "login successfull  ";
	}
}

if (isset($_COOKIE['PHPSESSID'])) 
 {

	//session_set_cookie_params(0,'/','.newlookrota.co.uk/');
	session_start();
	session_regenerate_id();
  // Login
	$user = $_SESSION['username'];
	$pass = $_SESSION['md5str'];
	$encpass = $pass;
	$Q = "SELECT * FROM `admins` WHERE `username` = '$user' AND `password` = '$pass' ";
	$re = mysql_query($Q);
	$num = mysql_num_rows($re);
	if($num > 0)
	{
		header("Location: http://vpn.wattsports.co.uk/home.php");
		
	}
	
}
echo "<html> ";
?>
<head>
<title>Admin Login</title>

</head>
<body>
<div align="center">
<h1>Admin Login </h1>
<p> Please Login to access the VPN. </p>

<form method="POST" action="http://vpn.wattsports.co.uk/">
<table>
<tr><td>Username</td><td><input type='text' name='admin' /></td></tr>
<tr><td>Password</td><td><input type='password' name='password' /></td></tr>
<tr><td></td><td><input type='submit' name='submit' /></td><td></td></tr>

</table>
</form>
</div>
</body>

</html>