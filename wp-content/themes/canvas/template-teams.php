<?php
/**
 * Template Name: Teams
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
 $Results = mysql_query("SELECT * FROM `wattball_team`");

 $no_teams = mysql_num_rows($Results);
 
 // Put them in array
for($i = 0; $teams[$i] = mysql_fetch_assoc($Results); $i++) ;
// Delete last empty one
array_pop($teams);
 
?>

   <?php woo_content_before(); ?>
    <div id="content" class="col-full">
			<script>
				
				
			$(document).ready(function() {
				$(".fancybox").fancybox({	
											'autoScale'		:false,
											'width'			:540, 
											'height'		:100
										});
			});

</script>
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

				<table>
					<? 
					
					for($i = 0; $teams[$i]; $i++)
					{
					
						
						if($i != 0 && $i%4 == 0)echo "<tr>";
						echo "<td class='padding'>";
						echo '<a class="fancybox"  data-fancybox-type="iframe"  href="/wp-content/themes/canvas/teams_details.php?id='.$teams[$i]['assoc_id'].'" id="'.$teams[$i]['assoc_id'].'" )" ><img src="'. $teams[$i]['badge'] .'" title="'.$teams[$i]['team_name'].'" /></a>
						</td>';
						if($i != 0 && $i%4 ==0)echo "</tr>";
						$no++;
					}?>
					</table>
             
					
				   
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