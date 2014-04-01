<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'campaignify' ); ?></label>
	<input type="text" value="" name="s" id="s" placeholder="<?php esc_attr_e( 'Search this website', 'campaignify' ); ?>" />
	<i class="icon-search"></i>
	<input type="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'campaignify' ); ?>" />
</form>