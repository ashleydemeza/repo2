<?php
/**
 * Campaign Widget
 *
 * @since Campaignify 1.2
 */

global $post;

$campaign = atcf_get_campaign( $post->ID );

if ( campaignify_is_using_widget( 'widget_campaignify_hero_contribute' ) ) {
	$images  = campaignify_contribute_hero_ids( campaignify_item_meta( 'campaignify_slider', $campaign->ID ), $campaign->ID );
	$image   = wp_get_attachment_image_src( $images[0] );
} else {
	$images  = get_posts( array(
		'post_parent'    => $campaign->ID,
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'numberposts'    => 1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post__not_in'   => campaignify_contribute_hero_ids( campaignify_item_meta( 'campaignify_slider', $campaign->ID ) )
	) );

	$image   = wp_get_attachment_image_src( $images[0]->ID );
}

$percent = $campaign->percent_completed( 'raw' ) > 100 ? '100%' : $campaign->percent_completed();
?>

<div id="<?php bloginfo( 'name' ); ?>-widget-<?php echo $post->ID; ?>" class="campaign-widget-embed" style="background-image: url(<?php echo $image[0]; ?>);">

	<h1 class="campaign-widget-embed-title"><?php the_title(); ?></h1>

	<div class="donation-progress-bar">
		<div class="donation-progress<?php echo $percent == 100 ? ' gone' : ''; ?>" style="width: <?php echo $percent; ?>"></div>
	</div>

	<span class="donation-progress-percent"><?php printf( __( '%s Funded', 'campaignify' ), $campaign->percent_completed() ); ?></span>
	<?php if ( ! $campaign->is_endless() ) : ?>
	&nbsp;&nbsp;&nbsp;
	<span class="donation-progress-togo"><?php printf( __( '%s Days Left', 'campaignify' ), $campaign->days_remaining() ); ?></span>
	<?php endif; ?>

	<div class="donation-button">
		<a href="<?php the_permalink(); ?>" class="button button-primary button-small"><?php _e( 'Contribute', 'campaignify' ); ?></a>
	</div>
</div>