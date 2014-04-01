<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * form. The actual display of comments is handled by a callback to
 * twentythirteen_comment() which is located in the functions.php file.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

global $campaign, $post;

if ( is_object( $campaign ) )
	$post = get_post( $campaign->ID );

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php if ( comments_open() ) : ?>
	<h2 class="comments-title">
		<?php
			printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'campaignify' ), get_comments_number() );
		?>
	</h2>

	<ol class="comment-list">
		<?php 
			wp_list_comments( 
				array( 
					'callback' => 'campaignify_comment', 
					'style' => 'ol' 
				), 
				get_comments( array( 
					'post_id' => is_object( $campaign ) ? $campaign->ID : get_the_ID() 
				) )
			); 
		?>
	</ol><!-- .comment-list -->

	<?php
		// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'campaignify' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'campaignify' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'campaignify' ) ); ?></div>
	</nav>
	<?php endif; // Check for comment navigation ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.' , 'campaignify' ); ?></p>
	<?php endif; ?>

	<?php 
		comment_form( array(
			'comment_notes_after' => '',
			'comment_notes_before' => ''
		), is_object( $campaign ) ? $campaign->ID : get_the_ID() ); 
	?>

</div><!-- #comments -->