<?php
/**
 * This file adds the Home Page to the Parallax Pro Theme.
 *
 * @author StudioPress
 * @package Parallax
 * @subpackage Customizations
 */

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Add parallax-home body class
add_filter( 'body_class', 'parallax_body_class' );
function parallax_body_class( $classes ) {

	$classes[] = 'home';
	return $classes;
	
}
 
add_action( 'genesis_loop', 'custom_homepage' );

// Hides Entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 1);
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
 
function custom_homepage() { 
global $blogurl;
?>


<!--Home-Top  ENDS HERE-->

    
<?php }
//* Remove edit link
add_filter( 'genesis_edit_post_link' , '__return_false' );
//* Run the Genesis loop
genesis();
