<?php

namespace GFPDF\Helper\Fields;

use GFPDF\Helper\Helper_Abstract_Fields;

use GFCommon;

/**
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2020, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Include any dependancies */
require_once( GFCommon::get_base_path() . '/currency.php' );

/**
 * Controls the display and output of a Gravity Form field
 *
 * @since 4.0
 */
class Field_Products extends Helper_Abstract_Fields {

	/**
	 * Checks if the form has any products
	 *
	 * @return boolean
	 *
	 * @since 4.0.2
	 */
	public function is_empty() {

		/* Set up the form / lead information */
		$form = $this->form;
		$lead = $this->entry;

		/* Get all products for this field */
		$products = GFCommon::get_product_fields( $form, $lead, true );

		if ( sizeof( $products['products'] ) > 0 ) {
			return false; /* not empty */
		}

		return true;
	}

	/**
	 * Return the HTML form data
	 *
	 * @return array
	 *
	 * @since 4.0
	 */
	public function form_data() {

		$data = $this->value();

		return $data;
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
		$products         = $this->value();
		$form_id          = $this->form['id'];
		$unordered_fields = $this->form['fields'];
		$fields           = [];

		foreach ( $unordered_fields as $field ) {
			$fields[ $field->id ] = $field;
		}

		/* start output buffer */
		ob_start();

		?>

		<div class="row-separator products-title-container">
			<h3 class="product-field-title gfpdf-field">
				<?php
				$label = apply_filters( 'gform_order_label', esc_html__( 'Order', 'gravityforms' ), $form_id );
				$label = apply_filters( 'gform_order_label_' . $form_id, $label, $form_id );

				echo $label;
				?>
			</h3>
		</div>

		<div class="row-separator products-container">
			<div class="gfpdf-field gfpdf-products">
				<div class="inner-container">
					<table class="entry-products" autosize="1">
						<tbody class="head">
						<tr>
							<th class="entry-products-col1">
								<?php
								$label = apply_filters( 'gform_product', esc_html__( 'Product', 'gravityforms' ), $form_id );
								$label = apply_filters( 'gform_product_' . $form_id, $label, $form_id );

								echo $label;
								?>
							</th>

							<th class="textcenter entry-products-col2">
								<?php
								$label = apply_filters( 'gform_product_qty', esc_html__( 'Qty', 'gravityforms' ), $form_id );
								$label = apply_filters( 'gform_product_qty_' . $form_id, $label, $form_id );

								echo $label;
								?>
							</th>
							<th class="entry-products-col3">
								<?php
								$label = apply_filters( 'gform_product_unitprice', esc_html__( 'Unit Price', 'gravityforms' ), $form_id );
								$label = apply_filters( 'gform_product_unitprice_' . $form_id, $label, $form_id );

								echo $label;
								?>
							</th>
							<th class="entry-products-col4">
								<?php
								$label = apply_filters( 'gform_product_price', esc_html__( 'Price', 'gravityforms' ), $form_id );
								$label = apply_filters( 'gform_product_price_' . $form_id, $label, $form_id );

								echo $label;
								?>
							</th>
						</tr>
						</tbody>

						<tbody class="contents">
						<?php
						foreach ( $products['products'] as $field_id => $product ) :

							/* Skip over Gravity Perks Ecommerce Fields */
							if ( class_exists( 'GP_Ecommerce_Fields' ) && in_array( $fields[ $field_id ]->type, [ 'tax', 'discount' ], true ) ) {
								continue;
							}
							?>
							<tr>
								<td>
									<div class="product_name">
										<?php echo $product['name']; ?>
									</div>

									<?php
									$price = $product['price_unformatted'];

									if ( count( $product['options'] ) > 0 ) :
										?>
										<ul class="product_options">
											<?php
											foreach ( $product['options'] as $option ) :
												$price += $option['price'];
												?>
												<li><?php echo $option['option_label']; ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</td>
								<td class="textcenter"><?php echo $product['quantity']; ?></td>
								<td class="textright"><?php echo GFCommon::format_number( $price, 'currency', rgar( $this->entry, 'currency' ) ); ?></td>
								<td class="textright"><?php echo $product['subtotal_formatted']; ?></td>
							</tr>
						<?php endforeach; ?>

						<?php
						if ( class_exists( 'GP_Ecommerce_Fields' ) ):
							$gpecommerce     = \GP_Ecommerce_Fields::get_instance( null );
							$use_value       = (bool) apply_filters( 'gfpdf_show_field_value', false, $this->field, '' ); /* Set to `true` to show a field's value instead of the label */
							$use_admin_label = (bool) apply_filters( 'gfpdf_use_admin_label', false, $this->field, '' ); /* Set to `true` to use the admin label */
							$order           = GFCommon::get_product_fields( $this->form, $this->entry, ! $use_value, $use_admin_label );
							$order_summary   = $gpecommerce->get_order_summary( $order, $this->form, $this->entry );
							?>
							<?php foreach ( $order_summary as $index => $group ): ?>
								<?php
								foreach ( $group as $item ):
									$class = rgar( $item, 'class' ) ? '.' . rgar( $item, 'class' ) : '';
									?>
									<tr style="<?php $gpecommerce->style( '.order-summary/tfoot/tr' . $class ); ?>">
										<?php if ( $index === 0 ): ?>
											<td class="emptycell"
												colspan="2"
												rowspan="<?php echo $gpecommerce->get_order_summary_item_count( $order_summary ); ?>"></td>
										<?php endif; ?>
										<td class="totals" style="<?php $gpecommerce->style( ".order-summary/tfoot/{$class}/td.column-3" ); ?>">
											<?php echo $item['name']; ?>
										</td>

										<td class="totals" style="<?php $gpecommerce->style( ".order-summary/tfoot/{$class}/td.column-4" ); ?>">
											<?php echo GFCommon::to_money( $item['price'], $this->entry['currency'] ); ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endforeach; ?>
						<?php else : ?>
							<?php if ( ! empty( $products['products_totals']['shipping_name'] ) ) : ?>
								<tr>
									<td rowspan="3" class="emptycell"></td>
									<td colspan="2"
										class="subtotal totals"><?php esc_html_e( 'Subtotal', 'gravity-forms-pdf-extended' ); ?></td>
									<td class="subtotal_amount totals"><?php echo $products['products_totals']['subtotal_formatted']; ?></td>
								</tr>
								<tr>
									<td colspan="2"
										class="shipping totals"><?php echo sprintf( esc_html__( 'Shipping (%s)', 'gravity-forms-pdf-extended' ), $products['products_totals']['shipping_name'] ); ?></td>
									<td class="shipping_amount totals"><?php echo $products['products_totals']['shipping_formatted']; ?></td>
								</tr>
							<?php endif; ?>

							<tr>
								<?php if ( empty( $products['products_totals']['shipping_name'] ) ) : ?>
									<td class="emptycell"></td>
								<?php endif; ?>

								<td colspan="2"
									class="grandtotal totals"><?php esc_html_e( 'Total', 'gravityforms' ); ?></td>
								<td class="grandtotal_amount totals"><?php echo $products['products_totals']['total_formatted']; ?></td>
							</tr>

						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<?php

		return apply_filters( 'gfpdf_field_product_value', ob_get_clean(), $products, $this->field, $this->form, $this->entry, $this );
	}

