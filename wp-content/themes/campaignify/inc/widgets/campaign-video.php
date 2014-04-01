<?php
/**
 * Campaignify Widget: Video
 *
 * Display
 *
 * Also has the ability to set a title, description.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Video_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Video_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_video', 
			'description' => __( 'Display the video attached to the campaign.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_video', __( 'Campaign Video', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_video';
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes its output
	 **/
	function widget( $args, $instance ) {
		global $post, $campaign, $wp_embed;

		ob_start();
		extract( $args, EXTR_SKIP );
		
		$title       = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? __( 'Video', 'campaignify' ) : $instance[ 'title' ], $instance, $this->id_base);
		$description = $instance[ 'description' ];
		
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

			<div class="campaign-video-wrapper">
				<?php echo $wp_embed->run_shortcode( '[embed]' . $campaign->video() . '[/embed]' ); ?>
			</div>

			<?php if ( '' != $description ) :  ?>
			<div class="campaign-video-description">
				<?php echo wpautop ( $description ); ?>
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

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title       = isset ( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : __( 'Video', 'campaignify' );
		$description = isset ( $instance[ 'description' ] ) ? $instance[ 'description' ] : null;
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
				<?php _e( 'Set the URL of the video on the campaign page.', 'campaignify' ); ?>
			</p>
		<?php
	}
}