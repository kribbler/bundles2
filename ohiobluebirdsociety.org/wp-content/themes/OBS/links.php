<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

/*
Template Name: Links
*/
?>

<?php get_header();?>
<?php get_sidebar();?>

<div class="innerContent">
<ul>
<?php wp_list_bookmarks(); ?>
</ul>

<!-- ************************************************************* -->
</div><!-- close innerContent -->
<?php include (TEMPLATEPATH . "/right_sidebar.php"); ?>
<?php get_footer(); ?>