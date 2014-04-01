<?php
/**
 * Campaignify functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Campaignify
 * @since Campaignify 1.0
 */

/**
 * Sets up the content width value based on the theme's design.
 * @see campaignify_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 680;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Campaignify supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, admin bar, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_setup() {
	/*
	 * Makes Campaignify available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'campaignify' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'campaignify', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Add support for custom background
	add_theme_support( 'custom-background', array(
		'default-color' => '#ffffff'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'   => __( 'Navigation Menu', 'campaignify' ),
		'footer'    => __( 'Footer Menu', 'campaignify' )
	) );

	/**
	 * This theme supports AppThemer Crowdfunding Plugin
	 */
	add_theme_support( 'appthemer-crowdfunding', array(
		'anonymous-backers' => true,
		'campaign-widget'   => true,
		'campaign-video'    => true
	) );

	/** Shortcodes */
	add_filter( 'widget_text', 'do_shortcode' );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 550, 275, true );
	add_image_size( 'blog-inner', 750, 425, true );
	add_image_size( 'campaign-gallery', 260, 9999 );
}
add_action( 'after_setup_theme', 'campaignify_setup' );

/**
 * If EDD + Crowdfunding
 *
 * @since Campaignify 1.0
 *
 * @return boolean
 */
function campaignify_is_crowdfunding() {
	return ( class_exists( 'Easy_Digital_Downloads' ) && class_exists( 'ATCF_Campaign' ) );
}

/**
 * Plugin Notice
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_features_notice() {
	?>
	<div class="updated">
		<p><?php printf( 
					__( '<strong>Notice:</strong> To take advantage of all of the great features Campaignify offers, please install the <a href="%s">Astoundify Crowdfunding Plugin</a>. <a href="%s" class="alignright">Hide this message.</a>', 'campaignify' ), 
					wp_nonce_url( network_admin_url( 'update.php?action=install-plugin&plugin=appthemer-crowdfunding' ), 'install-plugin_appthemer-crowdfunding' ), 
					wp_nonce_url( add_query_arg( array( 'action' => 'campaignify-hide-plugin-notice' ), admin_url( 'index.php' ) ), 'campaignify-hide-plugin-notice' ) 
			); ?></p>
	</div>
<?php
}
if ( ( ! campaignify_is_crowdfunding() ) && is_admin() && ! get_user_meta( get_current_user_id(), 'campaignify-hide-plugin-notice', true ) )
	add_action( 'admin_notices', 'campaignify_features_notice' );

/**
 * Hide plugin notice.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_hide_plugin_notice() {
	check_admin_referer( 'campaignify-hide-plugin-notice' );

	$user_id = get_current_user_id();

	add_user_meta( $user_id, 'campaignify-hide-plugin-notice', 1 );
}
if ( is_admin() )
	add_action( 'admin_action_campaignify-hide-plugin-notice', 'campaignify_hide_plugin_notice' );

/**
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Campaignify 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function campaignify_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lato, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lato = _x( 'on', 'Lato font: on or off', 'campaignify' );

	/* Translators: If there are characters in your language that are not
	 * supported by Crete Round, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$crete = _x( 'on', 'Crete Round font: on or off', 'campaignify' );

	/* Translators: If there are characters in your language that are not
	 * supported by Norican, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$norican = _x( 'on', 'Norican font: on or off', 'campaignify' );

	if ( 'off' !== $lato || 'off' !== $crete ) {
		$font_families = array();

		if ( 'off' !== $lato )
			$font_families[] = 'Lato:400,700,400italic';

		if ( 'off' !== $crete )
			$font_families[] = 'Crete+Round:400,400italic';

		if ( 'off' !== $norican )
			$font_families[] = 'Norican';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin',
		);
		$fonts_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses campaignify_fonts_url() to get the Google Font stylesheet URL.
 *
 * @since Campaignify 1.0
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string
 */
