<?php
/**
 * Event Post Type
 *
 * @package   Event_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Enable frontend actions for post type.
 *
 * @package Event_Post_Type
 */
class Event_Post_Type_Public {

    public function init() {
        # Add the event-post-type to the archives
        add_action( 'pre_get_posts', 		 array( $this, 'add_post_type_to_archives' ) );

        # Sort events by metabox event_start date instead of post creation date
        add_action( 'pre_get_posts', 		 array( $this, 'modify_post_sorting' ) );
    }

    /**
     * Out of the box, WordPress does not include custom post types in the archives for the default categories and
     * tags archives. Because of this, we add the classes custom post types to the query.
     *
     * @since    1.0.0
     */
    public function add_post_type_to_archives( $query ){

        if (is_admin() || !$query->is_main_query())
            return;

        if (is_category() || is_tag() && empty($query->query_vars['suppress_filters']))
            $query->set( 'post_type', array_merge( ['post'], ['event-post-type'] ));

    }

    /**
     * Events should be sorted by field "event_start", not like regular posts
     *
     * @since	1.0.0
     */
    public function modify_post_sorting( $query ) {

        # Only modify queries for 'event-post-type' post type
        if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'event-post-type' ) {
            $query->set('orderby', 'meta_value_num');
            $query->set('meta_key', 'event_start');
            $query->set('order', 'DESC');
        }

        return $query;
    }
}