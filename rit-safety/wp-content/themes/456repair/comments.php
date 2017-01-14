<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', GETTEXT_DOMAIN) ?></p>
	<?php
		return;
	}

/* Comments Tree
================================================== */

	if ( have_comments() ) : ?>
    
    <div class="comment" id="comments">                        
    
    <?php if ( ! empty($comments_by_type['comment']) ) :  ?>
    
    <h3 class="comment-title"><?php comments_number(__('No Comments', GETTEXT_DOMAIN), __('One Comment', GETTEXT_DOMAIN), __('% Comments', GETTEXT_DOMAIN));?></h3>
    
    <?php wp_list_comments('type=comment&style=div&callback=comment'); ?>
    
    <?php endif; ?>
	
	</div>
	<?php

/* No comments or closed comments
================================================== */
    if ('closed' == $post->comment_status ) :  ?>
    
    <p class="nocomments"><?php _e('Comments are now closed for this article.', GETTEXT_DOMAIN) ?></p>
    
    <?php endif; ?>
    
    <?php else :  ?>
    
    <?php if ('open' == $post->comment_status) : ?>
    
    <?php else : ?>
    
    <?php if (is_single()) { ?><p class="nocomments"><?php _e('Comments are closed.', GETTEXT_DOMAIN) ?></p><?php } ?>
    
    <?php endif; ?>
            
    <?php endif; ?>

    <?php $commenter = wp_get_current_commenter();
    
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields =  array(
        'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" class="form-control blur-text" placeholder="' . ($commenter['comment_author'] ? esc_attr($commenter['comment_author']) : __('Your Name', GETTEXT_DOMAIN)) . ( $req&&$commenter['comment_author'] ? '' : '*' ) .'" size="22" tabindex="1"' . $aria_req . ' /></p>',
        'email'  => '<p class="comment-form-email"><input id="email" name="email" type="text" class="form-control blur-text" placeholder="' . ($commenter['comment_author_email'] ? esc_attr($commenter['comment_author_email']) : __('Email', GETTEXT_DOMAIN)) . ( $req&&$commenter['comment_author_email'] ? '' : '*' ) .'" size="22" tabindex="1"' . $aria_req . ' /></p>',
    );
    $comments_args = array(
        'fields' =>  $fields,
        'comment_field'        => '<p><textarea name="comment" id="comment" class="form-control blur-text" cols="58" rows="8"  placeholder="'.__('Your Comment', GETTEXT_DOMAIN).'"></textarea>',
        'comment_notes_after'  => '',
        'id_form'              => 'commentform',
        'id_submit'            => 'submit',
        'title_reply'          => __( 'Leave a Comment', GETTEXT_DOMAIN),
        'title_reply_to'       => __( 'Leave a Comment to %s', GETTEXT_DOMAIN),
        'cancel_reply_link'    => __( 'Cancel reply', GETTEXT_DOMAIN),
        'label_submit'         => __( 'Submit Comment', GETTEXT_DOMAIN),
    );
    
    comment_form($comments_args); ?>