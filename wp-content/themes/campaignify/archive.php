<?php
/**
 * Archives
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

get_header(); ?>

	<header class="page-header arrowed">
		<h1 class="page-title">
			<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: %s', 'campaignify' ), '<span>' . get_the_date() . '</span>' ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: %s', 'campaignify' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'campaignify' ) ) . '</span>' ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: %s', 'campaignify' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'campaignify' ) ) . '</span>' ); ?>
			<?php elseif ( is_author() ) : ?>
				<?php the_post(); ?>
				<?php printf( __( 'Author: %s', 'campaignify' ), '<span class="vcard">' . get_the_author() ); ?>
				<?php rewind_posts(); ?>
			<?php else : ?>
				<?php _e( 'Blog Archives', 'campaignify' ); ?>
			<?php endif; ?>
		</h1>
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