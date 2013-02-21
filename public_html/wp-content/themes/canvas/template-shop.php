<?php
/**
 * Template Name: Shop
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
global $woo_options;
get_header();
$no =0;
$Results  = mysql_query("SELECT * FROM  `match` ");
$no_match = mysql_num_rows($Results);

for($i = 0; $match[$i] = mysql_fetch_assoc($Results); $i++) ;
// Delete last empty one
array_pop($match);

$no =0;
$Result  = mysql_query("SELECT * FROM  `race` ");
$no_race = mysql_num_rows($Result);

for($i = 0; $race[$i] = mysql_fetch_assoc($Result); $i++) ;
// Delete last empty one
array_pop($race);
?>
  <?php woo_content_before(); ?>
	<link rel='stylesheet' type='text/css' href='http://www.wattsports.co.uk/fullcalendar-1.5.4/fullcalendar/fullcalendar.css' />
	<link rel='stylesheet' type='text/css' href='http://www.wattsports.co.uk/fullcalendar-1.5.4/fullcalendar/fullcalendar.print.css' media='print' />
	<script type='text/javascript' src='http://www.wattsports.co.uk/fullcalendar-1.5.4/jquery/jquery-1.8.1.min.js'></script>
	<script type='text/javascript' src='http://www.wattsports.co.uk/fullcalendar-1.5.4/jquery/jquery-ui-1.8.23.custom.min.js'></script>
	<script type='text/javascript' src='http://www.wattsports.co.uk/fullcalendar-1.5.4/fullcalendar/fullcalendar.min.js'></script> 
	<script type="text/javascript" src='/wp-content/themes/canvas/fancybox/source/jquery.fancybox.pack.js'></script>
	<style type='text/css'>

	body {
		
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}

	#calendar {
		width: 800px;
		margin: 0 auto;
		}

	</style>
<script type='text/javascript'>
	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		
		$('#calendar').fullCalendar({
			editable: false,
			
			events: [
				<?

				for($inc; $inc < $no_match; $inc++ )
				{
					if($inc > 0 && $inc <= $no_match)
					{
						 echo",";
					}
				$date = explode("-",$match[$no]["date"]);
				echo '{
						title: "'.$match[$no]["team_A"]." vs ".$match[$no]["team_B"].'",
						start: new Date('.$date[0].', '.(intval($date[1])-1).', '.$date[2].'),
						eventBackgroundColor: "red",
						url:   "http://www.wattsports.co.uk/shop"
			
					 }';
					
					$no++;
				}
				$no =0;
				for($inc =0 ; $inc < $no_race; $inc++ )
				{
					if( $inc <= $no_race)
					{
						 echo",";
					}
				$date = explode("-",$race[$no]["date"]);
				echo '{
						title: "'.$race[$no]["race_name"].'",
						start: new Date('.$date[0].', '.(intval($date[1])-1).', '.$date[2].'),
						eventBackgroundColor: "red",
						url:   "http://www.wattsports.co.uk/shop"
			
					 }';
					
					$no++;
				}
				
				?>
			],
			eventClick: function(event) {
		
			if (event.url) {
					$.fancybox({
						'width'			:540, 
						'height'		:400,
						'type'			:'iframe',
						'href'			: event.url
					});
					return false;
				}
			}
		});
		
	});

</script>
    <div id="content" class="col-full">

		<div id="main-sidebar-container">
		
		<!-- #main Starts -->
		<?php woo_main_before(); ?>
		<div id="main">
    
		<?php woo_loop_before(); ?>
		<!-- Post Starts -->
		<?php woo_post_before(); ?>

            <div id="contact-page" class="page">
            
            <?php woo_post_inside_before(); ?>
            
            <h1 class="title"><?php the_title(); ?></h1>

			<div>
				
				<h3>Purchase day tickets</h3> 
				<div id='calendar'></div>
             
			</div>	
				   
			<div class="fix"></div>
				<?php woo_post_inside_after(); ?>

            </div><!-- /#contact-page -->
            
           <?php woo_post_after(); ?>
                    
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>

    </div><!-- /#content -->
	<?php woo_content_after(); ?>

<?php get_footer(); ?>


