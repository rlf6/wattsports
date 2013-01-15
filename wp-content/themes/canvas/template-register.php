<?php
/**
 * Template Name: Register
 *
 * The contact form page template displays the a
 * simple contact form in your website's content area.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
global $woo_options;
get_header();
 
?>

   <?php woo_content_before(); ?>
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

      

                     <p><a href="/register/register-wattball-team/"><img src="/wp-content/themes/canvas/images/football_tournament.png" title="Register your WattBall Team" alt="Register your WattBall Team" width="300" height="260" /></a>&nbsp;	&nbsp;	&nbsp;	<a href="/register/register-hurdler/"><img src="/wp-content/themes/canvas/images/hurdles_tournament.png" width="300" height="260" title="Register Hurdler" alt="Register Hurdler"  /></a></p>

  
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