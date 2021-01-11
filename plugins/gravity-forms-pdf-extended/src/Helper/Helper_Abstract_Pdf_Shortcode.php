<?php

namespace GFPDF\Helper;

use GFPDF\Exceptions\GravityPdfShortcodeEntryIdException;
use GFPDF\Exceptions\GravityPdfShortcodePdfConditionalLogicFailedException;
use GFPDF\Exceptions\GravityPdfShortcodePdfConfigNotFoundException;
use GFPDF\Exceptions\GravityPdfShortcodePdfInactiveException;
use Psr\Log\LoggerInterface;

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
 * Class Helper_Abstract_Pdf_Shortcode
 *
 * @package GFPDF\Helper
 *
 * @since   5.2
 */
abstract class Helper_Abstract_Pdf_Shortcode extends Helper_Abstract_Model {

	/**
	 * Set this constant to the Shortcode ID you're using
	 * @since 5.2
	 */
	const SHORTCODE = '';

	/**
	 * @var Helper_Abstract_Form
	 * @since 5.2
	 */
	protected $gform;

	/**
	 * @var LoggerInterface
	 * @since 5.2
	 */
	protected $log;

	/**
	 * @var Helper_Abstract_Options
	 * @since 5.2
	 */
	protected $options;

	/**
	 * @var Helper_Misc
	 * @since 5.2
	 */
	protected $misc;

	/**
	 * @var Helper_Interface_Url_Signer
	 * @since 5.2
	 */
	protected $url_signer;

	/**
	 * Helper_Abstract_Pdf_Shortcode constructor.
	 *
	 * @param Helper_Abstract_Form        $gform
	 * @param LoggerInterface             $log
	 * @param Helper_Abstract_Options     $options
	 * @param Helper_Misc                 $misc
	 * @param Helper_Interface_Url_Signer $url_signer
	 *
	 * @since 5.2
	 */
	public function __construct( Helper_Abstract_Form $gform, LoggerInterface $log, Helper_Abstract_Options $options, Helper_Misc $misc, Helper_Interface_Url_Signer $url_signer ) {
		$this->gform      = $gform;
		$this->log        = $log;
		$this->options    = $options;
		$this->misc       = $misc;
		$this->url_signer = $url_signer;
	}

	/**
	 * Generate the mark-up for the shortcode
	 *
	 * @param array $attributes The shortcode attributes specified
	 *
	 * @return string
	 *
	 * @since 4.0
	 */
	public abstract function process( $attributes );

	/**
	 * Try get the Entry ID from specific $_GET keys
	 *
	 * @param int $entry_id
	 *
	 * @return int
	 *
	 * @throws GravityPdfShortcodeEntryIdException
	 *
	 * @since 5.2
	 */
	protected function get_entry_id_if_empty( $entry_id ) {
		if ( ! empty( $entry_id ) ) {
			return $entry_id;
		}

		if ( isset( $_GET['lid'] ) || isset( $_GET['entry'] ) ) {
			return isset( $_GET['lid'] ) ? (int) $_GET['lid'] : (int) $_GET['entry'];
		}

		throw new GravityPdfShortcodeEntryIdException();
	}

	/**
	 * Get a valid PDF configuration
	 *
	 * @param int    $entry_id The Gravity Forms Entry ID
	 * @param string $pdf_id   The Gravity PDF ID
	 *
	 * @return array
	 *
	 * @throws GravityPdfShortcodePdfConditionalLogicFailedException
	 * @throws GravityPdfShortcodePdfConfigNotFoundException
	 * @throws GravityPdfShortcodePdfInactiveException
	 *
	 * @since 5.2
	 */
	protected function get_pdf_config( $entry_id, $pdf_id ) {
		$entry    = $this->gform->get_entry( $entry_id );
		$settings = ! is_wp_error( $entry ) ? \GPDFAPI::get_pdf( $entry['form_id'], $pdf_id ) : $entry;

		if ( is_wp_error( $settings ) ) {
			throw new GravityPdfShortcodePdfConfigNotFoundException();
		}

		if ( $settings['active'] !== true ) {
			throw new GravityPdfShortcodePdfInactiveException();
		}

		if ( isset( $settings['conditionalLogic'] ) && ! $this->misc->evaluate_conditional_logic( $settings['conditionalLogic'], $entry ) ) {
			throw new GravityPdfShortcodePdfConditionalLogicFailedException();
		}

		return $settings;
	}

