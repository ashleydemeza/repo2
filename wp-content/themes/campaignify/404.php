<?php
/**
 * 404
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

get_header(); ?>

	<header class="page-header arrowed">
		<h1 class="page-title"><?php printf( __( 'Not Found', 'campaignify' ), get_search_query() ); ?></h1>
	</div>

	<div id="primary" class="content-area">
		<div id="content" class="site-content full" role="main">
		<?php get_template_part( 'content', 'none' ); ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>