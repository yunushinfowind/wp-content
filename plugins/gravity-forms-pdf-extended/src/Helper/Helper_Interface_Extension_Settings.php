<?php

namespace GFPDF\Helper;

/**
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2020, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A simple interface to standardise how actions and filters should be applied in classes
 *
 * @since 4.2
 */
interface Helper_Interface_Extension_Settings {

	/**
	 * Return an array of fields that should be registered in the addon. See Helper_OPtions_Fields for examples of
	 * defining fields
	 *
	 * @Internal All fields should be prefixed with the add-on slug.
	 *
	 * @since 4.2
	 *
	 * @return array
	 */
	public function get_global_addon_fields();
}
