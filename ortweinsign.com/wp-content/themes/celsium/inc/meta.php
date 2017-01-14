<div class="extra_wrap">
    <figure class="img-indent">
    	<?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');?>
        <?php if (has_post_thumbnail()) { ?>
          <a href="<?php echo $src[0] ?>" rel="prettyPhoto"><?php the_post_thumbnail('portfolio_one_column'); ?></a>
       <?php } ?> 
        <?php
            $posttags = get_the_tags();
            $tag_text="";
            $tag_link="";
            if ($posttags) {
                foreach($posttags as $tag) {
                    $tag_text = $tag->name;
                    $tag_id = $tag->term_id;
                }
            }
            
        ?>
    </figure>
    <h2 class="top25"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    
        
</div>
