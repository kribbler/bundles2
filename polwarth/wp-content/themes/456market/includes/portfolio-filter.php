<?php $filter = get_post_meta($post->ID, 'portfolio_filter_text', true);?>
<div class="row-fluid">
	<div class="span12">
	    <div id="options" class="clearfix">
	        <?php $filter_slugs = explode(",", $filter);
	        foreach($filter_slugs as $filter_slug){
	             $filter_id .= $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE slug='$filter_slug'").',';
	        }?>
	        <ul id="filters" class="option-set clearfix" data-option-key="filter">
	            <li><a href="#filter" data-option-value="*" title="<?php _e( 'All Categories', GETTEXT_DOMAIN);?>" class="selected"><?php _e( 'All Categories', GETTEXT_DOMAIN);?></a></li>
				<?php if($filter){?>
	                <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'portfolio_category', 'include' => $filter_id, 'walker' => new portfolio_filter_walker())); ?>
			    <?php }else{?>
	                <?php wp_list_categories(array('title_li' => '', 'taxonomy' => 'portfolio_category', 'walker' => new portfolio_filter_walker())); ?>
	            <?php }?>
	        </ul>
	    </div>
	</div>
</div>