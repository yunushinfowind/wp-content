<?php
/*
Template Name: Page With Sidebar
*/

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'custom_genesis_standard_loop' );

remove_action( 'genesis_after_content', 'genesis_get_sidebar' );


function custom_genesis_standard_loop() {

	printf( '<section class="subpage-container"><div class="wrap">' );

		echo '<div class="three-fourths first">';

		//* Use old loop hook structure if not supporting HTML5
		if ( ! genesis_html5() ) {
			genesis_legacy_loop();
			return;
		}

		if ( have_posts() ) :

			do_action( 'genesis_before_while' );
			while ( have_posts() ) : the_post();

				do_action( 'genesis_before_entry' );

				printf( '<article %s>', genesis_attr( 'entry' ) );

					do_action( 'genesis_entry_header' );

					do_action( 'genesis_before_entry_content' );

					printf( '<div %s>', genesis_attr( 'entry-content' ) );
					do_action( 'genesis_entry_content' );
					echo '</div>';

					do_action( 'genesis_after_entry_content' );

					do_action( 'genesis_entry_footer' );

				echo '</article>';

				do_action( 'genesis_after_entry' );

			endwhile; //* end of one post
			do_action( 'genesis_after_endwhile' );

		else : //* if no posts exist
			do_action( 'genesis_loop_else' );
		endif; //* end loop

		echo '</div>';

		echo '<div class="one-fourth sidebar sidebar-alt widget-area">'; 
			dynamic_sidebar( 'primary-sidebar' );
		echo '</div>';

	echo '</div></section>';

}
//* Remove edit link
add_filter( 'genesis_edit_post_link' , '__return_false' );
genesis();