<?php
/**
 * Contribute
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

global $campaign, $post;

if ( ! is_object( $campaign ) && ! is_singular( 'download' ) )
	$campaign = atcf_get_campaign( atcf_get_campaign( campaignify_theme_mod( 'campaignify_general', 'campaign' ) ) );
?>

<div id="contribute-modal-wrap" class="modal">
	<?php 
		do_action( 'campaignify_contribute_modal_top', $campaign );

		if ( $campaign->is_active() ) :
			echo edd_get_purchase_link( array( 
				'download_id' => $campaign->ID,
				'class'       => '',
				'price'       => false
			) ); 
		else : // Inactive, just show options with no button
			atcf_campaign_contribute_options( edd_get_variable_prices( $campaign->ID ), 'checkbox', $campaign->ID );
		endif;
	
		do_action( 'campaignify_contribute_modal_bottom', $campaign ); 
	?>
</div>