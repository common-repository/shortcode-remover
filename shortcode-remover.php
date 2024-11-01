<?php 
/*
	Plugin Name: Shortcode Remover
	Plugin URI:  https://latetotheparty.nl/
	Description: Filters out old shortcodes
	Version:     1.0.0
	Author:      Gyurka Jansen
	Author URI:  https://gyurka.nl/ 
*/

/*
 * Filter out unused shortcodes
 */ 		

function ltp_shortcode_filter( $content ) {
	global $shortcode_tags;

	//Check for active shortcodes
	if ( ( is_array( $shortcode_tags ) && !empty( $shortcode_tags ) ) ) {
		$active_shortcodes = array_keys( $shortcode_tags ); //fill with shortcodes if there are active shortcodes
	} else {
		$active_shortcodes = array();
	}

	//Remove active shortcodes
	if(!empty($active_shortcodes)) {
		$active_shortcodes = implode("|", $active_shortcodes);
		$content = preg_replace( "~(?:\[/?)(?!(?:$active_shortcodes))[^/\]]+/?\].*(?:\[/?)(?!(?:$active_shortcodes))[^/\]]+/?\]~m", '', $content );
		$content = preg_replace( "~(?:\[/?)(?!(?:$active_shortcodes))[^/\]]+/?\]~m", '', $content );
	} else {
		$content = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $content);			
	}
	return $content;
}

/*
 * Hooks and filters
 */ 

add_filter('the_content', 'ltp_shortcode_filter', 0);

?>