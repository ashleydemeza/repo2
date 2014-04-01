<?php
/**
 * Share
 *
 * @package Campaignify
 * @since Campaignify 1.2
 */

global $campaign;
?>

<div id="share-widget" class="modal-share modal">
	<h2 class="modal-title"><?php printf( __( 'Share this %s', 'campaignify' ), edd_get_label_singular() ); ?></h2>

	<p>Help raise awareness for this campaign by sharing this widget. Simply paste the following HTML code most places on the web.</p>

	<div class="share-widget-preview">
		<div class="share-widget-preview-live">
			<iframe src="<?php echo atcf_create_permalink( 'widget', get_permalink( $campaign->ID ) ); ?>" width="260px" height="260px" frameborder="0" scrolling="no" /></iframe>
		</div>

		<div class="share-widget-preview-code">
			<strong><?php _e( 'Embed Code', 'campaignify' ); ?></strong>
			
			<pre>&lt;iframe src="<?php echo atcf_create_permalink( 'widget', get_permalink( $campaign->ID ) ); ?>" width="260px" height="260px" frameborder="0" scrolling="no" /&gt;&lt;/iframe&gt;</pre>
		</div>
	</div>
</div>