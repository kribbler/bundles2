<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-2">
							<img src="<?php echo get_stylesheet_directory_uri().'/images/logo_footer.png';?>" alt="<?php echo esc_attr(get_bloginfo('sitename'));?>" class="logo">
						</div>
						<div class="col-lg-10">
							<div class="container-fluid">
							<div class="row">
							<?php
								if(has_nav_menu('footer-nav')){
									wp_nav_menu(array(
										'theme_location' => 'footer-nav',
										'container' => '',
										'menu_class' => 'footer_menu',
										'menu_id' => 'navigation',
										'depth' => 3,
									));
								}
							?>
							</div>

							<div class="row align_right">
								<?php dynamic_sidebar( 'footer-social' ); ?>
							</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<?php dynamic_sidebar( 'footer' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php
wp_footer();
?>
</body>
</html>