<?php
/**
 * Template Name: Scheduler
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
	
	$query = mysql_query("Select * From `hurdler`");
		
	
		
			echo "<table border='3'>
			<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Previous Best</th>
			</tr>";

			while($row = mysql_fetch_array($query))
			  {
			  echo "<tr>";
			  echo "<td>" . $row['name'] . "</td>";
			  echo "<td>" . $row['surname'] . "</td>";
			  echo "<td>" . $row['previous_best'] . "</td>";
			  echo "</tr>";
			  }
			echo "</table>";

		
	
?>     
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>

    </div><!-- /#content -->
	<?php woo_content_after(); ?>

<?php get_footer(); ?>