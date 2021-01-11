<?php

/*
Template Name: Blank Adwords Landing Page
*/

// Add custom body class to the head
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'landing-page';
   return $classes;
}

// Remove header, navigation, breadcrumbs, footer widgets, footer 
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_header', 'header_widget', 12 );
remove_theme_support( 'genesis-menus' );
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs');
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action ( 'genesis_footer', 'genesis_footer_widget_areas', 5 );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_after_header', 'genesis_do_nav', 12 );
remove_action( 'genesis_before_loop', 'subpage_header' );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'custom_genesis_standard_loop' );

remove_action( 'genesis_after_content', 'genesis_get_sidebar' );


function custom_genesis_standard_loop() {

	//* Use old loop hook structure if not supporting HTML5
	if ( ! genesis_html5() ) {
		genesis_legacy_loop();
		return;
	}

	if ( have_posts() ) :

		do_action( 'genesis_before_while' );
		while ( have_posts() ) : the_post();

			printf( '<section class="subpage-container">' );

					printf( '<article %s>', genesis_attr( 'entry' ) );

							do_action( 'genesis_before_entry_content' );

								printf( '<div %s>', genesis_attr( 'entry-content' ) );
									do_action( 'genesis_entry_content' );
								echo '</div>';

								do_action( 'genesis_after_entry_content' );

								do_action( 'genesis_entry_footer' );

					echo '</article>';

			echo '</section>';

			do_action( 'genesis_after_entry' );

		endwhile; //* end of one post
		do_action( 'genesis_after_endwhile' );

		dynamic_sidebar( 'footer-banner-widget' ); 

	else : //* if no posts exist
		do_action( 'genesis_loop_else' );
	endif; //* end loop

}
//* Remove edit link
add_filter( 'genesis_edit_post_link' , '__return_false' );
genesis();