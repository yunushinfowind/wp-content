<?php

remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_before_entry_content', 'genesis_do_breadcrumbs' );
//add_action( 'loop_start', 'genesis_do_breadcrumbs' );

//* Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */

function genesis_404() {

	printf( '<section class="subpage-container"><div class="wrap">' );

		echo genesis_html5() ? '<article class="entry">' : '<div class="post hentry">';

		echo '<div class="entry-content">';

			if ( genesis_html5() ) :

				echo apply_filters( 'genesis_404_entry_content', '<p>' . sprintf( __( 'The page you are looking could not be found, sorry!<br/><br/> Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below:', 'genesis' ), trailingslashit( home_url() ) ) . '</p>' );

				get_search_form();

			endif;

			if ( ! genesis_html5() ) {
				genesis_sitemap( 'h4' );
			} elseif ( genesis_a11y( '404-page' ) ) {
				echo '<h2>' . __( 'Sitemap', 'genesis' ) . '</h2>';
				genesis_sitemap( 'h3' );
			}

			echo '</div>';

		echo genesis_html5() ? '</article>' : '</div>';;

	echo '</div></section>';

}
//* Run the Genesis loop
genesis();
