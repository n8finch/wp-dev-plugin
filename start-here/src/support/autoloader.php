<?php
/**
 * File autoloader functionality
 *
 * @package     YetAnotherSocialShare\Support
 * @since       1.0.0
 * @author      Nate Finch
 * @link        https://n8finch.com
 * @license     GNU General Public License 2.0+
 */
namespace YetAnotherSocialShare\Support;

/**
 * Load all of the plugin's files.
 *
 * @since 1.0.0
 *
 * @param string $src_root_dir Root directory for the source files
 *
 * @return void
 */
function yass_autoload_files( $src_root_dir ) {

	$filenames = array(
		 'custom/main',
	);

	foreach( $filenames as $filename ) {
		include_once( $src_root_dir . $filename . '.php' );
	}
}
