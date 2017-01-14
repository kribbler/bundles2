                    <div class="comments">
						<?php
                                if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
                                        die ('Please do not load this page directly. Thanks!');
                                if ( post_password_required() ) { ?>
                                        This post is password protected. Enter the password to view comments.
                                <?php
                                        return;
                                }
                        ?>   
                        <?php if ( have_comments() ) : ?>
                        <!--comments-->
                        <div class="title-divider">
                            <h3><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h3>
                        </div>
						<div class="comments">
                            <ul class="comments-list">
								<?php wp_list_comments('type=comment&callback=afl_comment'); ?>
							</ul>
						</div>
						<div class="navigation">
								<div class="next-posts pull-left"><?php previous_comments_link() ?></div>
								<div class="prev-posts pull-right"><?php next_comments_link() ?></div>
						</div>
                        <hr />
                         <?php else : // this is displayed if there are no comments so far ?>
                            <?php if ( comments_open() && get_option('default_comment_status') == 'open') : ?>
                                        <!-- If comments are open, but there are no comments. -->
                                <?php else : // comments are closed ?>
                                    <p>Comments are closed.</p>
                                <?php endif; ?>
                        <?php endif; ?>
                        <?php if ( comments_open() && get_option('default_comment_status') == 'open' ) : ?>
                        <!--commetns form-->
                        <div class="title-divider">
                            <h3><?php comment_form_title( 'Leave Your Comment', 'Leave a Reply to %s' ); ?></h3>
                        </div>
                        <?php cancel_comment_reply_link(); ?>

                                <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
                                        <p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
                                <?php else : ?>
                                <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="af-form-comment" name="comment" class="af-form">
                                        <?php if ( is_user_logged_in() ) : ?>
                                                <p class="loggedin">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
                                        <?php else : ?>
												<div class="af-outer af-required">
													<div class="af-inner">
														<label for="author" id="author_label">Your Name:</label>
														<input type="text" name="author" id="author" size="30" class="text-input input-xlarge" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
													</div>
												</div>
												<div class="af-outer af-required">
													<div class="af-inner">
														<label for="email" id="email_label">Your Email:</label>
														<input type="text" name="email" id="email" size="30" class="text-input input-xlarge" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
													</div>
												</div>
												<div class="af-outer">
													<div class="af-inner">
														<label for="url" id="url_label">Your Website URL:</label>
														<input type="text" name="url" id="url" size="30" class="text-input input-xlarge" tabindex="3" <?php if ($req) echo "aria-required='true'"; ?> />
													</div>
												</div>
                                        <?php endif; ?>
												<div class="af-outer af-required">
													<div class="af-inner">
														<label for="comment" id="comment_label">Your Comment:</label>
														<textarea name="comment" id="comment" cols="30" class="text-input" tabindex="4"></textarea>
													</div>
												</div>
												<div class="af-outer af-required">
													<div class="af-inner">
														<input type="submit" name="submit" class="form-button btn" id="submit_btn" value="Submit Comment!" />
													</div>
												</div>
                                        <!--<p>You can use these tags: <code><?php echo allowed_tags(); ?></code></p>-->
										<?php comment_id_fields(); ?>
                                        <?php do_action('comment_form', $post->ID); ?>
                                </form>
								<script type="text/javascript">
									$(document).ready(function(){
										$("#af-form-comment").validate({
											submitHandler: function(form) {
												$(form).submit();
											},
											rules: {
												author: "required",
												email: {
													required: true,
													email: true
												},
												comment: "required"
											},
											messages: {
												author: "Please specify your name",
												email: {
													required: "We need your email address",
													email: "Your email address must be in the format of name@domain.com"
												},
												comment: "Enter your comment!"
											}
										});
									});
								</script>
                                <?php endif; // If registration required and not logged in ?>
    					 <?php else : ?>
                        <?php endif; ?>
                    </div>
