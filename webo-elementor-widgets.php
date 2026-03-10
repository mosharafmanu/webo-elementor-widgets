<?php
/**
 * Plugin Name: Webo Elementor Widgets
 * Plugin URI: https://mosharafmanu.com
 * Description: Custom Elementor widgets for the Webo project.
 * Version: 1.0.0
 * Author: Mosharaf Hossain
 * Author URI: https://mosharafmanu.com
 * Text Domain: webo-elementor-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WEBO_ELEMENTOR_WIDGETS_VERSION', '1.0.0' );
define( 'WEBO_ELEMENTOR_WIDGETS_FILE', __FILE__ );
define( 'WEBO_ELEMENTOR_WIDGETS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WEBO_ELEMENTOR_WIDGETS_URL', plugin_dir_url( __FILE__ ) );

require_once WEBO_ELEMENTOR_WIDGETS_PATH . 'includes/class-plugin.php';

Webo_Elementor_Widgets\Plugin::instance();