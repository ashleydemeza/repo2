<?php
/**
 * Campaignify Widget: Gallery
 *
 * Display a stacked grid of all images attached to the campaign.
 *
 * Also has the ability to set a title, description, limit the initial amount shown.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Gallery_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Gallery_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_gallery', 
			'description' => __( 'Display all images attached to the current campaign.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_gallery', __( 'Campaign Gallery', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_gallery';
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes its output
	 **/
	function widget( $args, $instance ) {
		global $campaign;

		ob_start();
		extract( $args, EXTR_SKIP );

		if ( ! isset ( $instance[ 'limit' ] ) )
			$instance[ 'limit' ] = 8;

		$title       = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? __( 'Gallery', 'campaignify' ) : $instance[ 'title' ], $instance, $this->id_base);
		$description = $instance[ 'description' ];
		$images      = get_posts( array(
			'post_parent'    => $campaign->ID,
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'nopaging'       => true,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post__not_in'   => campaignify_contribute_hero_ids( campaignify_item_meta( 'campaignify_slider', $campaign->ID ) )
		) );
		$count       = 0;

		echo $before_widget;
?>
		<div class="container">
			<?php
				if ( '' != $title ) {
					echo $before_title;
					echo $title;
					echo $after_title;
				}
			?>

			<?php if ( '' != $description ) :  ?>
			<div class="campaign-gallery-description">
				<?php echo wpautop ( $description ); ?>
			</div>
			<?php endif; ?>

			<div class="campaign-gallery" id="campaign-gallery-<?php echo $campaign->ID; ?>" data-post="<?php echo $campaign->ID; ?>" data-showing="<?php echo $instance[ 'limit' ]; ?>">
				<?php foreach ( $images as $image ) : if ( $count == $instance[ 'limit' ] ) break; ?>
					<a href="<?php echo esc_url( wp_get_attachment_url( $image->ID ) ); ?>" class="campaign-gallery-item" rel="gallery-<?php echo $campaign->ID; ?>"><?php echo wp_get_attachment_image( $image->ID, 'campaign-gallery' ); ?></a>
				<?php $count++; endforeach; ?>
			</div>

			<?php if ( count( $images ) > $instance[ 'limit' ] ) : ?>
			<div class="campaign-gallery-more">
				<a href="#" class="button secondary"><?php _e( 'View More', 'campaignify' ); ?></a>
			</div>
			<?php endif; ?>
		</div>
<?php		
		echo $after_widget;
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ]       = isset( $new_instance[ 'title' ] ) ? esc_attr( $new_instance[ 'title' ] ) : '';
		$instance[ 'description' ] = isset( $new_instance[ 'description' ] ) ? esc_textarea( $new_instance[ 'description' ] ) : '';
		$instance[ 'limit' ]       = absint( $new_instance[ 'limit' ] );

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title       = isset ( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : __( 'Gallery', 'campaignify' );
		$description = isset ( $instance[ 'description' ] ) ? $instance[ 'description' ] : null;
		$limit       = isset ( $instance[ 'limit' ] ) ? absint( $instance[ 'limit' ] ) : 8;
?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'campaignify' ); ?></label>

				<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo $title; ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'Description:', 'campaignify' ); ?></label>

				<textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" rows="10"><?php echo $description; ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Number to Display:', 'campaignify' ); ?></label>

				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>">
					<?php for ( $i = 4; $i <= 20; $i++ ) : ?>
					<option value="<?php echo $i; ?>" <?php selected( $i, $limit ); ?>><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</p>
		<?php
	}
}

function widget_campaignify_campaign_gallery_load() {
	check_ajax_referer( 'widget_campaignify_campaign_gallery_load', '_nonce' );

	$post_id     = absint( $_POST[ 'post' ] );
	$offset      = absint( $_POST[ 'offset' ] );

	$images      = get_posts( array(
		'post_parent'    => $post_id,
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'offset'         => $offset,
		'numberposts'    => 1000,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post__not_in'   => campaignify_contribute_hero_ids( campaignify_item_meta( 'campaignify_slider', $post_id ) )
	) );
?>
	<?php foreach ( $images as $image ) : ?>
		<a href="<?php echo esc_url( wp_get_attachment_url( $image->ID ) ); ?>" class="campaign-gallery-item" rel="gallery-<?php echo $post_id; ?>"><?php echo wp_get_attachment_image( $image->ID, 'campaign-gallery' ); ?></a>
	<?php endforeach; ?>
<?php

	die(0);
}
add_action( 'wp_ajax_widget_campaignify_campaign_gallery_load', 'widget_campaignify_campaign_gallery_load' );
add_action( 'wp_ajax_nopriv_widget_campaignify_campaign_gallery_load', 'widget_campaignify_campaign_gallery_load' );