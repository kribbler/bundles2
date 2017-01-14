<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<?php get_sidebar();?>

<div class="innerContent">
<!-- ************************************************************* -->
		<div class="story">
            <h2>Archives by Month:</h2>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>
            
            <h2>Archives by Subject:</h2>
                <ul>
                     <?php wp_list_categories(); ?>
                </ul>
    	</div>


</div><!-- close innerContent -->
<?php include (TEMPLATEPATH . "/right_sidebar.php"); ?>
<?php get_footer(); ?>