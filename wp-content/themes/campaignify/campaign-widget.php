<?php
/**
 * Widget
 *
 * @since Campaignify 1.2
 */

global $post;
?><!DOCTYPE html>
<html lang="en" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content-campaign', 'widget' );
		endwhile;
	?>

	<?php wp_footer(); ?>
</body>
</html>