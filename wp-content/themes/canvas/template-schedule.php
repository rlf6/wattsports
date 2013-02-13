<?php
/**
 * Template Name: Schedule
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
			<h3>View schedules for our upcoming events: </h3></br></br>
			<table width="100%"><tr><td width="45%">
			<img src="/wp-content/themes/canvas/images/wattball-general.jpg" title="View Wattball Tournaments img" alt="View Wattball Tournaments img" width="300" height="260" />
			<form  method="POST" action="http://www.wattsports.co.uk/schedule/wattball-schedule">
<?php
		//TO DO: specify events so that only those with existing schedules show
		$query = "SELECT `event_id`, `name` FROM `event` WHERE event_type='wattball' ORDER BY event_id ASC";
		$result = mysql_query($query);
		
		echo '<select name="event_id" style="width: 150px">';
		while( list($event_id, $event_name) = mysql_fetch_row($result) )
		{
	 		echo '<option value="'.$event_id.'">'.$event_name.'</option>';
	 	}
		echo '</select>';
	
?>    
	<input type="submit" title="submit"/>
	</form>
	</td>
	<td width="5%">
	</td>
	<td width="45%">
	<img src="/wp-content/themes/canvas/images/hurdle-general.jpg" width="300" height="260" title="Hurdles" alt="View Hurdling Schedules"  />
	<form  method="POST" action="http://www.wattsports.co.uk/schedule/hurdling-schedule">
<?php
		//TO DO: specify events so that only those with existing schedules show
		$query = "SELECT `event_id`, `name` FROM `event` WHERE event_type LIKE 'hurdle%' ORDER BY event_id ASC";
		$result = mysql_query($query);
		
		echo '<select name="event_id" style="width: 150px">';
		while( list($event_id, $event_name) = mysql_fetch_row($result) )
		{
	 		echo '<option value="'.$event_id.'">'.$event_name.'</option>';
	 	}
		echo '</select>';
	
?>    
	<input type="submit" title="submit" />
	</form>
	</td>
	</tr></table>
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php //get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->         

		<?php //get_sidebar( 'alt' ); ?>

    </div><!-- /#content -->
	<?php// woo_content_after(); ?>

<?php get_footer(); ?>