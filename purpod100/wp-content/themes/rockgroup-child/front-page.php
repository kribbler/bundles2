<?php
/*
Template Name: Blog streampage
*/
get_header(); 

while ( have_posts() ) : the_post(); 

endwhile;

get_footer();
