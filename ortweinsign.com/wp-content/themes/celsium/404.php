<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>

<section id="container">
		<section class="container">
            <!--breadcrumbs -->
            <div class="container breadcrumbs">
                <h1>PAGE NOT FOUND</h1>
                <!-- <div>You are here: &nbsp&nbsp<a href="<?php echo home_url(); ?>">Home</a> &nbsp/&nbsp Error 404 Page Not Found</div> -->
            </div>
		</section>
        <div class="container">
            <h2>We're Sorry!</h2>
			<p>The page you requested cannot be found at this time. Please try one of these pages instead. <br /><br /> <a href="http://ortweinsign.com">Home Page</a><br /> <a href="/contact-us">Contact Us</a><br /> <a href="/blog">Blog</a></p>
        </div>
</section>

<?php get_footer(); ?>