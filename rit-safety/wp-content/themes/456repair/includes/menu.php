<?php $sep_element= ot_get_option('sep_element');?>

			<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
			<div id="menuMega" class="menu3dmega<?php if (!$sep_element) { ?> new_sep_element<?php } ?>">
				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu-container', 'menu_id' => "", 'container' => '', 'walker' => new lpd_bootstrap_nav_menu_walker() ) ); ?>
			</div>
			<?php } else { ?>
			<div id="menuMega" class="menu3dmega<?php if (!$sep_element) { ?> new_sep_element<?php } ?>">
	            <ul class="menu-container">    
					<?php wp_list_pages( array('title_li' => '', 'menu_class' => '', 'walker' => new lpd_menu3dmega_list_pages_walker() )); ?>
				</ul>
			</div>
			<?php } ?>