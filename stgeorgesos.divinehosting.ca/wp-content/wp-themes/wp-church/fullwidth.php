<?php
/**
 * The template for displaying the contact page.
 *
 */

 /**
Template Name: fullwidth
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
						<div class="full">	
							<div id="content" role="main">	
								<h1 class="entry-title"><?php the_title(); ?></h1>
                                <div class="entry-content">
									<?php the_content(); ?>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
						<?php get_footer(); ?>
