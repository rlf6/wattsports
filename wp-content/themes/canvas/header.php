<?php
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
 // Setup the tag to be used for the header area (`h1` on the front page and `span` on all others).
 $heading_tag = 'span';
 if ( is_home() OR is_front_page() ) { $heading_tag = 'h1'; }
 
 // Get our website's name, description and URL. We use them several times below so lets get them once.
 $site_title = get_bloginfo( 'name' );
 $site_url = home_url( '/' );
 $site_description = get_bloginfo( 'description' );
 
 global $woo_options;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
<title><?php woo_title(); ?></title>


<?php woo_meta(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo esc_url( get_bloginfo( 'stylesheet_url' ) ); ?>" media="all" />
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<?php wp_head(); ?>
<?php woo_head(); ?>

<!-- Add jQuery library -->
<script type="text/javascript" 	src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" 	src= "/wp-content/themes/canvas/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" 			href="/wp-content/themes/canvas/fancybox/source/jquery.fancybox.css?v=2.1.3" type="text/css" media="screen" />
<script type="text/javascript"  src= "/wp-content/themes/canvas/fancybox/source/jquery.fancybox.pack.js?v=2.1.3"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" 			href="/wp-content/themes/canvas/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" 	src= "/wp-content/themes/canvas/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" 	src= "/wp-content/themes/canvas/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

<link rel="stylesheet" 			href="/wp-content/themes/canvas/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript"	 src="/wp-content/themes/canvas/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

</head>
<body <?php body_class(); ?>>
<?php woo_top(); ?>
<div id="wrapper">
        
	<?php woo_header_before(); ?>
    
	<div id="header" class="col-full">
 		
		<?php woo_header_inside(); ?>
       
		<div id="logo" width="900px">
				<img border="0" align="right" src="/wp-content/themes/canvas/images/icons/logoHW.png" alt="Logo" width="154" height="118">

		<?php
			// Website heading/logo and description text.
			if ( isset( $woo_options['woo_logo'] ) && ( '' != $woo_options['woo_logo'] ) ) {
				$logo_url = $woo_options['woo_logo'];
				if ( is_ssl() ) $logo_url = str_replace( 'http://', 'https://', $logo_url );

				echo '<a href="' . esc_url( $site_url ) . '" title="' . esc_attr( $site_description ) . '"><img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_title ) . '" /></a>' . "\n";
			} // End IF Statement
			
			echo '<' . $heading_tag . ' class="site-title"><a href="' . esc_url( $site_url ) . '">' . $site_title . '</a></' . $heading_tag . '>' . "\n";
			if ( $site_description ) { echo '<span class="site-description">' . $site_description . '</span>' . "\n"; }
		?>
		
		</div><!-- /#logo -->
	      
	    
       
	</div><!-- /#header -->
	<?php woo_header_after(); ?>