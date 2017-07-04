<?php
/**
 * Plugin Name: Pre * Party Resource Hints
 * Plugin URI: https://www.linkedin.com/in/sam-perrow-53782b10b?trk=hp-identity-name
 * Description: Take advantage of W3C browser resource hints to improve page load time, automatically and manually.
 * Version: 1.1
 * Author: Sam Perrow
 * Author URI: https://www.linkedin.com/in/sam-perrow-53782b10b?trk=hp-identity-name
 * License: GPL2
 * last edited June 11, 2017
 *
 * Copyright 2016  Sam Perrow  (email : sam.perrow399@gmail.com)
 *
 *    This program is free software; you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation; either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program; if not, write to the Free Software
 *    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GKT_PREP_PLUGIN', __FILE__ );
define( 'GKT_PREP_PLUGIN_DIR', untrailingslashit( dirname( GKT_PREP_PLUGIN ) ) );

require_once GKT_PREP_PLUGIN_DIR . '/GKTPP_Talk_To_DB.php';
require_once GKT_PREP_PLUGIN_DIR . '/GKTPP_Table.php';
require_once GKT_PREP_PLUGIN_DIR . '/options.php';
require_once GKT_PREP_PLUGIN_DIR . '/GKTPP_Enter_Data.php';
require_once GKT_PREP_PLUGIN_DIR . '/class-GKTPP_Send_Entered_Hints.php';
require_once GKT_PREP_PLUGIN_DIR . '/class-GKTPP_Ajax.php';

// register and call the CSS and JS we need only on the needed page
add_action( 'admin_menu', 'gktpp_reg_admin_stuff' );

function gktpp_reg_admin_stuff() {
	global $pagenow;

	if ( isset( $_GET['page'] ) ) {

		if ( $_GET['page'] === 'gktpp-plugin-settings' ) {
			wp_register_script( 'gktpp_admin_js', plugin_dir_url( __FILE__ ) . 'js/admin.js', null, 1.1, false );
			wp_register_style( 'gktpp-styles-css', plugin_dir_url( __FILE__ ) . 'css/styles.css', null, 1.1, 'all' );

			wp_enqueue_script( 'gktpp_admin_js' );
			wp_enqueue_style( 'gktpp-styles-css' );
		}
	}
}

register_activation_hook( __FILE__, 'gktpp_install_db_table2' );
function gktpp_install_db_table2() {
     global $wpdb;

	$table1 = $wpdb->prefix . 'gktpp_table';
	$table2 = $wpdb->prefix . 'gktpp_ajax_domains';			// backwards compat
	$charset_collate = $wpdb->get_charset_collate();

	$sql3 = "DROP TABLE IF EXISTS $table1;
	 	DROP TABLE IF EXISTS $table2;
		CREATE TABLE IF NOT EXISTS $table1 (
	    id INT(9) NOT NULL AUTO_INCREMENT,
	    url VARCHAR(75) DEFAULT '' NOT NULL,
	    hint_type VARCHAR(55) DEFAULT '' NOT NULL,
	    status VARCHAR(55) DEFAULT 'Enabled' NOT NULL,
	    ajax_domain TINYINT(1) DEFAULT 0 NOT NULL,
	    PRIMARY KEY  (id)
    ) $charset_collate";

    if ( ! function_exists( 'dbDelta' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    }

    dbDelta( $sql3, true );
}


function tl_save_error() {
    update_option( 'plugin_error',  ob_get_contents() );
}
add_action( 'activated_plugin', 'tl_save_error' );
echo get_option( 'plugin_error' );