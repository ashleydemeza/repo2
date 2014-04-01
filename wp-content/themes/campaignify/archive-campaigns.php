<?php
/**
 * Campaign Archives
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

get_header(); ?>

	<header class="page-header arrowed">
		<h1 class="page-title"><?php printf( __( '%s Archives', 'campaignify' ), edd_get_label_singular() ); ?></h1>
	</div>

	<div class="container clear">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<h3 class="content-archive-title"><?php echo edd_get_label_plural(); ?></h3>

				<ul class="content-archive">
				<?php while ( have_posts() ) : the_post(); ?>

					<li><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'campaignify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></li>
					
				<?php endwhile; ?>
				</ul>

			</div><!-- #content -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>