function campaignify_mce_css( $mce_css ) {
	$fonts_url = campaignify_fonts_url();

	if ( empty( $fonts_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $fonts_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'campaignify_mce_css' );

/**
 * Edior Styles
 *
 * Instead of adding editor styles when the theme is set up, add them
 * when we have access to the curren post. This allows us to add specific
 * styles based on the currnet post type.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_add_editor_style() {
	global $post;

	if ( ! is_admin() )
		return;

	if ( ! is_object( $post ) )
		return;

	$post_type = get_post_type( $post->ID );

	$editor_style = 'editor-style-' . $post_type . '.css';

	add_editor_style( 'css/' . $editor_style );
}
add_action( 'pre_get_posts', 'campaignify_add_editor_style' );

/**
 * Loads our special font CSS file.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'campaignify-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * Also used in the Appearance > Header admin panel:
 * @see twentythirteen_custom_header_setup()
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_fonts() {
	$fonts_url = campaignify_fonts_url();

	if ( ! empty( $fonts_url ) )
		wp_enqueue_style( 'campaignify-fonts', esc_url_raw( $fonts_url ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'campaignify_fonts' );

/**
 * Enqueues scripts and styles for front end.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_scripts_styles() {
	global $wp_styles, $edd_options;

	/*
	 * Adds JavaScript to pages with the comment form to support sites with
	 * threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/**
	 * Standard blog posts (on the campaign page as well) use Masonry to stay proper.
	 */
	if ( is_home() || is_archive() || is_search() || campaignify_is_campaign_page() )
		wp_enqueue_script( 'jquery-masonry' );

	/**
	 * Hero slider and backers need Flexslider, and fittext is used on hero slider only 
	 */
	if ( ( campaignify_is_using_widget( 'widget_campaignify_hero_contribute' ) || campaignify_is_using_widget( 'widget_campaignify_campaign_backers' ) ) && campaignify_is_campaign_page() ) {
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), '2.1', true );			
	}

	/** Fancybox for pop-ups */
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '2.1.4', true );

	/** Fittext */
	wp_enqueue_script( 'fittext', get_template_directory_uri() . '/js/jquery.fittext.js', array( 'jquery' ), '2.1', true );

	/** Campaignify */
	wp_enqueue_script( 'campaignify-script', get_template_directory_uri() . '/js/campaignify.js', array( 'jquery', 'fancybox' ), 20130603, true );

	/**
	 * Localize/Send data to our script.
	 */
	$campaignify_settings = array(
		'l10n' => array(),
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'page' => array(
			'is_campaign'        => campaignify_is_campaign_page(),
			'is_single_comments' => is_singular() && comments_open(),
			'is_blog'            => is_home() || is_archive() || is_search()
		),
		'campaignWidgets' => '',
		'security' => array(
			'gallery' => wp_create_nonce( 'widget_campaignify_campaign_gallery_load' )
		)
	);

	// Active Widgets
	foreach ( campaignify_campaign_widgets() as $widget ) {
		$campaignify_settings[ 'campaignWidgets' ][ $widget[ 'classname' ] ] = campaignify_is_campaign_page() && campaignify_is_using_widget( $widget[ 'classname' ] );
	}

	wp_localize_script( 'campaignify-script', 'campaignifySettings', $campaignify_settings );

	/** Styles */
	wp_enqueue_style( 'entypo', get_template_directory_uri() . '/css/entypo.css' );
	wp_enqueue_style( 'campaignify-style', get_stylesheet_uri(), array( 'entypo' ), 20130505 );

	if ( campaignify_theme_mod( 'campaignify_general', 'responsive' ) )
		wp_enqueue_style( 'campaignify-responsive', get_template_directory_uri() . '/css/responsive.css', array( 'campaignify-style' ), 20130603 );
}
add_action( 'wp_enqueue_scripts', 'campaignify_scripts_styles' );

/**
 * Adjust page when responsive is off to normal scale.
 *
 * @since Campaignify 1.1
 */
function campaignify_nonresponsive_viewport() {
	if ( ! campaignify_theme_mod( 'campaignify_general', 'responsive' ) )
		return;

	echo '<meta name="viewport" content="initial-scale=1">';
}
add_action( 'wp_head', 'campaignify_nonresponsive_viewport' );

/**
 * Adjusts content_width value for campaigns
 *
 * @since Campaignify 1.0
 */
