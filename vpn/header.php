<? 

if (isset($_COOKIE['PHPSESSID'])){

session_start();

}

if (empty($_SESSION['username'])) {
	
	header('Location: http://vpn.wattsports.co.uk');
}
$username = $_SESSION['username'];
 ?>
 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<meta name="viewport" <? echo $mobile; ?> />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>WattSports</title>
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/bootstrap.min.css"/> 
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/bootstrap.min2.css"/>
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/bootstrap.css"/>
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/docs.css"/>
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/bootstrap-responsive.min.css"/>
		<link rel="stylesheet" href="http://www.wattsports.co.uk/css/sprite_icons.css" type="text/css">
			
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).scroll(function(){
				// If has not activated (has no attribute "data-top"
				if (!$('.subnav').attr('data-top')) {
					// If already fixed, then do nothing
					if ($('.subnav').hasClass('subnav-fixed')) return;
					// Remember top position
					var offset = $('.subnav').offset()
					$('.subnav').attr('data-top', offset.top);
				}

				if ($('.subnav').attr('data-top') - $('.subnav').outerHeight() <= $(this).scrollTop())
					$('.subnav').addClass('subnav-fixed');
				else
					$('.subnav').removeClass('subnav-fixed');
				});
				
			$(document).ready(function() {
				//alert("Welcome Thanks For Visiting my Website. Unfortunately I am currently working on it so it may not look like it normally should! Hopefully I will have it fixed soon Thanks.");
			});
			
			
			
			
		</script>
		<script src="http://www.newlookrota.co.uk/js/bootstrap-dropdown.js"></script>
		<script>
			$('.dropdown-toggle').dropdown();
		</script>
	</head>    
		
	<body data-spy="scroll" data-target=".subnav" data-offset="0">
			<img class="logo" src="./logoHW.png" alt="Logo" >
	
		
		<div class="container">	
		
			


	<header class="jumbotron subhead">
	<h1><? print($Title); ?></h1>
       <button class="btn" >Log out</button>
        <div class="subnav">
		<div class="subnavbar-inner">
          <ul class="nav nav-pills" >
            <li class='<?print($active1);?>'><a href="home.php"><i class='glyphicon-home'></i> Home</a></li>  
            <li class='<?print($active2);?>'><a href="scheduler.php"><i class='glyphicon-show-thumbnails-with-lines'></i> Scheduler</a></li>
            <li class='<?print($active3);?>'><a href="competitors.php"><i class='glyphicon-list'></i> Competitors Details</a></li>
			 <li class='<?print($active3);?>'><a href="statistics.php"><i class='glyphicon-list'></i> Statistics</a></li>
			 <li class='<?print($active3);?>'><a href="reports.php"><i class='glyphicon-list'></i> Reports</a></li>
			 <li class='<?print($active3);?>'><a href="ticketing.php"><i class='glyphicon-list'></i> Ticketing</a></li>
			

			</ul>
		  </div>
        </div>
	
      </header>