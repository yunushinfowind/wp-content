<?php

remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'custom_genesis_standard_loop' );

remove_action( 'genesis_after_content', 'genesis_get_sidebar' );

function custom_genesis_standard_loop() {

	//* Use old loop hook structure if not supporting HTML5
	if ( ! genesis_html5() ) {
		genesis_legacy_loop();
		return;
	}

	if ( have_posts() ) : ?>

		<section class="blog-posts">
			<div class="wrap">
				<h1><?php echo get_the_archive_title() ?></h1>

				<div class="row">
					<?php do_action( 'genesis_before_while' ); while ( have_posts() ) : the_post(); $blog_ID = get_the_ID();
						if ( has_post_thumbnail() ) $feat_img = wp_get_attachment_url( get_post_thumbnail_id( $blog_ID ) ); 
	           			else $feat_img = get_stylesheet_directory_uri() . '/images/placeholder.png';  ?>

						<div class="one-third">
							<div class="feat-img" style="background-image: url(<?php echo $feat_img ?>)"></div>

							<?php do_action( 'genesis_before_entry' );

								printf( '<article %s>', genesis_attr( 'entry' ) );

									do_action( 'genesis_entry_header' );

									do_action( 'genesis_entry_footer' );

									do_action( 'genesis_before_entry_content' );

										printf( '<div %s>', genesis_attr( 'entry-content' ) );
											// do_action( 'genesis_entry_content' );

											echo wp_trim_words( get_the_content(), 40, '...' ); ?>

											<a href="<?php the_permalink() ?>" title="Read More" class="readmore">Read More</a>

										<?php echo '</div>';

									do_action( 'genesis_after_entry_content' );

								echo '</article>';

							do_action( 'genesis_after_entry' ); ?>
							
						</div>

					<?php endwhile; ?>
				</div>

				<?php do_action( 'genesis_after_endwhile' ); ?>
			</div>
		</section><!-- /.blog-posts -->

	<?php else : //* if no posts exist
		do_action( 'genesis_loop_else' );
	endif; //* end loop 

	echo do_shortcode('[fl_builder_insert_layout id="9014"]'); // RAVE REVIEWS
	echo do_shortcode('[fl_builder_insert_layout id="9015"]'); // Want to grow your student base
	echo do_shortcode('[fl_builder_insert_layout id="9017"]'); // Schedule your free risk lesson today

}
//* Remove edit link
add_filter( 'genesis_edit_post_link' , '__return_false' );
genesis();