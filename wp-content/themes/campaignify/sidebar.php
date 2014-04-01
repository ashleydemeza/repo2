<?php
/**
 * The sidebar containing the secondary widget area, displays on posts and pages.
 *
 * If no active widgets in this sidebar, it will be hidden completely.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
?>
	<div id="tertiary" class="sidebar-container" role="complementary">
		<div class="blog-widget-area">
			<?php
				if ( is_active_sidebar( 'sidebar-blog' ) )
					dynamic_sidebar( 'sidebar-blog' ); 
			?>
		</div>
	</div><!-- #tertiary -->