<?php
/**
 * The template for displaying the contact page.
 *
 */

 /**
Template Name: contact
 */

get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="lastmess">
</div>
<div class="bodymid">
	<div class="stripetop">
		<div class="stripebot">
			<div class="container">
				<div class="mapdiv"></div>
				<div class="clear"></div>
					<div id="main">
						<div class="grid8 first">	
							<div id="content" role="main">	
								<h1 class="entry-title"><?php the_title(); ?></h1>
                                <div class="entry-content">
                                                                    <?php /*if ( is_active_sidebar( 'index-page' ) ) : ?>	
                                                     <div  class="contact-left" role="complementary">				
                                            <ul class="cnt-left">	
                                                <?php dynamic_sidebar( 'contact-page' ); ?>
                                            </ul>
                                             </div>
                                                <?php endif; */?>
									<?php the_content(); ?>
								</div>
							</div>
						</div>
						<div class="grid4">	
							<div id="content" role="main">	
								<div class="entry-content">
									<?php 
									if(isset($_POST['Submit'])){ //check if user submitted the contact form
									$error="";
									if($_POST['contact_name']=='')$error.=__( 'Name Required', 'wp-church' );
									$pass = check_email_address($_POST['contact_email']);
									if (!$pass)$error.=__( 'Email incorrect', 'wp-church' ) . '<br/>';
									if($_POST['contact_phone']=='')$error.=__( 'Phone number required', 'wp-church' ) . '<br/>';
									if($_POST['contact_comment']=='')$error.=__( 'Comment Required', 'wp-church' ) . '<br/>';
									$typeval = $_POST['contact_captcha'];
									if($typeval)$error.=__( 'Please do not fill the captcha field', 'wp-church' ) . '<br/>';
									
									if($error!=""){
									//if any errors skip mailing and display the errors for users.
									echo '<div class="newslError">' . $error . '</div>';
									}else{
									// get admin email from wordpress default options
									$to=get_option('admin_email');
									$subject=__( 'Contact form submitted re:', 'wp-church' ) . $_POST['contact_reason'];
									$body="\r\n " . __( 'Hi Admin', 'wp-church' ) ;
									$body.="\r\n" . __( 'You had an enquiry:', 'wp-church' ) ;
									$body.="\r\n " . __( 'Regarding:', 'wp-church' )  . "\t". $_POST['contact_reason'];
									$body.="\r\n " . __( 'Name: ', 'wp-church' )  . "\t".$_POST['contact_name'];
									$body.="\r\n " . __( 'Email: ', 'wp-church' )  . "\t".$_POST['contact_email'];
									$body.="\r\n " . __( 'Phone: ', 'wp-church' )  . "\t".$_POST['contact_phone'];
									$body.="\r\n " . __( 'Comment: ', 'wp-church' )  . "\r\n ".$_POST['contact_comment'];
									// wordpress default handy mail function
									wp_mail('sgac@bmts.com', $subject, $body);
									wp_mail('grahambland@bmts.com', $subject, $body);
									echo '<div class="newslSuccess">' . get_option('nets_contactsuccess') . '</div>';
									}
									}
					
									if (get_option('nets_disablecontact') != 'true'){
									?>
					
									<form id="custtypeform" name="contact_form" method="post" action="<?php echo the_permalink(); ?>">
										<h2><?php echo get_option('nets_contacthead'); ?></h2>
										<div class="contactblock">
<!--											<label><?php// _e( 'Name', 'wp-church' ); ?></label><br/>-->
                                                                                        <input type="text" onblur="if(this.value==''){ this.value='Name'; }" onfocus="if(this.value=='Name'){ this.value='' }" value="Name" name="contact_name"  id="contact_name"  class="text-input textbox palette3b" />      
											<div class="clear"></div>
<!--											<label><?php// _e( 'Email', 'wp-church' ); ?></label><br/>-->
                                                                                        <input type="text" onblur="if(this.value==''){ this.value='Email'; }" onfocus="if(this.value=='Email'){ this.value='' }" value="Email" name="contact_email" id="contact_email"  class="text-input textbox palette3b" />
											<div class="clear"></div>
<!--                                                                                        <label><?php //_e( 'Address Line1', 'wp-church' ); ?></label><br/>-->
                                                                                        <input type="text" onblur="if(this.value==''){ this.value='Address'; }" onfocus="if(this.value=='Address'){ this.value='' }" value="Address" name="address" id="contact_address" class="text-input textbox palette3b" />      
											<div class="clear"></div>
<!--                                                                                        <label><?php// _e( 'City', 'wp-church' ); ?></label><br/>-->
                                                                                        <input type="text" onblur="if(this.value==''){ this.value='City'; }" onfocus="if(this.value=='City'){ this.value='' }" value="City" name="city" id="city"  class="text-input textbox palette3b" />      
											<div class="clear"></div>
<!--											<label><?php// _e( 'Post Code', 'wp-church' ); ?></label><br/>-->
                                                                                        <div class="postcode">
                                                                                        <input type="text" onblur="if(this.value==''){ this.value='Postcode'; }" onfocus="if(this.value=='Postcode'){ this.value='' }" value="Postcode" name="postcode" id="postcode"  class="text-input textbox palette3b" />
                                                                                        </div>
<!--											<label><?php// _e( 'Phone Number', 'wp-church' ); ?></label><br/>-->
                                                                                        <div class="phnumber">
                                                                                        <input type="text" onblur="if(this.value==''){ this.value='Phone number'; }" onfocus="if(this.value=='Phone number'){ this.value='' }" value="Phone number" name="contact_phone" id="contact_phone"  class="text-input textbox palette3b" />
                                                                                        </div>
                                                                                        <div class="clear"></div>
											<div class="clear"></div>
											<label class="captcha"><?php _e( '4 + 7 do not answer this question', 'wp-church' ); ?></label><br/><input type="text" name="contact_captcha" class="captcha"  value="" class="text-input textbox palette3b" />
											<div class="clear"></div>
										</div>
										<div class="contactblock">
<!--											<label><?php //_e( 'Message', 'wp-church' ); ?></label><br/>-->
                                                                                        <textarea type="text" onblur="if(this.value==''){ this.value='Message'; }" onfocus="if(this.value=='Message'){ this.value='' }" name="contact_comment" id="contact_comment"  value="Message" class="text-input textbox palette3b"></textarea>
											<div class="clear"></div>
											<br/>
											<input id="submit" type="submit" id="submit_btn" name="Submit" value="<?php _e( 'Submit', 'wp-church' ); ?>">
										</div>
										<div class="clear"></div>
									</form>
									<?php } ?>
								</div>
								<?php endwhile; ?>
							</div>
						</div>
						<?php get_footer(); ?>
