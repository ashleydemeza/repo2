<?php
/**
 * Customize
 *
 * Theme options are lame! Manage any customizations through the Theme
 * Customizer. Expose the customizer in the Appearance panel for easy access.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

/**
 * Get Theme Mod
 *
 * Instead of options, customizations are stored/accessed via Theme Mods
 * (which are still technically settings). This wrapper provides a way to
 * check for an existing mod, or load a default in its place.
 *
 * @since Campaignify 1.0
 *
 * @param string $key The key of the theme mod to check. Prefixed with 'campaignify_'
 * @return mixed The theme modification setting
 */
function campaignify_theme_mod( $section, $key, $_default = false ) {
	$mods = campaignify_get_theme_mods();

	$default = $mods[ $section ][ $key ][ 'default' ];

	if ( $_default )
		$mod = $default;
	else
		$mod = get_theme_mod( $key, $default );

	return apply_filters( 'campaignify_theme_mod_' . $key, $mod );
}

/** 
 * Register two new sections: General, and Social.
 *
 * @since Campaignify 1.0
 *
 * @param object $wp_customize
 * @return void
 */
function campaignify_customize_register_sections( $wp_customize ) {
	$wp_customize->add_section( 'campaignify_general', array(
		'title'      => _x( 'General', 'Theme customizer section title', 'campaignify' ),
		'priority'   => 10,
	) );

	$wp_customize->add_section( 'campaignify_social', array(
		'title'      => _x( 'Social Links', 'Theme customizer section title', 'campaignify' ),
		'priority'   => 1000,
	) );
}
add_action( 'customize_register', 'campaignify_customize_register_sections' );

/**
 * Default theme customizations.
 *
 * @since Campaignify 1.0
 *
 * @return $options an array of default theme options
 */
function campaignify_get_theme_mods( $args = array() ) {
	$defaults = array(
		'keys_only' => false
	);

	$args = wp_parse_args( $args, $defaults );

	$mods = array(
		'campaignify_general' => array(
			'responsive' => array(
				'title'   => __( 'Enable Responsive Design', 'campaignify' ),
				'type'    => 'checkbox',
				'default' => 1
			)
		),
		'campaignify_social' => array(
			'rss' => array( 
				'title'   => __( 'RSS Feed URL', 'campaignify' ),
				'type'    => 'text',
				'default' => get_bloginfo( 'rss2_url' ) 
			),
			'twitter' => array( 
				'title'   => __( 'Twitter URL', 'campaignify' ),
				'type'    => 'text',  
				'default' => ''                         
			),
			'facebook' => array( 
				'title'   => __( 'Facebook URL',  'campaignify' ),
				'type'    => 'text', 
				'default' => ''
			),
			'linkedin' => array( 
				'title'   => __( 'LinkedIn URL',  'campaignify' ),
				'type'    => 'text', 
				'default' => ''
			),
			'gplus' => array( 
				'title'   => __( 'Google Plus URL',  'campaignify' ),
				'type'    => 'text', 
				'default' => ''
			),
			'pinterest' => array( 
				'title'   => __( 'Pinterest URL',  'campaignify' ),
				'type'    => 'text', 
				'default' => ''
			),
			'instagram' => array( 
				'title'   => __( 'Instagram URL',  'campaignify' ),
				'type'    => 'text', 
				'default' => ''
			),
			'vimeo' => array( 
				'title'   => __( 'Vimeo URL',  'campaignify' ), 
				'type'    => 'text',
				'default' => ''
			)
		)
	);

	$mods = apply_filters( 'campaignify_theme_mods', $mods );

	/** Return all keys within all sections (for transport, etc) */
	if ( $args[ 'keys_only' ] ) {
		$keys = array();
		$final = array();

		foreach ( $mods as $section ) {
			$keys = array_merge( $keys, array_keys( $section ) );
		}

		foreach ( $keys as $key ) {
			$final[ $key ] = '';
		}

		return $final;
	}

	return $mods;
}

/**
 * Add some color!
 *
 * Add primary and accent color manually, then loop through all
 * active widgets, and add a background and text color for each.
 *
 * @since Campaignify 1.0
 *
 * @param array $mods An array of existing theme mods.
 * @return array $mods A modified array of theme mods.
 */
