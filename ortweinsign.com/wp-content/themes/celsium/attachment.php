<?php
/**
 * The template for displaying attachments.
 *
 
 */

get_header();
if ( have_posts() ) the_post();
?>

<section id="container">
	<section class="container">
        <!--breadcrumbs -->
        <div class="container breadcrumbs">
            <h1>Attachments</h1>
            <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp Attachments</div>
        </div>
	</section>
    <div class="container">
        <div class="row">
            <section id="page-sidebar" class="alignleft span9">
				<?php
				get_template_part( 'loop', 'attachment' );
				?>
            </section>
			<?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