	/**
	 * Update our Gravity Forms "Text" Confirmation Shortcode to include the current entry ID
	 *
	 * @param string|array $confirmation The confirmation text
	 * @param array        $form         The Gravity Form array
	 * @param array        $entry        The Gravity Form entry information
	 *
	 * @return string|array               The confirmation text
	 *
	 * @since 4.0
	 */
	public function gravitypdf_confirmation( $confirmation, $form, $entry ) {

		/**
		 * Do nothing if WP_Error is passed
		 *
		 * This resolves a conflict with a third party GF plugin which was passing an error instead of the expected GF confirmation response
		 * @see https://github.com/GravityPDF/gravity-pdf/issues/999
		 */
		if ( is_wp_error( $confirmation ) || is_wp_error( $form ) || is_wp_error( $entry ) ) {
			return $confirmation;
		}

		if ( isset( $form['confirmation']['type'] ) && $form['confirmation']['type'] === 'message' ) {
			$confirmation = $this->add_entry_id_to_shortcode( $confirmation, $entry['id'] );
		}

		return $confirmation;
	}

	/**
	 * Update our Gravity Forms Notification Shortcode to include the current entry ID
	 *
	 * @param array $notification The notification
	 * @param array $form         The Gravity Form array
	 * @param array $entry        The Gravity Form entry information
	 *
	 * @return array               The notification
	 *
	 * @since 4.0
	 */
	public function gravitypdf_notification( $notification, $form, $entry ) {

		/**
		 * Do nothing if WP_Error is passed
		 *
		 * This resolves a conflict with a third party GF plugin which was passing an error instead of the expected GF confirmation response
		 * @see https://github.com/GravityPDF/gravity-pdf/issues/999
		 */
		if ( is_wp_error( $notification ) || is_wp_error( $entry ) || empty( $entry['id'] ) ) {
			return $notification;
		}

		if ( isset( $notification['message'] ) ) {
			$notification['message'] = $this->add_entry_id_to_shortcode( $notification['message'], $entry['id'] );
		}

		return $notification;
	}

	/**
	 * Add basic GravityView support and parse the Custom Content field for the [gravitypdf] shortcode
	 * This means users can copy and paste our sample shortcode without having to worry about an entry ID being passed.
	 *
	 * @param string $html
	 *
	 * @return string
	 *
	 * @since 4.0
	 */
	public function gravitypdf_gravityview_custom( $html ) {

		if ( ! class_exists( '\GravityView_View' ) ) {
			return $html;
		}

		$gravityview_view = \GravityView_View::getInstance();
		$entry            = $gravityview_view->getCurrentEntry();

		return $this->add_entry_id_to_shortcode( $html, $entry['id'] );
	}

	/**
	 * Check for the shortcode and add the entry ID to it
	 *
	 * @param string $string   The text to search
	 * @param int    $entry_id The entry ID to add to our shortcode
	 *
	 * @return string
	 *
	 * @since 4.0
	 */
	protected function add_entry_id_to_shortcode( $string, $entry_id ) {
		/* Check if our shortcode exists and add the entry ID if needed */
		$shortcode_information = $this->get_shortcode_information( static::SHORTCODE, $string );

		if ( count( $shortcode_information ) > 0 ) {
			foreach ( $shortcode_information as $shortcode ) {
				/* if the user hasn't explicitely defined an entry to display... */
				if ( ! isset( $shortcode['attr']['entry'] ) ) {
					/* get the new shortcode information and update confirmation message */
					$new_shortcode = $this->add_shortcode_attr( $shortcode, 'entry', $entry_id );
					$string        = str_replace( $shortcode['shortcode'], $new_shortcode['shortcode'], $string );
				}
			}
		}

		return $string;
	}

	/**
	 * Update a shortcode attributes
	 *
	 * @param array  $code  In individual shortcode array pulled in from the $this->get_shortcode_information() function
	 * @param string $attr  The attribute to add / replace
	 * @param string $value The new attribute value
	 *
	 * @return array
	 *
	 * @since 4.0
	 */
	public function add_shortcode_attr( $code, $attr, $value ) {

		/* if the attribute doesn't already exist... */
		if ( ! isset( $code['attr'][ $attr ] ) ) {

			$raw_attr = "{$code['attr_raw']} {$attr}=\"{$value}\"";

			/* if there are no attributes at all we'll need to fix our str replace */
			if ( strlen( $code['attr_raw'] ) === 0 ) {
				$pattern           = '^\[([a-zA-Z]+)';
				$code['shortcode'] = preg_replace( "/$pattern/s", "[$1 {$attr}=\"{$value}\"", $code['shortcode'] );
			} else {
				$code['shortcode'] = str_ireplace( $code['attr_raw'], $raw_attr, $code['shortcode'] );
			}

			$code['attr_raw'] = $raw_attr;

		} else { /* replace the current attribute */
			$pattern           = $attr . '="(.+?)"';
			$code['shortcode'] = preg_replace( "/$pattern/si", $attr . '="' . $value . '"', $code['shortcode'] );
			$code['attr_raw']  = preg_replace( "/$pattern/si", $attr . '="' . $value . '"', $code['attr_raw'] );
		}

		/* Update the actual attribute */
		$code['attr'][ $attr ] = $value;

		return $code;
	}

