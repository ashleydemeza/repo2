<?php
/**
 * Campaignify Widget: Content
 *
 * Display the actual post content.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Content_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Content_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_content', 
			'description' => __( 'Display the post content for the current campaign.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_content', __( 'Campaign Content', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_content';
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

		echo $before_widget;
?>
		<div class="container">
			<?php echo apply_filters( 'the_content', $campaign->data->post_content ); ?>			
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


		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
?>
			<p>
				<?php _e( 'This widget has no options', 'campaignify' ); ?>
			</p>
		<?php
	}
}