<?php

/**
 * PDF Conditional Logic not met
 *
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2020, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<pre class="gravitypdf-error">
	<?php esc_html_e( 'PDF link not displayed because conditional logic requirements have not been met.', 'gravity-forms-pdf-extended' ); ?>
	<small><?php esc_html_e( '(Admin Only Message)', 'gravity-forms-pdf-extended' ); ?></small>
</pre>
