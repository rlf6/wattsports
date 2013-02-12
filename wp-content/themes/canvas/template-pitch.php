<?

/**
 * Template Name: Pitch
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
global $woo_options;

$id = $_GET['id'];

$team = mysql_query("SELECT * FROM `wattball_team_members` where `team_assoc_id` ='$id' ORDER BY  `position` ASC  ");
$goalkeepers=0;
$defenders=0;
$midfielders=0;
$forwards=0;
$names=array();
while($row = mysql_fetch_array($team))
{
				array_push($names,$row['surname']); 
			if(	$row['position'] == "GoalKeeper")$goalkeepers++;
			if(	$row['position'] == "Defender")$defenders++;
			if(	$row['position'] == "Midfielder")$midfielders++;
			if(	$row['position'] == "Forward")$forwards++;
			
			    //$row['shirt_num']

}
//echo $goalkeepers ." ".$defenders. " ". $midfielders. " ".$forwards;
//print_r($names);
$arra=array($defenders,$midfielders,$forwards);
?>
<html>
<head>
<link rel="stylesheet" href="http://www.wattsports.co.uk/css/pitch.css"/>
</head>
<body>
<img class="goal" src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  />

<?
///defenders icons
foreach($arra as $num)
{
if($num == 2)Echo'<img class="hide" src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img class="hide" src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img class="hide" src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  />';
if($num == 3)Echo'<img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img class="hide" src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img class="hide" src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  />';
if($num == 4)Echo'<img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img class="hide" src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  />';
if($num == 5)Echo'<img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  /><img  src="/wp-content/themes/canvas/images/male.png" width="100" height="100"  />';
}


?>



</body>
</html>