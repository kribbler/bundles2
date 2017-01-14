<ul class="meta">
    <li><?php $year = get_the_time( 'Y', $post->ID );$month = get_the_time( 'm', $post->ID );$day = get_the_time( 'd', $post->ID ); echo get_the_date('F j, Y'); ?></li>
    <li>By: <?php  the_author_posts_link(); ?></li>
    <li>Comments: <?php comments_popup_link ('0', '1', '%'); ?></li>
    <li>Posted in: <?php the_category(' | ');?></li>
</ul>