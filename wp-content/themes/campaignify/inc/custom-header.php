<?php
/**
 * Implements a custom header for Twenty Thirteen.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

/**
 * Sets up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses campaignify_header_style() to style front-end.
 * @uses campaignify_admin_header_style() to style wp-admin form.
 * @uses campaignify_admin_header_image() to add custom markup to wp-admin form.
 * @uses register_default_headers() to set up the bundled header images.
 *
 * @since Campaignify 1.0
 */
function campaignify_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => '5d5d5d',

		// Set height and width, with a maximum value for the width.
		'height'                 => 50,
		'width'                  => 200,
		'flex-width'             => true,
		'flex-height'            => false,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'campaignify_header_style',
		'admin-head-callback'    => 'campaignify_admin_header_style',
		'admin-preview-callback' => 'campaignify_admin_header_image',
	);

	add_theme_support( 'custom-header', $args );

	add_action( 'admin_print_styles-appearance_page_custom-header', 'campaignify_fonts' );
}
add_action( 'after_setup_theme', 'campaignify_custom_header_setup' );

/**
 * Styles the header text displayed on the blog.
 *
 * get_header_textcolor() options: Hide text (returns 'blank'), or any hex value.
 *
 * @since Campaignify 1.0
 */
function campaignify_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();
?>
	<style type="text/css">
	<?php if ( ! display_header_text() ) : ?>
	.site-title span {
		position: absolute;
		clip: rect(1px, 1px, 1px, 1px);
	}
	<?php endif; ?>
	.site-branding,
	.site-description {
		color: #<?php echo esc_attr( $text_color ); ?>;
	}
	</style>
	<?php
}

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Campaignify 1.0
 */
function campaignify_admin_header_style() {
	$header_image = get_header_image();
?>
	<style type="text/css">
	.site-header-main {
		background: #<?php echo get_theme_mod( 'background_color' ); ?>;
	}

	<?php if ( ! display_header_text() ) : ?>
	.site-title span {
		position: absolute;
		clip: rect(1px, 1px, 1px, 1px);
	}
	<?php endif; ?>

	.site-description {
		position: absolute;
		clip: rect(1px, 1px, 1px, 1px);
	}

	.site-title {
		font: normal 32px/1 'Norican', serif;
		color: #838383;
		text-decoration: none;
		margin: 0;
		padding: 30px 0;
	}

	.site-title img {
		vertical-align: middle;
	}

	.site-header-main a {
		text-decoration: none;
	}
	</style>
<?php
}

/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup displayed there.
 *
 * @since Campaignify 1.0
 */
function campaignify_admin_header_image() {
	$header_image = get_header_image();
?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-header-main">
			<?php $style = ' style="color:#' . get_header_textcolor() . ';"'; ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-branding">
				<hgroup>
					<h1 id="name" class="site-title"<?php echo $style; ?>>
						<?php if ( ! empty( $header_image ) ) : ?>
							<img src="<?php echo $header_image ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
						<?php endif; ?>

						<span><?php bloginfo( 'name' ); ?></span>
					</h1>
					<h2 id="desc" class="site-description"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
			</a>
		</div>
	</header><!-- #masthead -->
<?php }
