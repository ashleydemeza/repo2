<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

$has_social = false;
$mods       = campaignify_get_theme_mods();

foreach ( $mods[ 'campaignify_social' ] as $key => $_social ) {
	if ( '' != campaignify_theme_mod( 'campaignify_social', $key ) ) {
		$has_social = true;

		break;
	}
}
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php if ( is_active_sidebar( 'widget-area-footer' ) ) : ?>
			<div class="footer-widgets container">
				<?php dynamic_sidebar( 'widget-area-footer' ); ?>
			</div>
			<?php endif; ?>

			<?php if ( $has_social ) : ?>
			<div class="footer-social">
				<?php foreach ( $mods[ 'campaignify_social' ] as $key => $_social ) : $url = campaignify_theme_mod( 'campaignify_social', $key ); ?>
					<a class="<?php echo $key; echo '' == $url ? ' hidden' : ''; ?>" href="<?php echo esc_url( $url ) ?>"><i class="icon-<?php echo $key; ?>"></i></a>
				<?php endforeach; ?>

				<a href="#" class="btt"><i class="icon-up-open-big"></i></a>
			</div>
			<?php endif; ?>

			<div class="copyright container">
				<div class="site-info">
					<?php echo apply_filters( 'campaignify_footer_copyright', sprintf( __( '&copy; %1$s %2$s. All Rights Reserved', 'campaignify' ), date( 'Y' ), get_bloginfo( 'name' ) ) ); ?>
				</div><!-- .site-info -->

				<nav id="site-footer-navigation" class="footer-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-menu', 'depth' => 1 ) ); ?>
				</nav>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>