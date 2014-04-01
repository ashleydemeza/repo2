<?php
/**
 * Template tags called directly in template files.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

if ( ! function_exists( 'campaignify_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own campaignify_entry_date() to override in a child theme.
 *
 * @since Campaignify 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string
 */
function campaignify_entry_date( $echo = true ) {
	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><i class="icon-calendar"></i> <time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'campaignify' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'campaignify_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own campaignify_entry_meta() to override in a child theme.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_entry_meta() {
	global $wp_query;

	campaignify_entry_date();

	// Post author
	if ( 'post' == get_post_type() && ! ( is_archive() || is_search() ) ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author"><i class="icon-user"></i>  %3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'campaignify' ), get_the_author() ) ),
			get_the_author()
		);
	}

	if ( is_singular() ) {
		echo '<span class="leave-reply">';
		comments_popup_link( '<i class="icon-comment"></i>' . __( '0 Comments', 'campaignify' ), '<i class="icon-comment"></i>' . __( '1 Comment', 'campaignify' ), '<i class="icon-chat"></i>' . __( '% Comments', 'campaignify' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'brisk' ), '<span class="edit-link"><i class="icon-pencil"></i> ', '</span>' );
}
endif;

if ( ! function_exists( 'campaignify_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments
 * template simply create your own twentythirteen_comment(), and that function
 * will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param object $comment Comment to display.
 * @param array $args Optional args.
 * @param int $depth Depth of comment.
 * @return void
 */
function campaignify_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<p><?php _e( 'Pingback:', 'campaignify' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'campaignify' ), '<span class="ping-meta"><span class="edit-link">', '</span></span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
	?>
	<li id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 75 ); ?>
			</div><!-- .comment-author -->

			<header class="comment-meta">
				<span class="comment-author vcard"><cite class="fn"><?php comment_author_link(); ?></cite></span> 
				<?php echo _x( 'on', 'comment author "on" date', 'campaignify' ); ?>
				 <?php
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( _x( '%1$s at %2$s', 'on 1: date, 2: time', 'campaignify' ), get_comment_date(), get_comment_time() )
					);
					edit_comment_link( __( 'Edit', 'campaignify' ), '<span class="edit-link"><i class="icon-pencil"></i> ', '<span>' );

					comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'campaignify' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'campaignify' ); ?></p>
			<?php endif; ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // End comment_type check.
}
endif;

/**
 * Get a username from a URL. This is useful for Twitter, Facebook, etc.
 * The format is pretty limited to http://site.com/username/ where "username" 
 * will be the value returned.
 *
 * @since Campaignify 1.0
 *
 * @param string $url The URL to extract the username from.
 * @return string $username The found username.
 */
function campaignify_username_from_url( $url ) {
	$url = untrailingslashit( $url );
	$parts = explode( '/', $url );

	$username = end( $parts );

	return $username;
}