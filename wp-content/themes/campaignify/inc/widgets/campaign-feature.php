<?php
/**
 * Campaignify Widget: Feature
 *
 * Display a section of content (not campaign-specific) with an image, title, and description.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Feature_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Feature_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_feature', 
			'description' => __( 'Display an image, title, and paragraph of text.', 'campaignify' ) 
		);

		$control_ops = array(
			'width'  => 400, 
			'height' => 350
		);

		$this->WP_Widget( 'widget_campaignify_campaign_feature', __( 'Campaign Feature', 'campaignify' ), $widget_ops, $control_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_feature';
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

		wp_enqueue_script( 'jquery-masonry' );
		
		$title       = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? '' : $instance[ 'title' ], $instance, $this->id_base);
		$description = isset ( $instance[ 'description' ] ) ? apply_filters( 'widget_text', $instance[ 'description' ] ) : null;
		$image       = isset ( $instance[ 'image' ] ) ? $instance[ 'image' ] : null;
		$align       = isset ( $instance[ 'align' ] ) ? $instance[ 'align' ] : null;

		if ( filter_var( $image, FILTER_VALIDATE_URL ) ) {
			$image = '<img src="' . $image . '" alt="" />';
		}
		

		echo $before_widget;
?>
		<div class="container campaign-feature align<?php echo $align; ?>">
			<div class="campaign-feature-image">
				<?php echo $image; ?>
			</div>	

			<div class="campaign-feature-content">
				<?php
					if ( '' != $title ) {
						echo $before_title;
						echo $title;
						echo $after_title;
					}
				?>

				<?php echo wpautop( $description ); ?>
			</div>
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
		$instance[ 'description' ] = isset( $new_instance[ 'description' ] ) ? $new_instance[ 'description' ] : '';
		$instance[ 'image' ]       = isset( $new_instance[ 'image' ] ) ? $new_instance[ 'image' ] : '';
		$instance[ 'align' ]       = isset( $new_instance[ 'align' ] ) ? esc_attr( $new_instance[ 'align' ] ) : '';

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title       = isset( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : '';
		$description = isset( $instance[ 'description' ] ) ? $instance[ 'description' ] : null;
		$image       = isset( $instance[ 'image' ] ) ? $instance[ 'image' ] : null;
		$align       = isset( $instance[ 'align' ] ) ? esc_attr( $instance[ 'align' ] ) : 'left';
?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'campaignify' ); ?></label>

				<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo $title; ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Image or Other:', 'campaignify' ); ?></label>

				<textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" rows="3"><?php echo $image; ?></textarea>
				<span class="description"><?php _e( 'HTML code or image URL', 'campaignify' ); ?>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'align' ) ); ?>"><?php _e( 'Image or Other Alignment:', 'campaignify' ); ?></label>

				<select name="<?php echo esc_attr( $this->get_field_name( 'align' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'align' ) ); ?>">
					<option value="left" <?php selected( $align, 'left' ); ?>><?php echo _x( 'Left', 'Campaign Feature Widget image alignment', 'campaignify' ); ?></option>
					<option value="right" <?php selected( $align, 'right' ); ?>><?php echo _x( 'Right', 'Campaign Feature Widget image alignment', 'campaignify' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'Content:', 'campaignify' ); ?></label>

				<textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" rows="10" cols="20"><?php echo $description; ?></textarea>
			</p>
		<?php
	}
}