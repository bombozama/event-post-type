<?php
/**
 * Event Post Type
 *
 * @package   Event_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Register metaboxes.
 *
 * @package Event_Post_Type
 */
class Event_Post_Type_Metaboxes {

	public function init() {
		add_action( 'add_meta_boxes',		 array( $this, 'event_meta_boxes' ) );
		add_action( 'save_post',			 array( $this, 'save_meta_boxes' ),  10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'meta_boxes_js' ) );
	}

	/**
	 * Register the metaboxes to be used for the event post type
	 *
	 * @since 0.1.0
	 */
	public function event_meta_boxes() {
		add_meta_box(
			'event_fields',
			'Event Information',
			array( $this, 'render_meta_boxes' ),
			'event',
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the fields
	*
	* @since 0.1.0
	*/
	function render_meta_boxes( $post ) {

		$meta = get_post_custom( $post->ID );
		$start = ! isset( $meta['event_start'][0] ) ? '' : $meta['event_start'][0];
		$end = ! isset( $meta['event_end'][0] ) ? '' : $meta['event_end'][0];
		$location = ! isset( $meta['event_location'][0] ) ? '' : $meta['event_location'][0];

		wp_nonce_field( basename( __FILE__ ), 'event_fields' ); ?>
		<div class="inside acf-fields -top">
			<div class="acf-field acf-field-date-picker" style="width: 20%; min-height: 88px;" data-width="20">
				<div class="acf-label">
					<label for="event_start"><?php _e( 'Start date', 'event-post-type' ); ?><span class="acf-required">*</span></label>
				</div>
				<div class="acf-input">
					<div class="acf-date-picker acf-input-wrap">
						<input class="input regular-text datepicker" type="text" value="<?php echo $start; ?>" name="event_start_datepicker" placeholder="<?php _e( 'dd/mm/yyyy', 'event-post-type' ); ?>" data-value-input="#event_start">
						<input type="hidden" value="<?php echo $start; ?>" id="event_start" name="event_start"">
					</div>
				</div>
			</div>
			<div class="acf-field acf-field-date-picker" style="width: 20%; min-height: 88px;" data-width="20">
				<div class="acf-label">
					<label for="event_end"><?php _e( 'End date', 'event-post-type' ); ?></label>
				</div>
				<div class="acf-input">
					<div class="acf-date-picker acf-input-wrap">
						<input class="input regular-text datepicker" type="text" value="<?php echo $end; ?>" name="event_end_datepicker" placeholder="<?php _e( 'dd/mm/yyyy', 'event-post-type' ); ?>" data-value-input="#event_end">
						<input type="hidden" value="<?php echo $end; ?>" id="event_end" name="event_end"">
					</div>
				</div>
			</div>
			<div class="acf-field acf-field-text acf-r0" style="width: 58%; min-height: 88px;" data-width="60">
				<div class="acf-label">
					<label for="event_location"><?php _e( 'Location', 'event-post-type' ); ?></label>
				</div>
				<div class="acf-input">
					<div class="acf-input-wrap"><input type="text" class="regular-text" name="event_location" value="<?php echo $location; ?>" placeholder="<?php _e( 'City, Country', 'event-post-type' ); ?>"></div>
				</div>
			</div>
		</div>
	<?php }

   /**
	* Save metaboxes
	*
	* @since 0.1.0
	*/
	function save_meta_boxes( $post_id ) {

		global $post;

		# Verify nonce
		if ( !isset( $_POST['event_fields'] ) || !wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) )
			return $post_id;

		# Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) )
			return $post_id;

		# Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' )
			return $post_id;

		# Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) )
			return $post_id;


		$meta['event_start'] = ( isset( $_POST['event_start'] ) ? esc_textarea( $_POST['event_start'] ) : '' );
		$meta['event_end'] = ( isset( $_POST['event_end'] ) ? esc_textarea( $_POST['event_end'] ) : '' );
		$meta['event_location'] = ( isset( $_POST['event_location'] ) ? esc_textarea( $_POST['event_location'] ) : '' );

		foreach ( $meta as $key => $value )
			update_post_meta( $post->ID, $key, $value );
	}

	/**
	 * Load meta_boxes datepicker css/js.
	 *
	 * @since 0.1.0
	 */
	function meta_boxes_js() {
		wp_enqueue_style('jquery-ui','https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css');
		wp_enqueue_script('event-post-type-datepicker', plugin_dir_url(dirname( __FILE__ )) . 'js/datepicker.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
	}
}