function campaignify_content_width() {
	if ( campaignify_is_campaign_page() ) {
		global $content_width;
		
		$content_width = 900;
	}
}
add_action( 'template_redirect', 'campaignify_content_width' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Campaignify 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function campaignify_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'campaignify' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'campaignify_wp_title', 10, 2 );

/**
 * Registers widgets, and widget areas.
 *
 * Register an area for the campaign page, blog widgets, and footer widgets.
 * An arbitrary number of "Campaign Widget Areas" are also created
 * that can be assigned to the campaign page areas. 
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_widgets_init() {
	register_widget( 'Campaignify_Campaign_Hero_Widget' );
	register_widget( 'Campaignify_Campaign_Gallery_Widget' );
	register_widget( 'Campaignify_Campaign_Backers_Widget' );
	register_widget( 'Campaignify_Campaign_Content_Widget' );
	register_widget( 'Campaignify_Campaign_Comments_Widget' );
	register_widget( 'Campaignify_Campaign_Widgets_Widget' );
	register_widget( 'Campaignify_Campaign_Video_Widget' );
	register_widget( 'Campaignify_Campaign_Blog_Posts_Widget' );
	register_widget( 'Campaignify_Campaign_Pledge_Widget' );
	register_widget( 'Campaignify_Campaign_CTA_Widget' );
	register_widget( 'Campaignify_Campaign_Feature_Widget' );

	register_sidebar( array(
		'name'          => __( 'Campaign Page Widget Area', 'campaignify' ),
		'id'            => 'widget-area-front-page',
		'description'   => __( 'Choose what should display on campaign pages.', 'campaignify' ),
		'before_widget' => '<section id="%1$s" class="campaign-widget %2$s arrowed">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="campaign-widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Blog Widget Area', 'campaignify' ),
		'id'            => 'sidebar-blog',
		'description'   => __( 'Appears to the right of the main content area in the blog.', 'campaignify' ),
		'before_widget' => '<aside id="%1$s" class="blog-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="blog-widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'campaignify' ),
		'id'            => 'widget-area-footer',
		'description'   => __( 'Display columns of widgets in the footer.', 'campaignify' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="footer-widget-title">',
		'after_title'   => '</h3>',
	) );

	for ( $i = 1; $i <= apply_filters( 'campaignify_campaign_widget_areas', 3 ); $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( __( 'Campaign Widget Area #%d', 'campaignify' ), $i ),
			'id'            => 'campaign-widget-area-' . $i,
			'description'   => __( 'Add widgets to appear in the campaign listing. Use with "Campaign Widget Area" widget.', 'campaignify' ),
			'before_widget' => '<aside id="%1$s" class="campaign-widget-widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="campaign-widget-widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'campaignify_widgets_init' );

/**
 * Extends the default WordPress body class to denote:
 * 1. Custom fonts enabled.
 *
 * @since Campaignify 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function campaignify_body_class( $classes ) {
	if ( wp_style_is( 'campaignify-fonts', 'queue' ) )
		$classes[] = 'custom-font';

	return $classes;
}
add_filter( 'body_class', 'campaignify_body_class' );

/**
 * Extends the default WordPress post class to denote:
 * 1. If in the homepage/archive grid.
 * 2. If in the campaign post grid.
 * 3. If the entry has a featured image.
 * 4. If viewing a page that should not have a box around the content.
 *
 * @since Campaignify 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function campaignify_post_class( $classes ) {
	global $edd_options;

	if ( is_home() || is_archive() || is_search() )
		$classes[] = 'in-grid';

	if ( campaignify_is_campaign_page() )
		$classes[] = 'inline';

	if ( has_post_thumbnail() && ! campaignify_is_campaign_page() )
		$classes[] = 'has-thumbnail';

	$nobox = array();

	if ( isset ( $edd_options[ 'purchase_page' ] ) )
		$nobox[] = $edd_options[ 'purchase_page' ];

	if ( isset ( $edd_options[ 'login_page' ] ) )
		$nobox[] = $edd_options[ 'login_page' ];

	if ( isset ( $edd_options[ 'register_page' ] ) )
		$nobox[] = $edd_options[ 'register_page' ];

	if ( isset ( $edd_options[ 'submit_page' ] ) )
		$nobox[] = $edd_options[ 'submit_page' ];

	if ( is_page( $nobox ) )
		$classes[] = 'no-box';

	return $classes;
}
add_filter( 'post_class', 'campaignify_post_class' );

/**
 * Extends the default WordPress comment class to add 'no-avatars' class
 * if avatars are disabled in discussion settings.
 *
 * @since Campaignify 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function campaignify_comment_class( $classes ) {
	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'comment_class', 'campaignify_comment_class' );

/**
 * Append modal boxes to the bottom of the the page that
 * will pop up when certain links are clicked.
 *
 * Login/Register pages must be set in EDD settings for this to work.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_inline_modals() {
	global $edd_options;

	if ( did_action( 'atcf_found_widget' ) )
		return;

	if ( isset ( $edd_options[ 'login_page' ] ) && isset ( $edd_options[ 'register_page' ] ) ) {
		get_template_part( 'modal', 'login' );
		get_template_part( 'modal', 'register' );
	}

	if ( campaignify_is_campaign_page() && campaignify_is_crowdfunding() )
		get_template_part( 'modal', 'contribute' );
}
add_action( 'wp_footer', 'campaignify_inline_modals' );

/**
 * If the menu item has a custom class, that means it is probably
 * going to be triggering a modal. The ID will be used to determine
 * the inline content to be displayed, so we need it to provide context.
 * This uses the specificed class name instead of `menu-item-x`
 *
 * @since Campaignify 1.0
 *
 * @param string $id The ID of the current menu item
 * @param object $item The current menu item
 * @param array $args Arguments
 * @return string $id The modified menu item ID
 */
