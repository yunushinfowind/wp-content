<?php
/**
 * The template for displaying search forms in Marketify
 *
 * @package Marketify
 */
?>

<div class="header-search">

	<form method="get" class="search-form<?php echo '' != get_search_query() ? ' active' : ''; ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		
		<label>
			<span class="screen-reader-text"><?php _ex( 'Search # or Keyword', 'label', 'southernhoney' ); ?></span>
			<input type="search" class="search-field" placeholder="Search # or Keyword" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr__( 'Search for:', 'casters' ); ?>">
			<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
		</label>
		<input type="hidden" name="post_type" value="product" />
	</form>

</div>