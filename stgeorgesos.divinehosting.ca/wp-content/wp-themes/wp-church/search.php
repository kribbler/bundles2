<?php
/**
 * The template for displaying Category Archive pages.
 *
 */

get_header(); ?>


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
									<?php get_template_part( 'loop', 'category' ); ?>				
									<?php adminace_paging(); ?>
								</div>
							</div>
							<?php get_sidebar(); ?>
							<?php get_footer(); ?>
