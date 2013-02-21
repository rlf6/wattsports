<?php
/**
 * Page Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */

get_header();
?>
       
    <!-- #content Starts -->
<div class="well" style="position:absolute;left:20px; max-width: 340px; padding: 8px 0;">
              <ul class="nav nav-lists" style="height:300px;">
                <li class="nav-header">List header</li>
				<li class="divider"></li>
                <li class=""><a href="#">Home</a></li>
               <li class="divider"></li>
			   <li><a href="#">Library</a></li>
			   <li class="divider"></li>
                <li><a href="#">Applications</a></li>
				<li class="divider"></li>
                <li class="nav-header">Another list header</li>
				<li class="divider"></li>
                <li><a href="#">Profile</a></li>
				<li class="divider"></li>
                <li><a href="#">Settings</a></li>
                <li class="divider"></li>
                <li><a href="#">Help</a></li>
              </ul>
            </div> <!-- /well -->
	<?php woo_content_before(); ?>

    <div id="content" class="col-full">
    
    	<div id="main-sidebar-container">    

            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <div id="main">                     
<?php
	woo_loop_before();
	
	if (have_posts()) { $count = 0;
		while (have_posts()) { the_post(); $count++;
			woo_get_template_part( 'content', 'page' ); // Get the page content template file, contextually.
		}
	}
	
	woo_loop_after();
?>     
            </div><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar( 'alt' ); ?>

    </div><!-- /#content -->
	<?php woo_content_after(); ?>

<?php get_footer(); ?>