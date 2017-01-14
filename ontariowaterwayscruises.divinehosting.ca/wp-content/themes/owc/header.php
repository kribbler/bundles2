<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title(); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<header id="header-banner">
			<div class="container" id="menu_desktop">
				<div class="row">
					<div class="col-lg-12">
						<div class="container-fluid">
							<div class="col-lg-2">
								<a href="<?php echo site_url();?>"><img src="<?php echo get_stylesheet_directory_uri().'/images/logo.png';?>" alt="<?php echo esc_attr(get_bloginfo('sitename'));?>" class="logo"></a>
							</div>
							<div class="col-lg-10 move_top_20">
								<div class="row">
									<div class="col-lg-9">
										<?php
											if(has_nav_menu('header-nav')){
												wp_nav_menu(array(
													'theme_location' => 'header-nav',
													'container' => '',
													'menu_class' => 'header_menu',
													'menu_id' => 'navigation',
													'depth' => 3,
												));
											}
										?>
									</div>
									<div class="col-lg-3">
										<?php dynamic_sidebar( 'header-top-right' ); ?>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<nav><?php
											if(has_nav_menu('primary-nav')){
												wp_nav_menu(array(
													'theme_location' => 'primary-nav',
													'container' => '',
													'menu_class' => 'primary_menu',
													'menu_id' => 'menu-main-navigation',
													'depth' => 3,
													'walker' => new Et_Navigation
												));
											}
										?></nav>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<?php
											if(has_nav_menu('subheader-nav')){
												wp_nav_menu(array(
													'theme_location' => 'subheader-nav',
													'container' => '',
													'menu_class' => 'subheader_menu',
													'menu_id' => 'sub_navigation',
													'depth' => 3,
													'after' => '<li class="menu-divider">|</li>'
												));
											}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="container-fluid" id="menu_tablet">
				<div class="row">
					<div class="col-lg-12">
						<div class="container-fluid">
							<div class="col-lg-2">
								<a href="<?php echo site_url();?>"><img src="<?php echo get_stylesheet_directory_uri().'/images/logo.png';?>" alt="<?php echo esc_attr(get_bloginfo('sitename'));?>" class="logo"></a>
							</div>

							<div class="col-lg-10 move_top_20">
								<div class="row">
									<div class="col-lg-9">
										<?php
											if(has_nav_menu('header-nav')){
												wp_nav_menu(array(
													'theme_location' => 'header-nav',
													'container' => '',
													'menu_class' => 'header_menu',
													'menu_id' => 'navigation',
													'depth' => 3,
												));
											}
										?>
									</div>
									<div class="col-lg-3">
										<?php dynamic_sidebar( 'header-top-right' ); ?>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<nav><?php
											if(has_nav_menu('primary-nav')){
												wp_nav_menu(array(
													'theme_location' => 'primary-nav',
													'container' => '',
													'menu_class' => 'primary_menu',
													'menu_id' => 'menu-main-navigation',
													'depth' => 3,
													'walker' => new Et_Navigation
												));
											}
										?></nav>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<?php
											if(has_nav_menu('subheader-nav')){
												wp_nav_menu(array(
													'theme_location' => 'subheader-nav',
													'container' => '',
													'menu_class' => 'subheader_menu',
													'menu_id' => 'sub_navigation',
													'depth' => 3,
													'after' => '<li class="menu-divider">|</li>'
												));
											}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="container-fluid" id="menu_phone">
				<div class="row">
					<div class="span3">
						<a href="<?php echo site_url();?>">
							<img src="<?php echo get_stylesheet_directory_uri().'/images/logo-mobile.png';?>" alt="<?php echo esc_attr(get_bloginfo('sitename'));?>" class="logo">
						</a>
					</div>

					<div class="span5">
						<span id="activate_mobile_menu">MENU</span>
						<div id="mobile_menu_holder">
							<div id="mobile_close"></div>
							<?php
							if(has_nav_menu('mobile-menu')){
								wp_nav_menu(array(
									'theme_location' => 'mobile-menu',
									'container' => '',
									'menu_class' => 'mobile_menu',
									'menu_id' => 'mobile-menu',
									'depth' => 3,
								));
							}
							?>
						</div>
					</div>

					<div class="span4">
						<?php dynamic_sidebar( 'header-top-right-mobile' ); ?>
					</div>
				</div>
			</div>
		</header>