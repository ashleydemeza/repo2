<?php
/**
 * Single Campaign
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */

global $campaign, $post;

if ( ! is_object( $campaign ) )
	$campaign = atcf_get_campaign( $post );

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="campaign-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php do_action( 'atcf_campaign_before', $campaign ); ?>

				<?php
					if ( ! dynamic_sidebar( 'widget-area-front-page' ) ) :
						global $wp_widget_factory;

						$widgets = apply_filters( 'campaignify_campaign_default_widgets', array(
							'Campaignify_Campaign_Content_Widget',
							'Campaignify_Campaign_Comments_Widget',
							'Campaignify_Campaign_Pledge_Widget',
							'Campaignify_Campaign_Blog_Posts_Widget'
						) );

						foreach ( $widgets as $widget ) :
							$widget_obj = $wp_widget_factory->widgets[$widget];

							the_widget( $widget, array(), array(
								'before_widget' => sprintf( '<section id="%1$s" class="campaign-widget %2$s arrowed">', $widget_obj->id, $widget_obj->widget_options[ 'classname' ] ),
								'after_widget'  => '</section>',
								'before_title'  => '<h3 class="campaign-widget-title">',
								'after_title'   => '</h3>'
							) );
						endforeach;
					endif;
				?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>