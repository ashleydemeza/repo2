<?php
/**
 * Campaignify Widget: Widgets
 *
 * Add another widget area inside the campaign widget area.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Widgets_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Widgets_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_widgets', 
			'description' => __( 'Display another widgetized area.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_widgets', __( 'Campaign Widget Area', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_widgets';
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes its output
	 **/
	function widget( $args, $instance ) {
		global $post, $campaign;

		ob_start();
		extract( $args, EXTR_SKIP );

		$sidebars = wp_get_sidebars_widgets();
		$widgets  = count( $sidebars[ $instance[ 'sidebar' ] ] );

		echo $before_widget;
?>
		<div class="container widgets-<?php echo absint( $widgets ); ?> clear">
			<?php dynamic_sidebar( $instance[ 'sidebar' ] ); ?>
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

		$instance[ 'sidebar' ] = isset( $new_instance[ 'sidebar' ] ) ? esc_attr( $new_instance[ 'sidebar' ] ) : null;

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		global $wp_registered_sidebars;

		$sidebar = isset ( $instance[ 'sidebar' ] ) ? esc_attr( $instance[ 'sidebar' ] ) : -1;
?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sidebar' ) ); ?>"><?php _e( 'Widget Area:', 'campaignify' ); ?></label>

				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'sidebar' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sidebar' ) ); ?>">
					<?php for ( $i = 1; $i <= apply_filters( 'campaignify_campaign_widget_areas', 3 ); $i++ )  : ?>
					<option value="<?php echo 'campaign-widget-area-' . $i; ?>" <?php selected( 'campaign-widget-area-' . $i, $sidebar ); ?>><?php printf( __( 'Campaign Widget Area #%d', 'campaignify' ), $i ); ?></option>
					<?php endfor; ?>
				</select>
			</p>
		<?php
	}
}