<?php if ( ! empty( $settings->cart_align ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__option-variants--inline,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__quantity {
	<?php
	switch ( $settings->cart_align ) {
		case 'right':
			$value = 'flex-end';
			break;
		case 'center':
			$value = 'center';
			break;
		case 'left':
		default:
			$value = 'flex-start';
			break;
	}

	printf( 'justify-content: %s;', $value );
	?>
}
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__option-label {
	<?php
	printf( 'text-align: %s;', $settings->cart_align );
	?>
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__quantity-label {
	<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_form_typography );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			printf( '%s: %s;', $key, $value );
		}
	}
	?>
}

<?php if ( ! empty( $settings->bc_form_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-form__quantity-label {
	color: <?php printf( '#%s', $settings->bc_form_text_color ); ?>;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn {
	<?php
	$props = FLBuilderCSS::border_field_props( $settings->bc_button_border );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			printf( '%s: %s;', $key, $value );
		}
	}
	?>
}

<?php if ( ! empty( $settings->bc_button_background_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart  {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_button_background_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->bc_button_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_button_text_color ); ?>;
}
<?php endif; ?>

.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_button_typography );
foreach ( $props as $key => $value ) {
	printf( '%s: %s;', $key, $value );
}
?>
}
