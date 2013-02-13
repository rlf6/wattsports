<?php
/**
 * Template Name: Register Hurdler
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
		
		<!-- #main Starts -->
		<?php woo_main_before(); ?>
		<div id="main">
    
		<?php woo_loop_before(); ?>
		<!-- Post Starts -->
		<?php woo_post_before(); ?>

            <div id="contact-page" class="page">
            
            <?php woo_post_inside_before(); ?>
            
            <h1 class="title"><?php the_title(); ?></h1>

			<?
				if(!empty($_POST) && !empty($_POST['hurdler_name'] )){
					$previous_best = $_POST['mins'] + $_POST['secs'] + $_POST['milli'];
					//echo $previous_best;
					$qu = "INSERT INTO `hurdler` VALUES('','$_POST[hurdler_name]','$_POST[hurdler_surname]','$_POST[hurdler_address]','$_POST[hurdler_phone]','$_POST[hurdler_email]','$_POST[hurdler_dob]','$_POST[hurdler_sex]','$previous_best')";
					
					mysql_query($qu);
					echo "<script> alert('You have Successfully Registered. Thank you.'); </script>";
					echo "Registration is Complete you should receive an email shortly. Thank you.";
					
					$to      = $_POST['hurdler_email'];
					$subject = 'Registration Complete';
					$message = 'Thank you for Registering to Wattsports for the hurdling event.';
					mail('mr177@hw.ac.uk', 'My Subject', $message);
					mail($to, $subject, $message);
					echo mail($to, $subject, $message);
				}
			
				else{ 
				echo'
						<script>
						function validateDate( input )
						{
							var bits = input.split( "-" );
							var phpdate = new Date( bits[0], --bits[1], bits[2] );
							if( phpdate.getFullYear( ) == bits[0] && phpdate.getMonth( ) == bits[1] )
							{
								return true;
							}
							return false;
						}

						function validateForm( form )
						{
							if( !validateDate( form.hurdler_dob.value ) )
							{
								alert( "Invalid date of birth.\nFormat: YYYY-MM-DD" );
								return false;
								}

							return true;
						}
						</script>
                    <div>
						<h3>To register fill out the required information below.</h3>
					</div>
					<div>
						<br />
						<table>
						        <form  method="POST" onsubmit="return validateForm(this);" action="/register/register-hurdler/" >
								<tr><td> First Name</td><td><input name="hurdler_name" type="text" /></td><tr/>
								<tr><td> Surname </td><td><input name="hurdler_surname" type="text" /></td><tr/>
								<tr><td> Address </td><td><input name="hurdler_address" type="text" /></td><tr/>
								<tr><td> Phone </td><td><input name="hurdler_phone" type="text" /></td><tr/>
								<tr><td> Email </td><td><input name="hurdler_email" type="text" /></td><tr/>
								<tr><td> Date of Birth </td><td><input name="hurdler_dob" type="text" /></td><tr/>

								<tr><td>Sex </td><td><input name="hurdler_sex" type="radio" value="m" checked />Male</td><tr/>
								<tr><td></td><td><input name="hurdler_sex" type="radio" value="f" />Female</td><tr/>

								<tr><td>Previous Best </td><td>
								
								<select name=mins>'; for($x=0;$x < 20;$x++){echo"<option value =' "; echo $x*60; echo"'>$x</option>";} echo '</select>Minutes <select name=secs>'; for($x=0;$x < 60;$x++){echo"<option value =$x>$x</option>";} echo'</select>Seconds <select name=milli>'; for($x=0;$x < 1000;$x+=100){echo"<option value =0.$x>$x</option>";} echo'</select>Milliseconds 
								
								</td><tr/>
								<tr><td><input type="submit" title="submit" /></td><tr/>
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