<?php
/**
 * Plugin Name: Koop Debug
 * Plugin URI: http://kopepasah.com
 * Description: Debugger
 * Version: 0.1
 * Author: Justin Kopepasah
 * Author URI: http://kopepasah.com
 * License: GPL2
 */



function koop_pad( $depth, $pad = '    ' ) {
	$retval = '';
	
	for ( $x = 0; $x <= $depth; $x++ )
		$retval .= $pad;
	
	return $retval;
}


function pr( $data, $args = array() ) {
			if ( is_string( $args ) )
				$args = array( 'description' => $args );
			else if ( is_bool( $args ) )
				$args = array( 'expand_objects' => $args );
			else if ( is_numeric( $args ) )
				$args = array( 'max_depth' => $args );
			else if ( ! is_array( $args ) )
				$args = array();
			
			
			$default_args = array(
				'description'    => '',
				'expand_objects' => true,
				'max_depth'      => 10,
			);
			$args = array_merge( $default_args, $args );
			
			if ( ! empty( $args['description'] ) )
				$args['description'] .= "\n";
			
			
			// if ( version_compare( $GLOBALS['wp_version'], '3.7.10', '>' ) ) {
			// 	echo "<style>.wp-admin .it-debug-print-r { margin-left: 170px; } .wp-admin #wpcontent .it-debug-print-r { margin-left: 0; }</style>\n";
			// }
			
			echo "<pre style='color:black;background:white;padding:15px;margin: 15px;font-family:\"Courier New\",Courier,monospace;font-size:12px;white-space:pre-wrap;text-align:left;max-width:100%;' class='it-debug-print-r'>";

			if ( ! empty( $args['description'] ) ) {
				echo $args['description'];
			}

			koop_inspect( $data, $args );
			echo "</pre>\n";
		}

function koop_inspect( $data, $args = array() ) {

	
	
	// Create a deep copy so that variables aren't needlessly manipulated.
	$data = unserialize( serialize( $data ) );
	
	
	$default_args = array(
		'expand_objects' => false,
		'max_depth'      => 2,
		'echo'           => true,
	);
	$args = array_merge( $default_args, $args );
	
	if ( $args['max_depth'] < 1 )
		$args['max_depth'] = 100;
	
	
	$retval = koop_inspect_dive( $data, $args['expand_objects'], $args['max_depth'] );
	
	
	if ( $args['echo'] )
		echo $retval;
	
	return $retval;
}


function koop_inspect_dive( $data, $expand_objects, $max_depth, $depth = 0, $show_array_header = true ) {
	$pad = koop_pad( $depth, '    ' );
	
	if ( is_string( $data ) ) {
		if ( '' === $data )
			return "<strong>[empty string]</strong>";
		else
			return htmlspecialchars( $data );
	}
	
	if ( is_bool( $data ) )
		return ( $data ) ? '<strong>[boolean] true</strong>' : '<strong>[boolean] false</strong>';
	
	if ( is_null( $data ) )
		return '<strong>null</strong>';
	
	if ( is_object( $data ) ) {
		$class_name = get_class( $data );
		$retval = "<strong>Object</strong> $class_name";
		
		if ( ! $expand_objects || ( $depth == $max_depth ) )
			return $retval;
		
		$vars = get_object_vars( $data );
		
		if ( empty( $vars ) )
			$vars = '';
		else
			$vars = koop_inspect_dive( $vars, $expand_objects, $max_depth, $depth, false );
		
		$retval .= "$vars";
		
		return $retval;
	}
	
	if ( is_array( $data ) ) {
		$retval = ( $show_array_header ) ? '<strong>Array</strong>' : '';
		
		if ( empty( $data ) )
			return "$retval()";
		if ( $depth == $max_depth )
			return "$retval( " . count( $data ) . " )";
		
		$max = 0;
		
		foreach ( array_keys( $data ) as $index ) {
			if ( strlen( $index ) > $max )
				$max = strlen( $index );
		}
		
		foreach ( $data as $index => $val ) {
			$spaces = koop_pad( $max - strlen( $index ), ' ' );
			$retval .= "\n$pad" . htmlspecialchars( $index ) . "$spaces  <strong>=&gt;</strong> " . koop_inspect_dive( $val, $expand_objects, $max_depth, $depth + 1 );
		}
		
		return $retval;
	}
	
	return '<strong>[' . gettype( $data ) . ']</strong> ' . $data;
}