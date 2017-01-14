<?php
if ( get_the_author_meta( 'description' ) ) : ?>
<div id="authorinfo">
    <div id="authorimg">
		<?php
		$id_or_email = get_the_author_meta('user_email');
		echo get_avatar( $id_or_email, $size = '62' );
		?>
    </div>
    <div id="authordesc">
        <div class="authornms">
            <span><img src="<?php echo TEMPLATEURL.'/images/author.png'; ?>"/>About Author:&nbsp;</span><a href="<?php the_author_url(); ?>"><?php the_author_firstname(); ?> <?php the_author_lastname(); ?></a>
        </div>
        <div class="authorbio">  <?php the_author_description(); ?></div>
    </div>
</div>
<?php endif; ?>