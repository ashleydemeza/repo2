<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

get_header(); ?>

	<?php the_post(); ?>
	<header class="page-header arrowed">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header>
	<?php rewind_posts(); ?>

	<div class="container">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>
					<?php comments_template(); ?>
					
				<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>