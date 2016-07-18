<?php
/**
 * Event Post Type
 *
 * @package   Event_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Register post types and taxonomies.
 *
 * @package Event_Post_Type
 */
class Event_Post_Type_Registrations {

	public $post_type = 'event';

	public $taxonomies = array( 'event-category' );

	public function init() {
		// Add the event post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses Event_Post_Type_Registrations::register_post_type()
	 * @uses Event_Post_Type_Registrations::register_taxonomy_category()
	 */
	public function register() {
		$this->register_post_type();
		$this->register_taxonomy_category();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Events', 'event-post-type' ),
			'singular_name'      => __( 'Event', 'event-post-type' ),
			'add_new'            => __( 'Add Event', 'event-post-type' ),
			'add_new_item'       => __( 'Add Event', 'event-post-type' ),
			'edit_item'          => __( 'Edit Event', 'event-post-type' ),
			'new_item'           => __( 'New Event', 'event-post-type' ),
			'view_item'          => __( 'View Event', 'event-post-type' ),
			'search_items'       => __( 'Search Events', 'event-post-type' ),
			'not_found'          => __( 'No events found', 'event-post-type' ),
			'not_found_in_trash' => __( 'No events in the trash', 'event-post-type' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'event', ), # Permalinks format
			'menu_position'   => 5,
			'menu_icon'       => 'dashicons-calendar',
		);

		$args = apply_filters( 'event_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register a taxonomy for Event Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Event Categories', 'event-post-type' ),
			'singular_name'              => __( 'Event Category', 'event-post-type' ),
			'menu_name'                  => __( 'Event Categories', 'event-post-type' ),
			'edit_item'                  => __( 'Edit Event Category', 'event-post-type' ),
			'update_item'                => __( 'Update Event Category', 'event-post-type' ),
			'add_new_item'               => __( 'Add New Event Category', 'event-post-type' ),
			'new_item_name'              => __( 'New Event Category Name', 'event-post-type' ),
			'parent_item'                => __( 'Parent Event Category', 'event-post-type' ),
			'parent_item_colon'          => __( 'Parent Event Category:', 'event-post-type' ),
			'all_items'                  => __( 'All Event Categories', 'event-post-type' ),
			'search_items'               => __( 'Search Event Categories', 'event-post-type' ),
			'popular_items'              => __( 'Popular Event Categories', 'event-post-type' ),
			'separate_items_with_commas' => __( 'Separate event categories with commas', 'event-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove event categories', 'event-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used event categories', 'event-post-type' ),
			'not_found'                  => __( 'No event categories found.', 'event-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'event-category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'event_post_type_category_args', $args );

		register_taxonomy( $this->taxonomies[0], $this->post_type, $args );
	}
}