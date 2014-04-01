<?php
/**
 * Template Name: Static Campaign
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

/**
 * If we aren't crowdfunding, but this template is still set,
 * 404 the page so we dont see any weird errors.
 */
if ( ! campaignify_is_crowdfunding() ) {
	global $wp_query;
	
	$wp_query->set_404();

	return locate_template( array( '404.php' ), true );
}

global $campaign, $post;

$campaign = atcf_get_campaign( campaignify_get_featured_campaign() );

$post = get_post( $campaign->ID );
setup_postdata( $post );

locate_template( array( 'single-campaign.php' ), true );

wp_reset_postdata();