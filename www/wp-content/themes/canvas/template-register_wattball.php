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
				if(!empty($_POST) && empty($_POST['name1'] )){
					if($_POST['no_mem'] == null || $_POST['no_mem'] == '0')
					{
						 echo 'You have 0 Members in your team go back to fix it.';
						 die();
					}
					$str = array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','Ninth','Tenth','Eleventh','Twelfth','Thirteenth','Fourteenth','Fifteenth','Sixteenth','Seventeenth','Eighteenth','Nineteenth','Twentieth');
					$no  = 0;
					echo "<h4> Please fill in your team members details below. </h4> <br /> 
					<div class='scroll'>
					<form method='POST' action='/register/register-wattball-team/' >
					<table >";
					while($no < $_POST['no_mem'])
					{
						if($no%2==0)echo "<tr>";
						echo "<td class='padding'>";
							echo '<h5> Your '.$str[$no].' Players Details </h5>
							<table>
							<tr> <td><p> Name </td><td><input name="name'.$no.'" type="text" /> </p><td> </tr>
							<tr> <td><p> Surname </td><td><input name="surname'.$no.'" type="text" /></p><td> </tr>
							<tr> <td><p> Email Address </td><td><input name="email'.$no.'" type="text" /></p> <td> </tr>
							<tr> <td><p> Address </td><td><input name="address'.$no.'" type="text" /></p><td> </tr>
							<tr> <td><p> Phone Number </td><td><input name="phone'.$no.'" type="text" /></p><td> </tr>
							<tr> <td><p> Date of Birth </td><td><input name="dob'.$no.'" type="text" /></p><td> </tr>
							<tr> <td><p> Position </td><td><select name="position'.$no.'" > <option value="GoalKeeper">GoalKeeper</option><option value="Defender">Defender</option><option value="Midfielder">Midfielder</option><option value="Forward">Forward</option></select>
							<tr> <td><p> Shirt Number </td><td><input name="shirt'.$no.'" type="text" /></p><td> </tr>
							</table>
							<hr /></td>';
							if($no%2)echo "</tr>";
							$no++;
					}
					echo "<tr><td>Select your teams captain: </td><td> <select name='captain'>";
					$no =0;
					while($no < $_POST['no_mem'])
					{
					echo '<option value="'.$no.'">Player '.($no+1).'</option>';
					$no++;
					}
					echo"</select></td></tr>";
					echo "</table>
					<input type='hidden'name='team_name' value='".$_POST['team_name']."' />
					<input type='hidden'name='mgr_name' value='".$_POST['mgr_name']."' />
					<input type='hidden'name='mgr_surname' value='".$_POST['mgr_surname']."' />
					<input type='hidden'name='no_mem' value='".$_POST['no_mem']."' />
					<input type='hidden'name='assoc' value='".$_POST['associd']."' />
					<input type='hidden'name='address' value='".$_POST['address']."' />
					<input type='hidden'name='email' value='".$_POST['email']."' />
					<input type='hidden'name='badge' value='".$_POST['badge']."' />
					<input type='submit' title='Submit' />
					</form></div>";
				}
				
				elseif(!empty($_POST) && !empty($_POST['name0'] )){
					$no = 0;
					$no_mem = $_POST['no_mem'];

					$mgr_name = $_POST['mgr_name'];
					$mgr_surname = $_POST['mgr_surname'];
					 $team_name = $_POST['team_name'];
					 $no_mem = $_POST['no_mem'];
					 $assoc = $_POST['assoc'];
					 $addre = $_POST['address'];
					 $email = $_POST['email'];
					 $captain = $_POST['captain'];
					 $badge = $_POST['badge'];
					 echo 	$mgr_name.
					$mgr_surname .
					 $team_name.
					 $no_mem .
					 $assoc .
					 $addre .
					 $email .
					 $captain .
					 $badge;

					 while( $no < $no_mem){
						
						${'mem'.$no} = array( $_POST['name'.$no],$_POST['surname'.$no],$_POST['address'.$no],$_POST['dob'.$no],$_POST['phone'.$no],$_POST['email'.$no],$_POST['position'.$no],$_POST['shirt'.$no]);
						$qu2 = "INSERT INTO `wattball_team_members` VALUES('','".${'mem'.$no}['0']."','".${'mem'.$no}['1']."','".${'mem'.$no}['2']."','".${'mem'.$no}['3']."','".${'mem'.$no}['4']."','".${'mem'.$no}['5']."','".${'mem'.$no}['6']."','".${'mem'.$no}['7']."','$assoc')"; 
						echo "<br />".$qu2."<br />";
						mysql_query($qu2);
						$no++;
					}
					$qu3 ="	Select `member_id` 
							FROM `wattball_team_members`
							WHERE (`name` = '".${'mem'.$captain}['0']."') 
							AND (`surname` = '".${'mem'.$captain}['1']."')
							AND (`address` = '".${'mem'.$captain}['2']."') 
							AND (`dob` = '".${'mem'.$captain}['3']."') 
							AND (`phone` = '".${'mem'.$captain}['4']."') 
							AND (`position` = '".${'mem'.$captain}['6']."') "; 
					
					//echo $qu3 ;
					$results = mysql_query($qu3);
					$values = mysql_fetch_array($results);
					 //echo $values['member_id'];
					 
					 $qu = "INSERT INTO `wattball_team` VALUES('$assoc','$team_name','$mgr_name','$mgr_surname','$email','$addre','$values[member_id]','$badge')";
					echo $qu.'<br />';
					mysql_query($qu);
					echo "<script> alert('You have Successfully Registered your Team Thank you.'); </script>";
					
						$to      = $email; 
					$subject = 'Registration Complete';
					$message = 'Thank you for Registering to Wattsports for the hurdling event.';
					$headers = 'From: registration@wattsports.co.uk';

					 if (mail($to, $subject, $message, $headers)) {
					   echo("<p>Message successfully sent!</p>");
					  } else {
					   echo("<p>Message delivery failed...</p>");
					  }
					
				}
				else{ 
				echo'

                    <div>
						<h3>To register fill out the required information below.</h3>
					</div>
					<div>
						<br />
						<table>
						<form  method="POST" action="/register/register-wattball-team/">
						
						<tr><p><td> Team Name </td><td><input name="team_name" type="text" /></td></p></tr>
						<tr><p><td> Managers Name </td><td><input name="mgr_name" type="text" /></td></p></tr>
						<tr><p><td> Managers Surname </td><td><input name="mgr_surname" type="text" /></td></p></tr>
						<tr><p><td> WattBall Association ID </td><td><input name="associd" type="text" /></td></p></tr>
						<tr><p><td> Email Address </td><td><input name="email" type="text" /></td></p> </tr>
						<tr><p><td> Address </td><td><input name="address" type="text" /></td></p></tr>
						<tr><p><td> Number of Members </td><td><select name="no_mem" > <option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option> </select></td></p></tr>
						<tr><p><td> Badge URL </td><td><input name="badge" type="text" /></td></p></tr>
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