<?php
/**
 * Campaignify Widget: Pledge
 *
 * Display a list of pledge amounts
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Pledge_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Pledge_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_pledge_levels', 
			'description' => __( 'Display a list of comments and comment form.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_pledge_levels', __( 'Campaign Pledge Levels', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_pledge_levels';
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

		$title   = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? __( 'Pledge Amounts', 'campaignify' ) : $instance[ 'title' ], $instance, $this->id_base);

		$prices  = edd_get_variable_prices( $campaign->ID );

		if ( empty( $prices ) )
			return;

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
			
			<div class="campaignify-pledge-boxes campaignify-pledge-boxes-<?php echo count ( $prices ) > 4 ? 4 : count( $prices ); ?> <?php echo $campaign->is_active() ? 'active' : 'expired'; ?>">
				<?php foreach ( $prices as $key => $price ) : ?>
					<?php
						$amount  = $price[ 'amount' ];
						$limit   = isset ( $price[ 'limit' ] ) ? $price[ 'limit' ] : '';
						$bought  = isset ( $price[ 'bought' ] ) ? $price[ 'bought' ] : 0;
						$allgone = false;

						if ( $limit )
							$percent = ( $bought / $limit ) * 100 > 100 ? 100 : ( $bought / $limit ) * 100;

						if ( $bought == absint( $limit ) && '' != $limit )
							$allgone = true;

						if ( edd_use_taxes() && edd_taxes_on_prices() )
							$amount += edd_calculate_tax( $amount );
					?>
					<div class="campaignify-pledge-box inactive" data-price="<?php echo edd_sanitize_amount( $amount ); ?>-<?php echo $key; ?>">
                   	<?  ##print '<pre>'. print_r($price, 1) .'</pre>'; ?>
						
						<?
						$levelname = $price['name'];
						$levelamount = $price['amount'];
						?>
						<?
						if ($levelname == 'Gold Level') {
						$extrabullets = '&bull; Name/Logo on Donor Wall<br>&bull; Appreciation Plaque<br>&bull; Recognition on our website';				
						$medalimg = 'http://dev1.reyinteractive.com/SpecOly/wp-content/uploads/2014/03/gold-2.png';
						$medalmove = 'medalmove';
						}
						if ($levelname == 'Silver Level') {
						$extrabullets = '&bull; Name/Logo on Donor Wall<br>&bull; Appreciation Plaque<br>&bull; Recognition on our website';				
						$medalimg = 'http://dev1.reyinteractive.com/SpecOly/wp-content/uploads/2014/03/silver-2.png';
						$medalmove = 'medalmove';
						}
						if ($levelname == 'Bronze Level') {
						$extrabullets = '&bull; Name/Logo on Donor Wall<br>&bull; Recognition on our website';				
						$medalimg = 'http://dev1.reyinteractive.com/SpecOly/wp-content/uploads/2014/03/bronze-2.png';
						$medalmove = '';
						}
						if ($levelname == 'Support Level') {
						$extrabullets = '&bull; Recognition on our website';				
						$medalimg = 'http://dev1.reyinteractive.com/SpecOly/wp-content/uploads/2014/03/support-2.png';
						$medalmove = '';
						}
						?>
						<span class="medalimage <? echo $medalmove; ?>"><a href="http://www.firstgiving.com/fundraiser/darryl-nordquist/building-unity-campaign" target="_blank"><img src="<? echo $medalimg; ?>" border="0"></a></span>
						<h3><? echo $levelname; ?></h3>
						<h4>$<? echo $levelamount; ?></h4>
						
						<span class="extrabull"><? echo $extrabullets; ?></span>
						<?php if ( '' != $limit ) : ?>
						<div class="donation-progress-bar">
							<div class="donation-progress<?php echo $percent == 100 ? ' gone' : ''; ?>" style="width: <?php echo $percent; ?>%"></div>
						</div>

						<div class="backers">
							<?php if ( '' != $limit && ! $allgone ) : ?>
								<small class="limit"><?php printf( __( 'Limit of %d &mdash; %d remaining', 'fundify' ), $limit, $limit - $bought ); ?></small>
							<?php elseif ( $allgone ) : ?>
								<small class="gone"><?php _e( 'All gone!', 'fundify' ); ?></small>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<?php ##echo wpautop( esc_html( $price[ 'name' ] ) ); ?>
					</div>
				<?php endforeach; ?>
					<div class="donation-cta-button" style="text-align: center;">
					<a href="http://www.firstgiving.com/fundraiser/darryl-nordquist/building-unity-campaign" target="_blank" class="button button-primary">Donate</a>
					</div>
			</div><!--end .edd_price_options-->
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

		$instance[ 'title' ] = isset( $new_instance[ 'title' ] ) ? esc_attr( $new_instance[ 'title' ] ) : '';

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title       = isset ( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : __( 'Pledge Levels', 'campaignify' );
?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'campaignify' ); ?></label>

				<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo $title; ?>" />
			</p>
		<?php
	}
}