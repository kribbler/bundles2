<div class="sideBar">



<!-- Sidebar List ************************************************************* -->


    


                    <ul>


						<?php 	/* Widgetized sidebar, if you have the plugin installed. */ 


                        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar') ) : ?>


                        


                         <!-- ************************************************************* -->


                                <li>


                                            <ul><?php wp_list_categories("title_li=");?></ul>


                                </li>


                         <!-- ************************************************************* -->


                                <li>


                                            <h3><?php _e('Archives'); ?></h3>


                                        	<ul><?php wp_get_archives('type=monthly'); ?></ul>


                                </li>


                         <!-- ************************************************************* -->


                                <li>


                                            <h3><?php _e('Blogroll'); ?></h3>


                                        	<ul><?php get_links('-1', '<li>', '</li>', '<br />', 'Name'); ?></ul>


                                </li>


                         <!-- ************************************************************* -->


                                <li>


                                            <h3><?php _e('Meta'); ?></h3>


                                            <ul>


                                             <?php wp_register(); ?>


                                                <li><?php wp_loginout(); ?></li>


                                                <li><a href="<?php bloginfo('rss2_url'); ?>">Entries RSS</a></li>


                                                <li><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments RSS</a></li>


                                                <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid 


                                                  <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>


                                                <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>


                                                <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>


                                             <?php wp_meta(); ?>


                                            </ul>


                                </li>


                         <!-- ************************************************************* -->


                        <?php endif; ?>


                    </ul>


<!-- Close Sidebar List ************************************************************* -->


</div><!-- close sidebar -->