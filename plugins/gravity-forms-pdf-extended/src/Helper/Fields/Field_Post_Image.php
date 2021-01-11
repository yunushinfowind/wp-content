<?php

namespace GFPDF\Helper\Fields;

use GFPDF\Helper\Helper_Abstract_Form;
use GFPDF\Helper\Helper_Misc;
use GFPDF\Helper\Helper_Abstract_Fields;

use GF_Field_Post_Image;

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
class Field_Post_Image extends Helper_Abstract_Fields {

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

		if ( ! is_object( $field ) || ! $field instanceof GF_Field_Post_Image ) {
			throw new Exception( '$field needs to be in instance of GF_Field_Post_Image' );
		}

		/* call our parent method */
		parent::__construct( $field, $entry, $gform, $misc );
	}

	/**
	 * Display the HTML version of this field
	 *
	 * @param string $value
	 * @param bool   $label
	 *
	 * @return string
	 *
	 * @since 4.0
	 */
	public function html( $value = '', $label = true ) {
		$value = $this->value();

		$html = '';
		if ( ! empty( $value['url'] ) ) {
			$html  = '<a href="' . $value['url'] . '" target="_blank">';
			$html .= '<img width="150" src="' . $value['url'] . '" />';
		}

		/* Include title / caption / description if needed */
		if ( ! empty( $value['title'] ) ) {
			$html .= '<div class="gfpdf-post-image-title">' . $value['title'] . '</div>';
		}

		if ( ! empty( $value['caption'] ) ) {
			$html .= '<div class="gfpdf-post-image-caption">' . $value['caption'] . '</div>';
		}

		if ( ! empty( $value['description'] ) ) {
			$html .= '<div class="gfpdf-post-image-description">' . $value['description'] . '</div>';
		}

		$html .= '</a>';

		return parent::html( $html );
	}

	/**
	 * Return the HTML form data
	 *
	 * @return array
	 *
	 * @since 4.0
	 *
	 */
	public function form_data() {
		$value = $this->value();
		$label = $this->get_label();

		if ( 0 === sizeof( $value ) ) {
			$data = [];

			$data['field'][ $this->field->id . '.' . $label ] = '';
			$data['field'][ $this->field->id ]                = '';
			$data['field'][ $label ]                          = '';

			return $data;
		}

		return parent::form_data();
	}

	/**
	 * Get the standard GF value of this field
	 *
	 * @return string|array
	 *
	 * @since 4.0
	 */
	public function value() {

		if ( $this->has_cache() ) {
			return $this->cache();
		}

		$value = $this->get_value();
		$img   = [];

		if ( strlen( $value ) > 0 ) {
			$value = explode( '|:|', $this->get_value() );

			$img['url']         = ( isset( $value[0] ) ) ? esc_url( $value[0] ) : '';
			$img['path']        = ( isset( $value[0] ) ) ? esc_url( $value[0] ) : '';
			$img['title']       = ( isset( $value[1] ) ) ? esc_html( $value[1] ) : '';
			$img['caption']     = ( isset( $value[2] ) ) ? esc_html( $value[2] ) : '';
			$img['description'] = ( isset( $value[3] ) ) ? esc_html( $value[3] ) : '';

			$path = ( isset( $value[0] ) ) ? $this->misc->convert_url_to_path( $value[0] ) : '';
			if ( $path !== $img['url'] ) {
				$img['path'] = $path;
			}
		}

		$this->cache( $img );

		return $this->cache();
	}
}