	/**
	 * Check if user is currently submitting a new confirmation redirect URL in the admin area,
	 * if so replace any shortcodes with a version that will be correctly saved and generated
	 *
	 * @param array $form Gravity Form Array
	 *
	 * @return array
	 *
	 * @since 4.0
	 */
	public function gravitypdf_redirect_confirmation( $form ) {

		/* check if the confirmation is currently being saved */
		if ( isset( $_POST['form_confirmation_url'] ) ) {

			$this->log->notice(
				'Begin Converting Shortcode to URL for Redirect Confirmation',
				[
					'form_id' => $form['id'],
					'post'    => $_POST,
				]
			);

			$url = stripslashes_deep( $_POST['form_confirmation_url'] );

			/* check if our shortcode exists and convert it to a URL */
			$shortcode_information = $this->get_shortcode_information( static::SHORTCODE, $url );

			if ( count( $shortcode_information ) > 0 ) {
				foreach ( $shortcode_information as $shortcode ) {
					$new_shortcode = $this->add_shortcode_attr( $shortcode, 'entry', '{entry_id}' );
					$new_shortcode = $this->add_shortcode_attr( $new_shortcode, 'raw', '1' );

					/* update our confirmation message */
					$_POST['form_confirmation_url'] = str_replace( $shortcode['shortcode'], $new_shortcode['shortcode'], $url );
				}
			}
		}

		return $form;
	}

	/**
	 * If a Redirect Confirmation, convert the Gravity PDF shortcode to it's URL form, if one exists
	 *
	 * @param string|array $confirmation
	 * @param array        $form
	 * @param array        $entry
	 *
	 * @return string|array
	 *
	 * @since 5.1
	 */
	public function gravitypdf_redirect_confirmation_shortcode_processing( $confirmation, $form, $entry ) {

		/**
		 * Do nothing if WP_Error is passed
		 * This resolves a conflict with a third party GF plugin which was passing an error instead of the expected GF confirmation response
		 * @see https://github.com/GravityPDF/gravity-pdf/issues/999
		 */
		if ( is_wp_error( $confirmation ) || is_wp_error( $form ) || is_wp_error( $entry ) ) {
			return $confirmation;
		}

		if ( $form['confirmation']['type'] === 'redirect' ) {
			$shortcode_information = $this->get_shortcode_information( static::SHORTCODE, $form['confirmation']['url'] );

			if ( count( $shortcode_information ) > 0 ) {
				$confirmation = [ 'redirect' => '' ];

				foreach ( $shortcode_information as $shortcode ) {
					$url = do_shortcode( str_replace( '{entry_id}', $entry['id'], $shortcode['shortcode'] ) );

					/* Add Query string parameters if they exist (but not with signed URLs) */
					$has_query_string = strrpos( $form['confirmation']['url'], '?' );
					if ( $has_query_string !== false ) {
						$query_string = substr( $form['confirmation']['url'], $has_query_string + 1 );
						if ( empty( $shortcode['attr']['signed'] ) && strlen( $query_string ) > 0 ) {
							$url .= ( strpos( $url, '?' ) !== false ) ? '&' . $query_string : '?' . $query_string;
						}
					}

					$form['confirmation']['url'] = str_replace( $shortcode['shortcode'], $url, $form['confirmation']['url'] );
				}

				$confirmation['redirect'] = $form['confirmation']['url'];
			}
		}

		return $confirmation;
	}

	/**
	 * Search for any shortcodes in the text and return any matches
	 *
	 * @param string $shortcode The shortcode to search for
	 * @param string $text      The text to search in
	 *
	 * @return array             The shortcode information
	 *
	 * @since 4.0
	 */
	public function get_shortcode_information( $shortcode, $text ) {
		$shortcodes = [];

		if ( ! is_string( $text ) ) {
			$this->log->error(
				'The $text parameter is not a string',
				[
					'shortcode' => $shortcode,
					'text'      => $text,
				]
			);

			return $shortcodes;
		}

		if ( has_shortcode( $text, $shortcode ) ) {
			/* our shortcode exists so parse the shortcode data and return an easy-to-use array */
			preg_match_all( '/' . get_shortcode_regex( [ $shortcode ] ) . '/', $text, $matches, PREG_SET_ORDER );

			if ( empty( $matches ) ) {
				return $shortcodes;
			}

			foreach ( $matches as $item ) {
				if ( $shortcode === $item[2] ) {
					$attr = shortcode_parse_atts( $item[3] );

					$shortcodes[] = [
						'shortcode' => $item[0],
						'attr_raw'  => $item[3],
						'attr'      => is_array( $attr ) ? $attr : [],
					];
				}
			}
		}

		return $shortcodes;
	}
}
