<?php
/**
 * Campaignify Widget: Blog Posts
 *
 * Add a grid of blog posts similar to how they appear on the blog page.
 *
 * @package Campaignify
 * @since Campaignify 1.0
 */
class Campaignify_Campaign_Blog_Posts_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Campaignify_Campaign_Blog_Posts_Widget() {
		$widget_ops = array( 
			'classname' => 'widget_campaignify_campaign_blog_posts', 
			'description' => __( 'Display a grid of blog posts.', 'campaignify' ) 
		);

		$this->WP_Widget( 'widget_campaignify_campaign_blog_posts', __( 'Campaign Blog Posts', 'campaignify' ), $widget_ops );

		$this->alt_option_name = 'widget_campaignify_campaign_blog_posts';
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes its output
	 **/
	function widget( $args, $instance ) {
		global $post, $campaign;

		if ( ! isset ( $instance[ 'limit' ] ) )
			$instance[ 'limit' ] = 2;

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', empty( $instance[ 'title' ] ) ? __( 'Campaign Updates', 'campaignify' ) : $instance[ 'title' ], $instance, $this->id_base);

		echo $before_widget;

		if ( '' != $title ) {
			echo $before_title;
			echo $title;
			echo $after_title;
		}

		$posts = new WP_Query( apply_filters( 'widget_campaignify_campaign_blog_posts', array(
			'posts_per_page' => $instance[ 'limit' ]
		) ) );

		if ( $posts->have_posts() ) :
		?>
			<div id="content" class="site-content full" role="main">
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<?php get_template_part( 'content' ); ?>
				<?php endwhile; ?>
			</div>
		<?php
		endif;
	
		echo $after_widget;
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ] = isset( $new_instance[ 'title' ] ) ? esc_attr( $new_instance[ 'title' ] ) : '';
		$instance[ 'limit' ] = absint( $new_instance[ 'limit' ] );

		return $instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		global $wp_registered_sidebars;

		$title = isset ( $instance[ 'title' ] ) ? esc_attr( $instance[ 'title' ] ) : __( 'Campaign Updates', 'campaignify' );
		$limit = isset ( $instance[ 'limit' ] ) ? absint( $instance[ 'limit' ] ) : 2;
?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'campaignify' ); ?></label>

				<input class="widefat" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo $title; ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Number to Display:', 'campaignify' ); ?></label>

				<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>">
					<?php for ( $i = 2; $i <= 20; $i++ ) : ?>
					<option value="<?php echo $i; ?>" <?php selected( $i, $limit ); ?>><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
			</p>
		<?php
	}
}