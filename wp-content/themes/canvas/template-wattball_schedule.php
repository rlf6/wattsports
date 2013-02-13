<?php
/**
 * Template Name: Wattball Schedule
 *
 * This template displays content from the "Widgets Page Template" registered sidebar.
 * If no widgets are present in this registered sidebar, the default page content is displayed instead.
 *
 * It is possible to override this registered sidebar for multiple pages using the WooSidebars plugin ( http://woothemes.com/woosidebars ).
 *
 * @package WooFramework
 * @subpackage Template
 */

get_header();
include("./database.php");
?>
       
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">
    	<div id="main-sidebar-container">    

            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <div id="main"> 
			<div class="center_div" border="2px solid">
			<div class="scroll">
			<table>
			<tr><th>Date</th><th>Kick-off</th><th colspan=4>Match</th><th>Location</th></tr>
<?php
	$event_id = $_POST['event_id'];
	
	$query = "SELECT `kick_off`, `date`, `team_A`, `team_B`, `location_id` FROM `match` WHERE event_event_id='".$event_id."' ORDER BY date, kick_off ASC";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_assoc($result))
	{
		echo '<tr>';
		echo '<td class="padding2">'.$row['date'].'</td><td class="padding2">'.$row['kick_off'].'</td>';
		
		//find team names from assoc_id in match and display badge
		$query_team = mysql_fetch_assoc(mysql_query("SELECT `team_name`, `badge` FROM `wattball_team` WHERE assoc_id='".$row['team_A']."'"));
		echo '<td class="padding2"><img src="'.$query_team['badge'].'"</img><td>';
		echo '<td class = "padding2">'.$query_team['team_name'].' vs. ';
		$query_team = mysql_fetch_assoc(mysql_query("SELECT `team_name`, `badge` FROM `wattball_team` WHERE assoc_id='".$row['team_B']."'"));
		echo $query_team['team_name'].'</td><td class="padding2"><img src="'.$query_team['badge'].'"</img></td>';
		
		$location = mysql_fetch_assoc(mysql_query("SELECT `location_name` FROM `location` WHERE location_id='".$row['location_id']."'"));
		echo '<td class = "padding2">'.$location['location_name'].'</td>';
		echo '</tr>';
	}
?>    
</table>
</div></div>
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>

    </div><!-- /#content -->
	<?php// woo_content_after(); ?>

<?php get_footer(); ?>