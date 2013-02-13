<?php
/**
 * Template Name: Hurdler Schedule
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
			<tr><th>Date</th><th>Start-Time</th><th>Location</th><th>Runners</th></tr>
<?php
	$event_id = $_POST['event_id'];
	$query = "SELECT * FROM race WHERE event_event_id='".$event_id."' ORDER BY date, time";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_assoc($result))
	{
		echo '<tr>';
		echo '<td class="padding2">'.$row['date'].'</td>';
		echo '<td class="padding2">'.$row['time'].'</td>';
		$location = mysql_fetch_assoc(mysql_query("SELECT `location_name` FROM `location` WHERE location_id='".$row['location_id']."'"));
		echo '<td class = "padding2">'.$location['location_name'].'</td>';
		echo '<td class = "padding2">';
		//get runners
		for($i = 1; $i <= 8; $i++)
		{
			$runners = mysql_fetch_assoc(mysql_query("SELECT lane".$i." AS lane FROM race WHERE race_id='".$row['race_id']."'"));
			if($runners['lane'] != NULL)
			{
				$getname = mysql_fetch_assoc(mysql_query("SELECT name, surname FROM hurdler WHERE id='".$runners['lane']."'"));
				$name = $getname['name']." ".$getname['surname'];
				echo "Lane".$i.": ".$name."<br>";
			}
			else if ($runners['lane'] == NULL && $i == 1)
			{
				echo "<i>Awaiting Results</i>";
			}
		}	
		echo '</td>';
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
	<?php woo_content_after(); ?>

<?php
/**
 * Template Name: Hurdler Schedule
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
?>
       
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">
    
    	<div id="main-sidebar-container">    

            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <div id="main">                     
<?php
	
	$event_id = $_POST['event_id'];
		
		
	
?>     
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>

    </div><!-- /#content -->
	<?php woo_content_after(); ?>

<?php get_footer(); ?>