<?php
/**
 * Template Name: Register Wattball
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WooFramework
 * @subpackage Template
 */


global $woo_options;
get_header();
 
 $name = $_POST['team_name'];
// echo $name;

?>

   <?php woo_content_before(); ?>
    <div id="content" class="col-full">
			
		<div id="main-sidebar-container">
		
		<!-- #main Starts -->'
		<?php woo_main_before(); ?>
		<div id="main">
    
		<?php woo_loop_before(); ?>
		<!-- Post Starts -->
		<?php woo_post_before(); ?>

            <div id="contact-page" class="page">
            
            <?php woo_post_inside_before(); ?>
            
            <h1 class="title"><?php the_title(); ?></h1>

			<?
				if(!empty($_POST)){
				echo "HYYYY";
				}
				else{ 
				echo'

                    <div>
						<h3>To register fill out the required information below.</h3>
					</div>
					<div>
						<br />
						<table>
						<form  method="POST" action="?page_id=27">
						
						<tr><p><td> Team Name </td><td><input name="team_name" type="text" /></td></p></tr>
						<tr><p><td> WattBall Association ID </td><td><input name="associd" type="text" /></td></p></tr>
						<tr><p><td> Email Address </td><td><input name="email" type="text" /></td></p> </tr>
						<tr><p><td> Address </td><td><input name="address" type="text" /></td></p></tr>
						<tr><p><td> Number of Members </td><td><input name="no_mem" type="select" maxlength="2" /></td></p></tr>
						<tr><td><input type="submit" title="submit" /></td></tr>
						</form>
						</table>
					</div>';  
					}
					?>
  
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