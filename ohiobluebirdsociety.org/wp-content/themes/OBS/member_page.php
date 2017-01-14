<?php

/*

Template Name: Members Page

*/

?>

<?php get_header();?>



<?php get_sidebar();?>





<div class="innerContent">



<!-- ************************************************************* -->



<?php if (have_posts()) :



		while (have_posts()) : the_post(); ?>



        



            <div class="postid" id="post-<?php the_ID(); ?>">



            



                <div class="story">



                	<h2><?php the_title(); ?></h2>

                   	<div class="storyContent">

                    

                    	<p>Interested in becoming a member or making a donation to Ohio Bluebird Society or just need to renew your membership? Please fill out the form below:</p>

                        <p><b>If you don't want to pay using <em>PayPal</em> sign up <a href="<?php bloginfo('url'); ?>/membership/member-form">here</a></b></p>
                        <p>Fields with an asterisk (*) are required.</p>
                        <div style="font-size:11px">Notice:  For the protection of our members, the Ohio Bluebird Society
(OBS) does not share personal information, i.e., names, addresses, phone numbers or e-mail addresses, with any other persons (including
members) or entities. This information is used for OBS administrative purposes only.
</div>

                        <?php the_content(); ?>



                  <div style="clear:both;"></div>



                        <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>



                   	</div>



               </div>



               



            </div><!-- close postid-->







	<?php endwhile; else: ?>



    



        <div class="error"><?php _e('Not found.'); ?></div>



        



<?php endif; ?>







	



<!-- ************************************************************* -->



</div><!-- close innerContent -->



<?php include (TEMPLATEPATH . "/right_sidebar.php"); ?>



<?php get_footer(); ?>