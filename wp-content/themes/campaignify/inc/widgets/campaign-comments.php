<?php
/**
 * Campaignify Widget: Comments
 *
 * Display comments attached to the campaign.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Comments_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Comments_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_comments', 
			'description' => __( 'Display a list of comments and comment form.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_comments', __( 'Campaign Comments', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_comments';
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

		$title  = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? __( 'Ask a Question', 'campaignify' ) : $instance[ 'title' ], $instance, $this->id_base);

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
			
			<?php comments_template(); ?>
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

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title       = isset ( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : __( 'Ask a Question', 'campaignify' );
?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'campaignify' ); ?></label>

				<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo $title; ?>" />
			</p>
		<?php
	}
}