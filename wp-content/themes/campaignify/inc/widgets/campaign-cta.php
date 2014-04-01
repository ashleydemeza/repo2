<?php
/**
 * Campaignify Widget: CTA
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_CTA_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_CTA_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_cta', 
			'description' => __( 'Add a "Call to Action" section with text and a button.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_cta', __( 'Campaign Call to Action', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_cta';
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
		
		$text = $instance[ 'text' ];
		
		echo $before_widget;
?>
		<div class="container">
			<?php if ( '' != $text ) :  ?>
			<div class="campaign-cta">
				<?php echo wpautop ( $text ); ?>

				<?php if ( $instance[ 'button' ] ) : ?>
				<div class="donation-cta-button">
					<a href="http://www.firstgiving.com/fundraiser/darryl-nordquist/building-unity-campaign" target="_blank" class="button button-primary <?php if ( $instance[ 'contribute' ] ) : ?><?php endif; ?>"><?php echo esc_attr( $instance[ 'button_text' ] ); ?></a>
				</div>
				<?php endif; ?>
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

		$instance[ 'text' ]        = isset( $new_instance[ 'text' ] ) ? esc_textarea( $new_instance[ 'text' ] ) : '';
		$instance[ 'button' ]      = isset( $new_instance[ 'button' ] ) ? 1 : 0;
		$instance[ 'button_text' ] = esc_attr( $new_instance[ 'button_text' ] );
		$instance[ 'button_url' ]  = esc_url( $new_instance[ 'button_url' ] );
		$instance[ 'contribute' ]  = isset( $new_instance[ 'contribute' ] ) ? 1 : 0;

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$text        = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : null;
		$button      = isset( $instance[ 'button' ] ) ? $instance[ 'button' ] : 1;
		$button_text = isset( $instance[ 'button_text' ] ) ? esc_attr( $instance[ 'button_text' ] ) : __( 'Donate Now', 'campaignify' );
		$button_url  = isset( $instance[ 'button_url' ] ) ? esc_url( $instance[ 'button_url' ] ) : null;
		$contribute  = isset( $instance[ 'contribute' ] ) ? $instance[ 'contribute' ] : 1;
?>
			<p>
				<strong><?php _e( 'Button:', 'campaignify' ); ?></strong>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button' ) ); ?>">
					<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'button' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'button' ) ); ?>" value="<?php echo $button; ?>" <?php checked( $button, 1 ); ?> /> <?php _e( 'Display donation button?', 'campaignify' ); ?>
				</label>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php _e( 'Button Text:', 'campaignify' ); ?></label>

				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" value="<?php echo $button_text; ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php _e( 'Button URL:', 'campaignify' ); ?></label>

				<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" value="<?php echo $button_url; ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'contribute' ) ); ?>">
					<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'contribute' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'contribute' ) ); ?>" value="<?php echo $contribute; ?>" <?php checked( $contribute, 1 ); ?> /> <?php _e( 'Toggle Contribute Box?', 'campaignify' ); ?>
				</label>
			</p>

			<p>
				<strong><?php _e( 'Text:', 'campaignify' ); ?></strong>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'campaignify' ); ?></label>

				<textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" rows="10"><?php echo $text; ?></textarea>
			</p>
		<?php
	}
}