<?php

namespace GFPDF\Helper\Fields;

use GFPDF\Helper\Helper_Abstract_Form;
use GFPDF\Helper\Helper_Misc;
use GFPDF\Helper\Helper_Abstract_Fields;

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
class Field_Post_Custom_Field extends Helper_Abstract_Fields {

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

		/* call our parent method */
		parent::__construct( $field, $entry, $gform, $misc );

		/*
		 * Custom Field can be any of the following field types:
		 * single line text, paragraph, dropdown, select, number, checkbox, radio, hidden,
		 * date, time, phone, website, email, file upload or list
		 */
		$class = $this->misc->get_field_class( $field->inputType );

		try {
			/* check load our class */
			if ( class_exists( $class ) ) {

				/* See https://gravitypdf.com/documentation/v5/gfpdf_field_class/ for more details about these filters */
				$this->fieldObject = apply_filters( 'gfpdf_field_class', new $class( $field, $entry, $gform, $misc ), $field, $entry, $this->form );
				$this->fieldObject = apply_filters( 'gfpdf_field_class_' . $field->inputType, $this->fieldObject, $field, $entry, $this->form );
			} else {
				throw new Exception( 'Class not found' );
			}
		} catch ( Exception $e ) {
			/* Exception thrown. Load generic field loader */
			$this->fieldObject = apply_filters( 'gfpdf_field_default_class', new Field_Default( $field, $entry, $gform, $misc ), $field, $entry, $this->form );
		}

		/* force the fieldObject value cache */
		$this->value();
	}

	/**
	 * Used to check if the current field has a value
	 *
	 * @since 4.0
	 */
	public function is_empty() {
		return $this->fieldObject->is_empty();
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
		return $this->fieldObject->html();
	}

	/**
	 * Return the correct form data information for the selected fields
	 *
	 * @return array
	 *
	 * @since 4.0
	 */
	public function form_data() {
		if ( method_exists( $this->fieldObject, 'form_data' ) ) {
			return $this->fieldObject->form_data();
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
		if ( $this->fieldObject->has_cache() ) {
			return $this->fieldObject->cache();
		}

		$value = $this->fieldObject->value();

		$this->fieldObject->cache( $value );

		return $this->fieldObject->cache();
	}
}
