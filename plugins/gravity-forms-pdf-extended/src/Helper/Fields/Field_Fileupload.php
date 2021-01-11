<?php

namespace GFPDF\Helper\Fields;

use GFPDF\Helper\Helper_Abstract_Form;
use GFPDF\Helper\Helper_Misc;
use GFPDF\Helper\Helper_Abstract_Fields;

use GF_Field_FileUpload;

use Exception;

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
 * Controls the display and output of a Gravity Form field
 *
 * @since 4.0
 */
class Field_Fileupload extends Helper_Abstract_Fields {

	/**
	 * Check the appropriate variables are parsed in send to the parent construct
	 *
	 * @param object                             $field The GF_Field_* Object
	 * @param array                              $entry The Gravity Forms Entry
	 *
	 * @param \GFPDF\Helper\Helper_Abstract_Form $gform
	 * @param \GFPDF\Helper\Helper_Misc          $misc
	 *
	 * @throws Exception
	 *
	 * @since 4.0
	 */
	public function __construct( $field, $entry, Helper_Abstract_Form $gform, Helper_Misc $misc ) {

		if ( ! is_object( $field ) || ! $field instanceof GF_Field_FileUpload ) {
			throw new Exception( '$field needs to be in instance of GF_Field_FileUpload' );
		}

		/* call our parent method */
		parent::__construct( $field, $entry, $gform, $misc );
	}

	/**
	 * Return the HTML form data
	 *
	 * @return array
	 * @since 4.0
	 */
	public function form_data() {

		$data     = [];
		$label    = $this->get_label();
		$value    = $this->value();
		$field_id = $this->field->id;

		/* Backwards compatibility support for v3 */
		if ( 0 === sizeof( $value ) ) {
			$data[ $field_id . '.' . $label ] = [];
			$data[ $field_id ]                = [];
			$data[ $label ]                   = [];

			/* Path Format */
			$data[ $field_id . '_path' ]                = [];
			$data[ $field_id . '.' . $label . '_path' ] = [];
		}

		foreach ( $value as $image ) {

			$data[ $field_id . '.' . $label ][] = $image;
			$data[ $field_id ][]                = $image;
			$data[ $label ][]                   = $image;

			$path = $this->misc->convert_url_to_path( $image );

			$data[ $field_id . '_path' ][]                = $path;
			$data[ $field_id . '.' . $label . '_path' ][] = $path;
		}

		return [ 'field' => $data ];
	}

	/**
	 * Display the HTML version of this field
	 *
	 * @param string $value
	 * @param bool   $label
	 *
	 * @return string
	 * @since 4.0
	 */
	public function html( $value = '', $label = true ) {
		$files = $this->value();
		$html  = '';

		if ( sizeof( $files ) > 0 ) {
			$html = '<ul class="bulleted fileupload">';
			$i    = 1;

			foreach ( $files as $file ) {
				$file_info = pathinfo( $file );
				$html     .= '<li id="field-' . $this->field->id . '-option-' . $i . '"><a href="' . esc_url( $file ) . '">' . esc_html( $file_info['basename'] ) . '</a></li>';
				$i++;
			}

			$html .= '</ul>';
		}

		return parent::html( $html );
	}

	/**
	 * Get the standard GF value of this field
	 *
	 * @return string|array
	 * @since 4.0
	 */
	public function value() {
		if ( $this->has_cache() ) {
			return $this->cache();
		}

		$value = $this->get_value();
		$files = [];

		if ( ! empty( $value ) ) {
			$paths = ( $this->field->multipleFiles ) ? json_decode( $value ) : [ $value ];

			if ( is_array( $paths ) && sizeof( $paths ) > 0 ) {
				foreach ( $paths as $path ) {
					$files[] = esc_url( $path );
				}
			}
		}

		$this->cache( $files );

		return $this->cache();
	}
}
