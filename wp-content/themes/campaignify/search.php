<?php
/**
 * Search
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

get_header(); ?>

	<header class="page-header arrowed">
		<h1 class="page-title"><?php printf( __( 'Search Results for %s', 'campaignify' ), get_search_query() ); ?></h1>
	</div>

	<div id="primary" class="content-area">
		<div id="content" class="site-content full" role="main">
			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</div><!-- #content -->

		<?php do_action( 'campaignify_loop_after' ); ?>	
	</div><!-- #primary -->

<?php get_footer(); ?>