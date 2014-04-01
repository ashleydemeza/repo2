<?php
/**
 * Crowdfunding stuff.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

/**
 * Featured Campaign
 *
 * If the static campaign page is setup, but no campaign is defined
 * in the Customizer, things will break. This chooses one for them.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_get_featured_campaign() {
	if ( false === ( $campaign_id = get_transient( 'campaignify_featured_campaign' ) ) ) {
		$campaigns = get_posts( array(
			'post_type'   => 'download',
			'fields'      => 'ids',
			'numberposts' => 1,
			'meta_query'  => array(
				array(
					'key'   => '_campaign_featured',
					'value' => 1
				)
			)
		) );

		if ( ! empty( $campaigns ) ) {
			$campaign_id = current( $campaigns );
		} else {
			$campaigns = get_posts( array(
				'post_type'   => 'download',
				'fields'      => 'ids',
				'numberposts' => 1
			) );

			$campaign_id = current( $campaigns );
		}

		set_transient( 'campaignify_featured_campaign', $campaign_id, 72 * HOUR_IN_SECONDS );
	}

	return $campaign_id;
}

/**
 * Clear the featured campaign transient when a campaign is savd.
 *
 * @since Campaignify 1.0
 *
 * @param int $post_id Download (Post) ID
 * @return void
 */
function campaignify_featured_campaign_clear_transient( $post_id) {
	global $post;

	if ( ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) 
		return $post_id;

	if ( isset( $post->post_type ) && $post->post_type == 'revision' )
		return $post_id;

	if ( ! current_user_can( 'edit_pages', $post_id ) )
		return $post_id;

	delete_transient( 'campaignify_featured_campaign' );
}
add_action( 'save_post', 'campaignify_featured_campaign_clear_transient' );

/**
 * Figure out if a specific widget is being used on the
 * campaign page.
 *
 * @since Campaignify 1.0
 *
 * @param string $widget_id The base ID of the widget to check for.
 * @return boolean $has_widget If the widget is in use or not.
 */
function campaignify_is_using_widget( $widget_id ) {
	$widgets    = campaignify_campaign_widgets();
	$has_widget = false;
	
	if ( empty( $widgets ) )
		return false;

	foreach ( $widgets as $widget ) {
		if ( $widget[ 'classname' ] == $widget_id ) {
			$has_widget = true;
			break;
		}
	}

	return $has_widget;
}

/**
 * Get all widgets used on the Campaign page.
 *
 * @since Campaignify 1.0
 *
 * @return array $_widgets An array of active widgets
 */
function campaignify_campaign_widgets() {
	global $wp_registered_sidebars, $wp_registered_widgets;

	$index            = 'widget-area-front-page';
	$sidebars_widgets = wp_get_sidebars_widgets();
	$_widgets         = array();

	if ( empty( $sidebars_widgets ) || empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $sidebars_widgets) || !is_array($sidebars_widgets[$index]) || empty($sidebars_widgets[$index]) )
		return $_widgets;

	foreach ( (array) $sidebars_widgets[$index] as $id ) {
		$_widgets[] = $wp_registered_widgets[$id];
	}

	return $_widgets;
}

/**
 * If the current page is a campaign page.
 *
 * This can either be a singlular download, or the page template
 *
 * @since Campaignify 1.0
 *
 * @return boolean If the current page is a campaign listing or not.
 */
function campaignify_is_campaign_page() {
	if ( is_singular( 'download' ) )
		return true;

	if ( is_page_template( 'page-templates/campaignify.php' ) )
		return true;

	return false;
}
add_filter( 'atcf_is_campaign_page', 'campaignify_is_campaign_page' );

/**
 * Expired campaign shim.
 *
 * When a campaign is inactive, we display the inactive pledge amounts,
 * but the lack of form around them messes with the styling a bit, and we
 * lose our header. This fixes that. 
 *
 * @since Campaignify 1.0
 *
 * @param object $campaign The current campaign.
 * @return void
 */
function campaignify_contribute_modal_top_expired( $campaign ) {
	if ( $campaign->is_active() )
		return;
?>
	<div class="edd_download_purchase_form">
		<h2><?php printf( __( 'This %s has ended. No more pledges can be made.', 'campaignify' ), edd_get_label_singular() ); ?></h2>
<?php
}
add_action( 'campaignify_contribute_modal_top', 'campaignify_contribute_modal_top_expired' );

function campaignify_contribute_modal_top() {
	global $edd_options;
	
	if ( isset ( $edd_options[ 'atcf_settings_custom_pledge' ] ) )
		return;
?>
	<h2><?php echo apply_filters( 'campaignify_pledge_custom_title', __( 'Select your pledge amount', 'campaignify' ) ); ?></h2>
<?php
}
add_action( 'edd_purchase_link_top', 'campaignify_contribute_modal_top' );

/**
 * Expired campaign shim.
 *
 * @since Campaignify 1.0
 *
 * @param object $campaign The current campaign.
 * @return void
 */
function campaignify_contribute_modal_bottom_expired( $campaign ) {
	if ( $campaign->is_active() )
		return;
?>
	</div>
<?php
}
add_action( 'campaignify_contribute_modal_bottom', 'campaignify_contribute_modal_bottom_expired' );