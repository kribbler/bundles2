<div class="extra_wrap">
    <?php include(TEMPLATEPATH . '/inc/blog-info.php'); ?>
        <div class="img-box marg-bottom20">
			<?php if (has_post_thumbnail()) {
			  the_post_thumbnail('single');
			} ?> 
        </div>
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
        
</div>
