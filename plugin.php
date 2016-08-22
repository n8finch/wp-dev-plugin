<?php
/**
 * Starter WordPress Plugin
 *
 * @package     n8finch
 * @author      Nate Finch
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Starter WordPress Plugin
 * Plugin URI:  https://n8finch.com
 * Description: Know the Code Starter Sandbox plugin.  Use this plugin for all of the Know the Code demo Labs and Docx.
 * Version:     1.0.0
 * Author:      Nate Finch
 * Author URI:  https://n8finch.com
 * Text Domain: n8finch
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
namespace KnowTheCode;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

/**
 * Load Kint and Whoops
 */
require_once( __DIR__ . '/assets/vendor/autoload.php' );

/**
 * Load Koop Debug
 */
require_once( __DIR__ . '/src/support/koop-debug.php' );


