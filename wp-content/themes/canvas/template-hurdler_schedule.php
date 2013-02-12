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
			<table border="2" width="50%">
			<tr><th>Date</th><th>Start-Time</th><th>Runners</th></tr>
<?php
	$event_id = $_POST['event_id'];
	
	
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

<?php get_footer(); ?>