<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">

		<header id="masthead" class="site-header" role="banner">
			<div class="container">
				<div class="site-header-main">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-branding">
						<?php $header_image = get_header_image(); ?>
						<hgroup>
							<h1 class="site-title">
								<?php if ( ! empty( $header_image ) ) : ?>
									<img src="<?php echo $header_image ?>" alt="" />
								<?php endif; ?>

								<span><?php bloginfo( 'name' ); ?></span>
							</h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						</hgroup>
					</a>

					<nav id="site-navigation" class="site-primary-navigation">
						<div class="topdonleft"><?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu-primary' ) ); ?></div>
						<div class="topdonright"><a href="http://www.firstgiving.com/fundraiser/darryl-nordquist/building-unity-campaign" class="button button-primary" target="_blank">Donate</a></div>
					</nav>

					<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<a href="#" class="primary-menu-toggle"><i class="icon-menu"></i></a>
					<?php endif; ?>
				</div>
			</div>
		</header><!-- #masthead -->

		<div id="main" class="site-main">
