		<?php $front_callout_checkbox = get_post_meta($post->ID, 'front_callout_checkbox', true); ?>
		<?php $front_callout_layout = get_post_meta($post->ID, 'front_callout_layout', true); ?>
		<?php $front_callout_title = get_post_meta($post->ID, 'front_callout_title', true); ?>
		<?php $front_callout_content = get_post_meta($post->ID, 'front_callout_content', true); ?>
		<?php $front_callout_url = get_post_meta($post->ID, 'front_callout_url', true); ?>
		<?php $front_callout_bn_title = get_post_meta($post->ID, 'front_callout_bn_title', true); ?>
		<?php $front_callout_bn_content = get_post_meta($post->ID, 'front_callout_bn_content', true); ?>
		<?php $front_callout_product_callout = get_post_meta($post->ID, 'front_callout_product_callout', true); ?>
		
		<?php $front_callout_layout = get_post_meta($post->ID, 'front_callout_layout', true); 
			if($front_callout_layout=="2"){
				$callout_content="span6";
				$callout_button="span6";
			} elseif($front_callout_layout=="3"){
				$callout_content="span8";
				$callout_button="span4";
			} elseif($front_callout_layout=="4"){
				$callout_content="span9";
				$callout_button="span3";
			} else{
				$callout_content="span8";
				$callout_button="span4";
			}
		?>
		
		<?php if($front_callout_checkbox){ ?>
			<div id="callout" class="container">
				<div class="row-fluid">
					<div class="<?php echo $callout_content; ?> callout-content">
					<?php if($front_callout_product_callout){ ?>
						<?php if ( in_array( 'woocommerce/woocommerce.php' , get_option('active_plugins') ) ) {?>
							<?php $query = new WP_Query();
							$query->query('p='.$front_callout_product_callout.'&post_type=product');
							if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();?>
							<div class="clearfix product-callout">
								<?php if ( has_post_thumbnail() ) {?>
								<div class="product-callout-thumbnail">
									<a href="<?php the_permalink();?>"><?php echo $thumbnail = get_the_post_thumbnail( $post->ID, 'product-callout' );?></a>
								</div>
								<?php }?>
								<h3 class="title"><?php the_title(); ?></h3>
								<?php woocommerce_get_template( 'loop/price.php' );?>
								<?php if($front_callout_content){ ?>
								<div class="description visible-desktop grid_1170"><p>
									<?php
									if($front_callout_layout=="2"){ 
										$limit = 20;
										$limit1 = 15;
										$limit2 = 5;
									} elseif($front_callout_layout=="3"){
										$limit = 35;
										$limit1 = 20;
										$limit2 = 15;
									} elseif($front_callout_layout=="4"){
										$limit = 45;
										$limit1 = 30;
										$limit2 = 15;
									} else{
										$limit = 35;
										$limit1 = 20;
										$limit2 = 15;
									}
									
									$excerpt = explode(' ', $front_callout_content, $limit);
									if (count($excerpt)>=$limit) {
										array_pop($excerpt);
										$excerpt = implode(" ",$excerpt).' &#91;...&#93;';
									} else {
										$excerpt = implode(" ",$excerpt);
									}	
									echo $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
									?>
								</p></div>
								<div class="description visible-desktop grid_960"><p>
									<?php 
									$excerpt = explode(' ', $front_callout_content, $limit1);
									if (count($excerpt)>=$limit1) {
										array_pop($excerpt);
										$excerpt = implode(" ",$excerpt).' &#91;...&#93;';
									} else {
										$excerpt = implode(" ",$excerpt);
									}	
									echo $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
									?>
								</p></div>
								<div class="description hidden-desktop"><p>
									<?php 
									$excerpt = explode(' ', $front_callout_content, $limit2);
									if (count($excerpt)>=$limit2) {
										array_pop($excerpt);
										$excerpt = implode(" ",$excerpt).' &#91;...&#93;';
									} else {
										$excerpt = implode(" ",$excerpt);
									}	
									echo $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
									?>
								</p></div>
								<?php } ?>
							</div>
							<?php endwhile; endif; wp_reset_query();?>
						<?php } else{ ?>
							<p style="color: #ed1c24;"><?php _e('"WooCommerce" plugin must be activated.', GETTEXT_DOMAIN); ?></p>
						<?php } ?>
					<?php } else{ ?>
						<?php if($front_callout_title){ ?><h3 class="title"><?php echo $front_callout_title; ?></h3><?php } ?>
						<?php if($front_callout_content){ ?>
						<div class="description visible-desktop grid_1170"><p>
							<?php
							if($front_callout_layout=="2"){ 
								$limit = 50;
								$limit1 = 40;
								$limit2 = 25;
							} elseif($front_callout_layout=="3"){
								$limit = 70;
								$limit1 = 60;
								$limit2 = 40;
							} elseif($front_callout_layout=="4"){
								$limit = 80;
								$limit1 = 70;
								$limit2 = 50;
							} else{
								$limit = 70;
								$limit1 = 60;
								$limit2 = 40;
							}
							
							$excerpt = explode(' ', $front_callout_content, $limit);
							if (count($excerpt)>=$limit) {
								array_pop($excerpt);
								$excerpt = implode(" ",$excerpt).' &#91;...&#93;';
							} else {
								$excerpt = implode(" ",$excerpt);
							}	
							echo $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
							?>
						</p></div>
						<div class="description visible-desktop grid_960"><p>
							<?php 
							$excerpt = explode(' ', $front_callout_content, $limit1);
							if (count($excerpt)>=$limit1) {
								array_pop($excerpt);
								$excerpt = implode(" ",$excerpt).' &#91;...&#93;';
							} else {
								$excerpt = implode(" ",$excerpt);
							}	
							echo $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
							?>
						</p></div>
						<div class="description hidden-desktop"><p>
							<?php 
							$excerpt = explode(' ', $front_callout_content, $limit2);
							if (count($excerpt)>=$limit2) {
								array_pop($excerpt);
								$excerpt = implode(" ",$excerpt).' &#91;...&#93;';
							} else {
								$excerpt = implode(" ",$excerpt);
							}	
							echo $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
							?>
						</p></div>
						<?php } ?>
					<?php } ?>
					</div>
					<div class="<?php echo $callout_button; ?> callout-button"><a href="<?php if($front_callout_url){ ?><?php echo $front_callout_url; ?><?php } else{?>#<?php } ?>" class="button-border" title="<?php echo $front_callout_bn_title; ?>"><?php if($front_callout_bn_title){ ?><span class="title <?php if(!$front_callout_bn_content){ ?>no-description<?php } ?>"><?php echo $front_callout_bn_title; ?></span><?php } ?><?php if($front_callout_bn_content){ ?><span class="description"><?php echo $front_callout_bn_content; ?></span><?php } ?></a></div>
				</div>
			</div>
		<?php } ?>