function campaignify_theme_mods_colors( $mods ) {
	$mods[ 'colors' ][ 'campaignify_primary' ] = array(
		'title'    => __( 'Primary Color', 'campaignify' ),
		'type'     => 'WP_Customize_Color_Control',
		'default'  => '#3ea5ce',
		'priority' => 2
	);

	$mods[ 'colors' ][ 'campaignify_accent' ] = array(
		'title'    => __( 'Accent Color', 'campaignify' ),
		'type'     => 'WP_Customize_Color_Control',
		'default'  => '#f16562',
		'priority' => 4
	);

	$widgets = campaignify_campaign_widgets();

	if ( empty( $widgets ) )
		return $mods;

	$priority = 100;

	foreach ( $widgets as $widget ) {
		$mods[ 'colors' ][ $widget[ 'id' ] . '_divider' ] = array(
			'type' => 'Campaignify_Customize_Divider_Control',
			'title' => '',
			'default' => '',
			'priority' => $priority
		);

		$mods[ 'colors' ][ $widget[ 'id' ] . '_title' ] = array(
			'type'     => 'Campaignify_Customize_Color_Section_Control',
			'title'    => $widget[ 'name' ] . '<br />' . $widget[ 'description' ],
			'default'  => '',
			'priority' => $priority + 1
		);

		$mods[ 'colors' ][ $widget[ 'id' ] . '_text' ] = array(
			'title'    => __( 'Text Color', 'campaignify' ),
			'type'     => 'WP_Customize_Color_Control',
			'default'  => '#818080',
			'priority' => $priority + 2
		);

		$mods[ 'colors' ][ $widget[ 'id' ] ] = array(
			'title'    => __( 'Background Color', 'campaignify' ),
			'type'     => 'WP_Customize_Color_Control',
			'default'  => '#ffffff',
			'priority' => $priority + 3
		);

		$priority = $priority + 10;
	}

	return $mods;
}
add_filter( 'campaignify_theme_mods', 'campaignify_theme_mods_colors' );

/**
 * Register settings.
 *
 * Take the final list of theme mods, and register all the settings, 
 * and add all of the proper controls.
 *
 * If the type is one of the default supported ones, add it normally. Otherwise
 * Use the type to create a new instance of that control type.
 *
 * @since Campaignify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function campaignify_customize_register_settings( $wp_customize ) {
	$mods = campaignify_get_theme_mods();

	foreach ( $mods as $section => $settings ) {
		foreach ( $settings as $key => $setting ) {
			$wp_customize->add_setting( $key, array(
				'default'    => campaignify_theme_mod( $section, $key, true ),
			) );

			$type = $setting[ 'type' ];

			if ( in_array( $type, array( 'text', 'checkbox', 'radio', 'select', 'dropdown-pages' ) ) ) {
				$wp_customize->add_control( $key, array(
					'label'      => $setting[ 'title' ],
					'section'    => $section,
					'settings'   => $key,
					'type'       => $type,
					'choices'    => isset ( $setting[ 'choices' ] ) ? $setting[ 'choices' ] : null,
					'priority'   => isset ( $setting[ 'priority' ] ) ? $setting[ 'priority' ] : null
				) );
			} else {
				$wp_customize->add_control( new $type( $wp_customize, $key, array(
					'label'      => $setting[ 'title' ],
					'section'    => $section,
					'settings'   => $key,
					'priority'   => isset ( $setting[ 'priority' ] ) ? $setting[ 'priority' ] : null
				) ) );
			}
		}
	}

	do_action( 'campaignify_customize_regiser_settings', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'campaignify_customize_register_settings' );

/**
 * Add postMessage support for all default fields, as well
 * as the site title and desceription for the Theme Customizer.
 *
 * @since Campaignify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function campaignify_customize_register_transport( $wp_customize ) {
	$built_in    = array( 'blogname' => '', 'blogdescription' => '', 'header_textcolor' => '' );
	$campaignify = campaignify_get_theme_mods( array( 'keys_only' => true ) );
	
	$transport = array_merge( $built_in, $campaignify );

	foreach ( $transport as $key => $default ) {
		$wp_customize->get_setting( $key )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'campaignify_customize_register_transport' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Campaignify 1.0
 */
function campaignify_customize_preview_js() {
	wp_enqueue_script( 'campaignify-customizer', get_template_directory_uri() . '/js/campaignify-theme-customizer.js', array( 'customize-preview' ), 20130505, true );

	$mods = campaignify_get_theme_mods();

	wp_localize_script( 'campaignify-customizer', 'CampaignifyCustomizerParams', array(
		'social' => array_keys( $mods[ 'campaignify_social' ] ),
		'colors' => array_keys( $mods[ 'colors' ] )
	) );
}
add_action( 'customize_preview_init', 'campaignify_customize_preview_js' );

/**
 * Custom control CSS
 *
 * @since Campaignify 1.0
 */
function campaignify_customize_divider() {
?>
	<style>
		.campaignify-customize-divider {
			margin: 10px -20px;
			border: 0;
			background: #fff;
			height: 1px;
			box-shadow: #dfdfdf 0 -1px 0;
		}

		.customize-control-divider {
			margin: 0 0 8px;
		}
	</style>
<?php
}
add_action( 'customize_controls_print_styles', 'campaignify_customize_divider' );

/**
 * Get all campaigns for use in a dropdown.
 *
 * @since Campaignify 1.0
 */
function campaignify_get_campaign_select() {
	$_campaigns = array();
	$campaigns  = get_posts( array(
		'post_type' => array( 'download' ),
		'nopaging'  => true
	) );

	if ( empty( $campaigns ) )
		return;

	$_campaigns[-1] = __( 'Select Campaign', 'campaignify' );

	foreach ( $campaigns as $campaign ) {
		$_campaigns[ $campaign->ID ] = $campaign->post_title;
	}

	return $_campaigns;
}