	/**
	 * Gravity Forms handles product fields in bulk as they are all linked together to get the order totals
	 * This class is used to handle this in bulk
	 *
	 * @return string|array
	 *
	 * @since 4.0
	 */
	public function value() {

		/* check if we have a value already stored in the cache */
		if ( $this->has_cache() ) {
			return $this->cache();
		}

		/* Set up the form / lead information */
		$form = $this->form;
		$lead = $this->entry;

		/* Get all products for this field */
		$use_value       = (bool) apply_filters( 'gfpdf_show_field_value', false, $this->field, '' ); /* Set to `true` to show a field's value instead of the label */
		$use_admin_label = (bool) apply_filters( 'gfpdf_use_admin_label', false, $this->field, '' ); /* Set to `true` to use the admin label */
		$products        = GFCommon::get_product_fields( $form, $lead, ! $use_value, $use_admin_label );

		/* Set up the appropriate varaibles needed for our product processing */
		$form_array  = []; /* holds the actual product data */
		$order_total = 0; /* holds the total cost of the order */

		/* check that there are actual product fields to process */
		if ( sizeof( $products['products'] ) > 0 ) {

			foreach ( $products['products'] as $id => $product ) {

				if ( class_exists( 'GP_Ecommerce_Fields' ) && empty( $product['name'] ) ) {
					continue;
				}

				/* Get the raw pricing data */
				$product_raw_price  = GFCommon::to_number( $product['price'] );
				$product_unit_price = $product_raw_price;

				/* Check if we should include options */
				$options = isset( $product['options'] ) ? $product['options'] : [];

				/* Process our options array */
				foreach ( $options as &$option ) {
					/* Get the options raw price */
					$option_raw_price = GFCommon::to_number( $option['price'] );

					/* Add the options price to the products price */
					$product_unit_price += $option_raw_price;

					/* add our formatted options price to the array */
					$option['price_formatted'] = GFCommon::to_money( $option_raw_price, $lead['currency'] );

					/* Format our option strings correctly */
					$option['field_label']  = ( isset( $option['field_label'] ) ) ? esc_html( $option['field_label'] ) : '';
					$option['option_name']  = ( isset( $option['option_name'] ) ) ? esc_html( $option['option_name'] ) : '';
					$option['option_label'] = ( isset( $option['option_label'] ) ) ? esc_html( $option['option_label'] ) : '';
				}

				/* calculate subtotal */
				$product_subtotal = floatval( $product['quantity'] ) * $product_unit_price;

				/* increment the total */
				$order_total += $product_subtotal;

				/* Store product in $form_array array */
				$form_array['products'][ $id ] = [
					'name'               => esc_html( $product['name'] ),
					'price'              => GFCommon::to_money( $product_raw_price, $lead['currency'] ),
					'price_unformatted'  => $product_raw_price,
					'options'            => $options,
					'quantity'           => $product['quantity'],
					'subtotal'           => $product_subtotal,
					'subtotal_formatted' => GFCommon::to_money( $product_subtotal, $lead['currency'] ),
				];
			}

			/* Increment total */
			$shipping_price = ( isset( $products['shipping']['price'] ) ) ? floatval( $products['shipping']['price'] ) : 0;
			$order_total   += $shipping_price;
			$order_subtotal = $order_total - $shipping_price;

			/* add totals to form data */
			$form_array['products_totals'] = [
				'subtotal'           => $order_subtotal,
				'subtotal_formatted' => GFCommon::to_money( $order_subtotal, $lead['currency'] ),
				'shipping'           => $shipping_price,
				'shipping_formatted' => GFCommon::to_money( $shipping_price, $lead['currency'] ),
				'shipping_name'      => ( isset( $products['shipping']['name'] ) ) ? preg_replace( '/(.+?) \((.+?)\)/', '$2', $products['shipping']['name'] ) : '',
				'total'              => $order_total,
				'total_formatted'    => GFCommon::to_money( $order_total, $lead['currency'] ),
			];

			$form_array['products_totals'] = array_map( 'esc_html', $form_array['products_totals'] );
		}

		/* Save the array into the cache */
		$this->cache( $form_array );

		/* return the cache results */

		return $this->cache();
	}
}
