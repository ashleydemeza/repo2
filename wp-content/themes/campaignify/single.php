<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

get_header(); ?>

	<header class="page-header arrowed">
		<h1 class="page-title"><a href="<?php echo esc_url( get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url() ); ?>"><?php echo get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : _x( 'Blog', 'blog page title', 'campaignify' ); ?></a></h1>
	</header>

	<div class="container">
		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

					<?php $author = get_user_by( 'id', $post->post_author ); ?>	
					<aside class="author-bio">
						<div class="author-avatar">
							<?php echo get_avatar( $author->user_email, 120 ); ?>
						</div>

						<div class="author-info">
							<h3 class="post-author"><?php printf( __( 'Written by %s', 'campaignify' ), get_the_author() ); ?></h3>
							<?php echo wpautop( get_the_author_meta( 'description' ) ); ?>

							<ul class="author-bio-links">
								<?php
									$methods = _wp_get_user_contactmethods();

									foreach ( $methods as $key => $method ) :
										if ( '' == $author->$key )
											continue;
								?>
									<li class="contact-<?php echo $key; ?>"><a href="<?php echo esc_url( $author->$key ); ?>"><i class="icon-<?php echo $key; ?>"></i> <?php if ( $key == 'twitter' ) : ?>@<?php endif; ?><?php echo campaignify_username_from_url( $author->$key ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</aside>

					<h2 class="single-comments-title"><?php _e( 'Leave a Comment', 'campaignify' ); ?></h2>

					<?php comments_template(); ?>
					
				<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>