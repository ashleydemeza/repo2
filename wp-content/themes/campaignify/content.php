<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() && ! post_password_required() && ! campaignify_is_campaign_page() ) : ?>
	<div class="entry-thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'campaignify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail( is_singular() ? 'blog-inner' : 'post-thumbnail' ); ?></a>
	</div>
	<?php endif; ?>

	<?php if ( ! is_singular( 'page' ) || campaignify_is_campaign_page() ) : ?>
	<header class="entry-header">
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php else : ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'campaignify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<?php endif; // is_single() ?>
	</header><!-- .entry-header -->

	<div class="entry-meta">
		<?php campaignify_entry_meta(); ?>
	</div><!-- .entry-meta -->
	<?php endif; ?>

	<?php if ( ! is_singular() || campaignify_is_campaign_page() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>

		<a href="<?php the_permalink(); ?>#more-<?php the_ID(); ?>" title="<?php echo esc_attr( sprintf( __( 'Read more of %s', 'campaignify' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark" class="button button-small"><?php _e( 'Read More', 'campaignify' ); ?></a>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content(); ?>

		<?php the_tags( '<p class="entry-tags"><i class="icon-tag"></i> ' . __( 'Tags:', 'campaignify' ) . ' ', ', ', '</p>' ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'campaignify' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

		<?php if( function_exists( 'zilla_likes' ) && is_singular( 'post' ) ) zilla_likes(); ?>

		<?php if ( is_singular( 'post' ) ) : ?>
		<a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( sprintf( _x( '%1$s via %2$s', '1: Campaign title via 2: Campaign URL', 'campaignify' ), get_the_title(), get_permalink() ) ); ?>" class="tweet-this"><i class="icon-twitter"></i> <?php _e( 'Tweet', 'campaignify' ); ?></a>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</article><!-- #post -->