<?php
/**
Plugin Name: Show modified Date in admin lists
Plugin URI: https://apasionados.es
Description: Shows a new, sortable, column with the modified date in the lists of pages and posts in the WordPress admin panel. It also shows the username that did the last update.
Version: 1.5
Author: Apasionados.es
Author URI: https://apasionados.es
License: GPL2
Text Domain: show-modified-date-in-admin-lists
*/

add_action( 'init', 'show_modified_date_in_admin_lists_language' );
function show_modified_date_in_admin_lists_language() {
	load_plugin_textdomain(
		'show-modified-date-in-admin-lists',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages/'
	);
}

// Register Modified Date Column for both posts & pages
function modified_column_register( $columns ) {
	$columns['Modified'] = __( 'Modified Date', 'show-modified-date-in-admin-lists' );
	return $columns;
}
add_filter( 'manage_posts_columns', 'modified_column_register' );
add_filter( 'manage_pages_columns', 'modified_column_register' );
add_filter( 'manage_media_columns', 'modified_column_register' );

function modified_column_display( $column_name, $post_id ) {
	switch ( $column_name ) {
		case 'Modified':
			echo '<p class="mod-date">';
			echo '<em>' . get_the_modified_date() . ' ' . get_the_modified_time() . '</em><br />';

			if ( ! empty( get_the_modified_author() ) ) {
				echo '<small>' . esc_html__( 'by', 'show-modified-date-in-admin-lists' ) . ' <strong>' . esc_html( get_the_modified_author() ) . '</strong></small>';
			} else {
				echo '<small>' . esc_html__( 'by', 'show-modified-date-in-admin-lists' ) . ' <strong>' . esc_html__( 'UNKNOWN', 'show-modified-date-in-admin-lists' ) . '</strong></small>';
			}

			echo '</p>';
		break;
	}
}
add_action( 'manage_posts_custom_column', 'modified_column_display', 10, 2 );
add_action( 'manage_pages_custom_column', 'modified_column_display', 10, 2 );
add_action( 'manage_media_custom_column', 'modified_column_display', 10, 2 );

function modified_column_register_sortable( $columns ) {
	$columns['Modified'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'modified_column_register_sortable' );
add_filter( 'manage_edit-page_sortable_columns', 'modified_column_register_sortable' );
add_filter( 'manage_upload_sortable_columns', 'modified_column_register_sortable' );