/**
 * Custom Controls
 *
 * @since Campaignify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function campaignify_customize_controls( $wp_customize ) {
	/**
	 * Textarea Control
	 *
	 * @since Campaignify 1.0
	 */
	class Campaignify_Customize_Divider_Control extends WP_Customize_Control {
		public $type = 'divider';

		public function render_content() {
			echo '<hr class="campaignify-customize-divider" />';
		}
	} 

	/**
	 * Textarea Control
	 *
	 * @since Campaignify 1.0
	 */
	class Campaignify_Customize_Color_Section_Control extends WP_Customize_Control {
		public $type = 'color-section-title';

		public function render_content() {
			$label = explode( '<br />', $this->label );

			echo '<span class="customize-control-title">' . $label[0] . '</span>';
			echo '<span class="customize-control-desc">' . $label[1] . '</span>';
		}
	} 
}
add_action( 'customize_register', 'campaignify_customize_controls', 1, 1 );

/**
 * Output the basic extra CSS for primary and accent colors.
 * Split away from widget colors for brevity. 
 *
 * @since Campaignify 1.0
 */
function campaignify_header_css() {
?>
	<style id="campaignify-css">
		a,
		.site-branding:hover .site-title,
		.nav-menu-primary ul li a:hover,
		.nav-menu-primary li a:hover,
		.entry-meta a:hover,
		.blog-widget a:hover,
		.entry-header .entry-title a:hover {
			color: <?php echo campaignify_theme_mod( 'colors', 'campaignify_primary' ); ?>;
		}

		.nav-menu-primary li.login a:hover,
		.page-header,
		.footer-social .btt:hover,
		a.page-numbers:hover,
		.edd-submit.button {
			background-color: <?php echo campaignify_theme_mod( 'colors', 'campaignify_primary' ); ?>;
		}

		.button-primary,
		.edd-add-to-cart,
		.donation-progress {
			background-color: <?php echo campaignify_theme_mod( 'colors', 'campaignify_accent' ); ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'campaignify_header_css' );

/**
 * Campaign Widget colors
 *
 * Loop through active widgets, grab the background and text colors,
 * and output them. Also provides an action for each widget so extra
 * CSS can manually be added.
 *
 * @since Campaignify 1.0
 */
function campaignify_header_css_widgets() {
	$widgets = campaignify_campaign_widgets();

	if ( empty( $widgets ) )
		return;

	echo '<style>';

	foreach ( $widgets as $widget ) {
		$background_color = campaignify_theme_mod( 'colors', $widget[ 'id' ] );
		$color            = campaignify_theme_mod( 'colors', $widget[ 'id' ] . '_text' );
	
		printf( '#%1$s { background-color: %2$s; color: %3$s; }', $widget[ 'id' ], $background_color, $color );
		
		do_action( 'campaignify_header_css_' . $widget[ 'classname' ], $widget[ 'id' ], $background_color, $color );
	}

	echo '</style>';
}
add_action( 'wp_head', 'campaignify_header_css_widgets' );

/**
 * Blog Posts CSS shim
 *
 * Change the backers name to use the same color as the background.
 *
 * @since Campaignify 1.0
 *
 * @param string $id The widget ID.
 * @param string $bg_color The set background color.
 * @param string $color The set text color.
 */
function campaignify_header_css_widget_campaignify_campaign_blog_posts( $id, $bg_color, $color ) {
	printf( '#%1$s .entry-title a, #%1$s .entry-meta a { color: %2$s; }', $id, $color );
}
add_action( 'campaignify_header_css_widget_campaignify_campaign_blog_posts', 'campaignify_header_css_widget_campaignify_campaign_blog_posts', 10, 3 );

/**
 * Backers CSS shim
 *
 * Change the backers name to use the same color as the background.
 *
 * @since Campaignify 1.0
 *
 * @param string $id The widget ID.
 * @param string $bg_color The set background color.
 * @param string $color The set text color.
 */
function campaignify_header_css_widget_campaignify_campaign_backers( $id, $bg_color, $color ) {
	if ( '#ffffff' == $bg_color )
		return;
	
	printf( '#%1$s .campaign-backers-name { color: %2$s; }', $id, $bg_color );
}
add_action( 'campaignify_header_css_widget_campaignify_campaign_backers', 'campaignify_header_css_widget_campaignify_campaign_backers', 10, 3 );

/**
 * Hero CSS shim.
 *
 * Change the share button links to use the same color as the text.
 *
 * @since Campaignify 1.0
 *
 * @param string $id The widget ID.
 * @param string $bg_color The set background color.
 * @param string $color The set text color.
 */
function campaignify_header_css_widget_campaignify_hero_contribute( $id, $bg_color, $color ) {
	printf( '#%1$s .donation-share-buttons a { color: %2$s; }', $id, $color );
}
add_action( 'campaignify_header_css_widget_campaignify_hero_contribute', 'campaignify_header_css_widget_campaignify_hero_contribute', 10, 3 );