function campaignify_nav_menu_item_id( $id, $item, $args ) {
	if ( ! empty( $item->classes[0] ) ) {
		return current($item->classes) . '-modal';
	}

	return $id;
}
add_filter( 'nav_menu_item_id', 'campaignify_nav_menu_item_id', 10, 3 );

/** 
 * Object meta helper.
 *
 * @since Campaignify 1.0
 *
 * @param string $key The meta key to get.
 * @param int $post_id The post ID to pull the meta from.
 * @return mixed The found post meta
 */
function campaignify_item_meta( $key, $post_id = null ) {
	global $post;

	if ( is_null( $post_id ) && is_object( $post ) )
		$post_id = $post->ID;

	$meta = get_post_meta( $post_id, $key, true );

	if ( $meta )
		return apply_filters( 'campaignify_meta_' . $key, $meta );

	return false;
}

/** 
 * Pagination
 *
 * After the loop, attach pagination to the current query.
 *
 * @since Campaignify 1.0
 *
 * @return void
 */
function campaignify_pagination() {
	global $wp_query;

	$big = 999999999; // need an unlikely integer

	$links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_text' => '<i class="icon-left-open-big"></i>',
		'next_text' => '<i class="icon-right-open-big"></i>'
	) );
?>
	<div class="paginate-links container">
		<?php echo $links; ?>
	</div>
<?php
}
add_action( 'campaignify_loop_after', 'campaignify_pagination' );

/**
 * Crowdfunding
 */
require_once( get_template_directory() . '/inc/crowdfunding.php' );

/**
 * Template Tags
 */
require_once( get_template_directory() . '/inc/template-tags.php' );

/**
 * Widgets
 */
$widgets = array( 
	'campaign-contribute-hero', 
	'campaign-gallery', 
	'campaign-backers', 
	'campaign-content', 
	'campaign-comments', 
	'campaign-widgets', 
	'campaign-video',
	'campaign-blog-posts',
	'campaign-pledge-amounts',
	'campaign-cta',
	'campaign-feature'
);

foreach ( $widgets as $widget ) {
	require_once( get_template_directory() . '/inc/widgets/' . $widget . '.php' );
}

/**
 * Custom Header
 */
require_once( get_template_directory() . '/inc/custom-header.php' );

/**
 * Customizer
 */
require_once( get_template_directory() . '/inc/theme-customizer.php' );

/**
 * Admin
 */
if ( is_admin() )
	require_once( get_template_directory() . '/inc/admin/metabox.php' );