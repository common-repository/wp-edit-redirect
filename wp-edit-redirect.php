<?php
/**
 * Plugin Name:   WP Edit Redirect
 * Plugin URI:    https://dalton.sutton.io/plugins/
 * Description:   Add "/wp-edit/" to the end of a page or post URL to redirect to the admin. Quick access to the backend to make changes on the fly!
 * Version:       1.4
 * Requires PHP:  5.6
 * Author:        Dalton Sutton
 * Author URI:    https://dalton.sutton.io/
 * License:       GPL v2 or later
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:   wp-edit-redirect
 */


/**
 * Main Logic
 */
 function wp_edit_redirect_add_to_url() {
    if (is_admin()):
        return;
    else:

        $adminlink = admin_url('/post.php?post='.get_the_ID().'&action=edit');

        $wp_edit = get_query_var('wp-edit');

        if($wp_edit === true):
            wp_redirect($adminlink);
            exit;
        endif;

    endif;

}
add_filter('wp', 'wp_edit_redirect_add_to_url', 20);


/**
 * Query Vars Filter
 * Add "wp-edit" to the gang.
 */
function wp_edit_redirect_query_vars_filter($vars) {
    $vars[] .= 'wp-edit';
    return $vars;
}
add_filter( 'query_vars', 'wp_edit_redirect_query_vars_filter' );


/**
 * Add the endpoint
 */
function wp_edit_redirect_add_endpoints() {
    add_rewrite_endpoint('wp-edit', EP_PERMALINK | EP_PAGES);
}
add_action('init', 'wp_edit_redirect_add_endpoints');


/**
 * Filter Request
 * ?wp-edit=true if /wp-edit/ is in place.
 */
function wp_edit_redirect_filter_request( $vars ) {
    if( isset( $vars['wp-edit'] ) ) $vars['wp-edit'] = true;
    return $vars;
}
add_filter('request', 'wp_edit_redirect_filter_request' );