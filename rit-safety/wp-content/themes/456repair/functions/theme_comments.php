<?php
function comment($comment, $args, $depth) {

    $GLOBALS['comment'] = $comment; ?>
    <div class="comment-container">
        <div class="comment-post" <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
            <div class="avatar"><?php echo get_avatar($comment,$size='54'); ?></div>
	        <div class="author">
	            <div class="comment-author"><?php comment_author();?></div>
	            <div class="comment-info"><u>posted on <?php echo get_comment_date()?></u> <?php edit_comment_link(__('Edit', GETTEXT_DOMAIN),'','') ?> <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
	            <?php if ($comment->comment_approved == '0') : ?>
	            <p class="comment-content"><em class="moderation"><?php _e('Your comment is awaiting moderation.', GETTEXT_DOMAIN) ?></em></p>
	            <?php endif; ?>
	            <div class="comment-content"><?php comment_text() ?></div>
	        </div>
	       <div class=" clearfix"></div>        
    </div>
<?php }?>