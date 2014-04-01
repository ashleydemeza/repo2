<?php
/**
 * Campaignify Widget: Backers
 *
 * Display a slider of backers with their avatar, name, and amount.
 *
 * Also has the ability to set a title, description
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Backers_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Backers_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_backers', 
			'description' => __( 'Display a slider of all the people who have contributed to the campaign.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_backers', __( 'Campaign Backers', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_backers';
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
		
		$title       = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? __( 'Campaign Backers', 'campaignify' ) : $instance[ 'title' ], $instance, $this->id_base);
		$description = isset ( $instance[ 'description' ] ) ? $instance[ 'description' ] : null;
		$backers     = $campaign->backers();

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

			<div class="campaign-backers-description">
			<?php if ( ! empty( $backers ) ) :  ?>
				<?php echo "Gold Level"; ?>
			<?php else : ?>
				<p><?php _e( 'No backers yet. Be the first!', 'campaignify' ); ?></p>
				<a href="#" class="contribute button button-primary"><?php _e( 'Donate Now', 'campaignify' ); ?></a>
			<?php endif; ?>
			</div>

			<?php if ( ! empty( $backers ) ) : ?>
			<div class="campaign-backers-slider-wrap">
				<div class="campaign-backers-slider">
					<ul class="slides clear">
						<?php 
						$tempcount = count($backers);
						echo "$tempcount||||||||||||";
							foreach ( $backers as $backer ) : 
								$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
								$payment    = get_post( $payment_id );

								if ( ! is_object( $payment ) )
									continue;

								$meta       = edd_get_payment_meta( $payment->ID );
								$user_info  = edd_get_payment_meta_user_info( $payment_id );

								if ( empty( $user_info ) )
									continue;

   								$session_data = unserialize($meta['downloads']);

                  				##print '<pre>'. print_r($session_data, 1) .'</pre>';
                  				$checklevel = $session_data[0]['options']['price_id'];
									if ($checklevel == 0) {
								$anon       = isset ( $meta[ 'anonymous' ] ) ? $meta[ 'anonymous' ] : 0;
						?>
						<li class="campaign-backers-slider-item">
							<img src="http://dev1.reyinteractive.com/SpecOly/wp-content/uploads/2014/03/gold.png" border="0" class="avatar">

							<h3 class="campaign-backers-name">
								<?php if ( $anon ) : ?>
									<?php _ex( 'Anonymous', 'Backer chose to hide their name', 'campaignify' ); ?>
								<?php else : ?>
									<?php echo $user_info[ 'first_name' ]; ?> <?php echo $user_info[ 'last_name' ]; ?></h3>
								<?php endif; ?>
							<p class="campaign-backers-donation">Gold Level</p>
						</li>
						<?php 
									#end check
									}
						endforeach; 
						?>
					</ul>
				</div>
			</div>

<?
### hide silver section if no backers
foreach ( $backers as $backer ) {
	$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
	$payment    = get_post( $payment_id );

	if ( ! is_object( $payment ) )
	continue;

	$meta       = edd_get_payment_meta( $payment->ID );
	$user_info  = edd_get_payment_meta_user_info( $payment_id );

	if ( empty( $user_info ) )
	continue;
   	$session_data = unserialize($meta['downloads']);

    ##print '<pre>'. print_r($session_data, 1) .'</pre>';
    $checklevel = $session_data[0]['options']['price_id'];
	if ($checklevel == 1) {
	$silverpass = 1;
	##echo "|||||";
	}
}

if ($silverpass == 1) {
?>

			<div class="campaign-backers-description extra-desc">
			<?php if ( ! empty( $backers ) ) :  ?>
				<?php echo "Silver Level"; ?>
			<?php else : ?>
				<p><?php _e( 'No backers yet. Be the first!', 'campaignify' ); ?></p>
				<a href="#" class="contribute button button-primary"><?php _e( 'Donate Now', 'campaignify' ); ?></a>
			<?php endif; ?>
			</div>

			<div class="campaign-backers-slider-wrap">
				<div class="campaign-backers-slider">
					<ul class="slides clear">
						<?php 
							foreach ( $backers as $backer ) : 
								$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
								$payment    = get_post( $payment_id );

								if ( ! is_object( $payment ) )
									continue;

								$meta       = edd_get_payment_meta( $payment->ID );
								$user_info  = edd_get_payment_meta_user_info( $payment_id );

								if ( empty( $user_info ) )
									continue;
   								$session_data = unserialize($meta['downloads']);

                  				##print '<pre>'. print_r($session_data, 1) .'</pre>';
                  				$checklevel = $session_data[0]['options']['price_id'];
									if ($checklevel == 1) {

								$anon       = isset ( $meta[ 'anonymous' ] ) ? $meta[ 'anonymous' ] : 0;
						?>
						<li class="campaign-backers-slider-item">
							<img src="http://dev1.reyinteractive.com/SpecOly/wp-content/uploads/2014/03/silver.png" border="0" class="avatar">

							<h3 class="campaign-backers-name">
								<?php if ( $anon ) : ?>
									<?php _ex( 'Anonymous', 'Backer chose to hide their name', 'campaignify' ); ?>
								<?php else : ?>
									<?php echo $user_info[ 'first_name' ]; ?> <?php echo $user_info[ 'last_name' ]; ?></h3>
								<?php endif; ?>
							<p class="campaign-backers-donation">Silver Level</p>
						</li>
						<?php 
									#end check
									}
						endforeach; 
						?>
					</ul>
				</div>
			</div>

<? 

##end if
}

#### begin bronze and support levels

### hide bronze section if no backers
foreach ( $backers as $backer ) {
	$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
	$payment    = get_post( $payment_id );

	if ( ! is_object( $payment ) )
	continue;

	$meta       = edd_get_payment_meta( $payment->ID );
	$user_info  = edd_get_payment_meta_user_info( $payment_id );

	if ( empty( $user_info ) )
	continue;
   	$session_data = unserialize($meta['downloads']);

    ##print '<pre>'. print_r($session_data, 2) .'</pre>';
    $checklevel = $session_data[0]['options']['price_id'];
	if ($checklevel == 2) {
	$bronzepass = 1;
	##echo "|||||";
	}
}

if ($bronzepass == 1) {

?>

			<div class="campaign-backers-slider-wrap">
						<?php if ( ! empty( $backers ) ) :  ?>
				<?php echo "<h2 class='specialtitle'>Bronze Level</h2>"; ?>
			<?php else : ?>
				<p><?php _e( 'No backers yet. Be the first!', 'campaignify' ); ?></p>
				<a href="#" class="contribute button button-primary"><?php _e( 'Donate Now', 'campaignify' ); ?></a>
			<?php endif; ?>

						<?php 
						$counta = 0;
							foreach ( $backers as $backer ) : 
								$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
								$payment    = get_post( $payment_id );

								if ( ! is_object( $payment ) )
									continue;

								$meta       = edd_get_payment_meta( $payment->ID );
								$user_info  = edd_get_payment_meta_user_info( $payment_id );

								if ( empty( $user_info ) )
									continue;

   								$session_data = unserialize($meta['downloads']);

                  				##print '<pre>'. print_r($session_data, 1) .'</pre>';
                  				$checklevel = $session_data[0]['options']['price_id'];
									if ($checklevel == 2) {
								$anon       = isset ( $meta[ 'anonymous' ] ) ? $meta[ 'anonymous' ] : 0;
						
								
								if ($counta == 0) {
								echo "<div style='width: 100%'><div class='columnone'>";
								}
								if ($counta == 10) {
								echo "</div><div class='columntwo'>";
								}
						?>
							<h3 class="campaign-backers-name">
								<?php if ( $anon ) : ?>
									<?php _ex( 'Anonymous', 'Backer chose to hide their name', 'campaignify' ); ?>
								<?php else : ?>
									<?php echo $user_info[ 'first_name' ]; ?> <?php echo $user_info[ 'last_name' ]; ?></h3>
								<?php endif; ?>
						<?php 
									#end check
							$counta++;

									}
						endforeach;
						echo "</div></div>";
						?>
			</div>

<?
### end if
}

### hide sponors section if no backers
foreach ( $backers as $backer ) {
	$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
	$payment    = get_post( $payment_id );

	if ( ! is_object( $payment ) )
	continue;

	$meta       = edd_get_payment_meta( $payment->ID );
	$user_info  = edd_get_payment_meta_user_info( $payment_id );

	if ( empty( $user_info ) )
	continue;
   	$session_data = unserialize($meta['downloads']);

    ##print '<pre>'. print_r($session_data, 1) .'</pre>';
    $checklevel = $session_data[0]['options']['price_id'];
	if ($checklevel == 3) {
	$sponsorspass = 1;
	##echo "|||||";
	}
}

if ($sponsorspass == 1) {

?>
			<div class="campaign-backers-description extra-desc" style="clear: both;">
			<?php if ( ! empty( $backers ) ) :  ?>
				<?php echo "Sponsors Level"; ?>
			<?php else : ?>
				<p><?php _e( 'No backers yet. Be the first!', 'campaignify' ); ?></p>
				<a href="#" class="contribute button button-primary"><?php _e( 'Donate Now', 'campaignify' ); ?></a>
			<?php endif; ?>
			</div>

			<div class="campaign-backers-slider-wrap">
						<?php 
						$counta = 0;
							foreach ( $backers as $backer ) : 
								$payment_id = get_post_meta( $backer->ID, '_edd_log_payment_id', true );
								$payment    = get_post( $payment_id );

								if ( ! is_object( $payment ) )
									continue;

								$meta       = edd_get_payment_meta( $payment->ID );
								$user_info  = edd_get_payment_meta_user_info( $payment_id );

								if ( empty( $user_info ) )
									continue;
   								$session_data = unserialize($meta['downloads']);

                  				##print '<pre>'. print_r($session_data, 1) .'</pre>';
                  				$checklevel = $session_data[0]['options']['price_id'];
									if ($checklevel == 3) {

								$anon       = isset ( $meta[ 'anonymous' ] ) ? $meta[ 'anonymous' ] : 0;
								if ($counta == 0) {
								echo "<div><div class='columnone'>";
								}
								if ($counta == 10) {
								echo "</div><div class='columntwo'>";
								}

						?>
							<h3 class="campaign-backers-name">
								<?php if ( $anon ) : ?>
									<?php _ex( 'Anonymous', 'Backer chose to hide their name', 'campaignify' ); ?>
								<?php else : ?>
									<?php echo $user_info[ 'first_name' ]; ?> <?php echo $user_info[ 'last_name' ]; ?></h3>
								<?php endif; ?>
						<?php 
									#end check
							$counta++;

									}
						endforeach; 
						echo "</div></div>";

						?>
			</div>

<? 
### end sponsors check
}
?>

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
		$title       = isset ( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : __( 'Campaign Backers', 'campaignify' );
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
		<?php
	}
}