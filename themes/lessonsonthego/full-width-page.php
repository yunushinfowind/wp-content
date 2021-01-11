<?php
/**
 *
 * @author Trive Internet Marketing
 * @link http://thrivenetmarketing.com/
 * @package Thrive
 * @subpackage Customizations
 */

/*
Template Name: Full Width Template (Edge to Edge)
*/


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

			do_action( 'genesis_before_entry' );

			printf( '<section class="full-width">' );

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