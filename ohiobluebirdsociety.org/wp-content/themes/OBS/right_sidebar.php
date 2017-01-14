<div class="right_sidebar">

<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FOhio-Bluebird-Society%2F147503035273304&amp;width=250&amp;colorscheme=light&amp;show_faces=false&amp;stream=false&amp;header=false&amp;height=70" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:70px;" allowTransparency="true"></iframe>

<!-- Sidebar List ************************************************************* -->



    



                    <ul>



                    		   <li>



                                            <p><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/join_btn.jpg" alt="Join Today!" /></a></p>



                                </li>

                                

                                <li>



                                            <h3><?php _e('Upcoming Events'); ?></h3>



                                        	<ul><?php SidebarEventsList();?></ul>



                                </li>



								<?php 	/* Widgetized sidebar, if you have the plugin installed. */ 

        

                                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('right_sidebar') ) : ?>

        

                                

                                <?php endif; ?>

                               <li style="margin-top:17px;"><?php if (function_exists('sidebarlogin')) sidebarlogin(); ?></li>



                               <li style="margin-top:17px;"><a href="http://www.ohiobluebirdsociety.org/wp-content/uploads/2010/06/Bluebird.mp3"><img src="http://www.ohiobluebirdsociety.org/wp-content/uploads/2010/06/bluebirdsonggraphic.jpg" alt="Join Today!" /></a></li>



                    </ul>



<!-- Close Sidebar List ************************************************************* -->



</div><!-- close sidebar -->