<?php
/**
 * Customize/add/remove Metaboxes when creating or editing
 * a page in the WordPress Backend.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
 
 /**
  * Add the media button for managing the slider
  *
  * @since Campaignify 1.0
  *
  * @return void
  */
function campaignify_register_metabox() {
	global $post;

	if ( campaignify_is_using_widget( 'widget_campaignify_hero_contribute' ) && 'download' == $post->post_type )
		add_action( 'media_buttons', 'campaignify_metabox_campaign_slider', 50 );
}
add_action( 'add_meta_boxes', 'campaignify_register_metabox' );

/**
 * Create the media button, and load our data
 *
 * Enqueues the script to make things work, and populates the
 * slider with existing gallery IDs
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_metabox_campaign_slider() {
	global $post;

	wp_enqueue_script( 'campaignify-admin', get_template_directory_uri() . '/js/campaignify-admin.js', array( 'jquery' ), '20130503', true );

	$slider = campaignify_item_meta( 'campaignify_slider' );
?>
	<style>
		#campaignifySliderFrame .gallery-settings { display: none; }
	</style>
	
	<input type="hidden" name="campaignify_slider" id="campaignify_slider" value='<?php echo $slider; ?>' />
	<input type="submit" class="button campaignify-manage-slider" value="<?php esc_attr_e( 'Manage Campaign Slider', 'campaignify' ); ?>" />
<?php
}

/**
 * Save our campaign slider meta data.
 *
 * @since Campaignify 1.0
 *
 * @param array $fields An array of fields to save.
 * @return array $fields A modified array of fields to save.
 */
function campaignify_metabox_fields_save( $fields ) {
	$fields[] = 'campaignify_slider';

	return $fields;
}
add_filter( 'edd_metabox_fields_save', 'campaignify_metabox_fields_save' );

/**
 * Even though this is a string, we don't want EDD to
 * escape this value, as quotes around our shortcode will
 * mess things up big time.
 *
 * @since Campaignify 1.0
 *
 * @param string $field The current field save value
 * @return string The updated field value
 */
function campaignify_edd_metabox_save_campaignify_slider( $field ) {
	return $_POST[ 'campaignify_slider' ];
}
add_filter( 'edd_metabox_save_campaignify_slider', 'campaignify_edd_metabox_save_campaignify_slider' );