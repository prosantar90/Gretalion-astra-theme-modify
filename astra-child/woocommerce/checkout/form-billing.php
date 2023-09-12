<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>
		<a href="javascript:void()" class="edit_btn_design" id="bill_edit"><?php esc_html_e('Edit','wocommerce');?>  <img class="edit_icon" src="https://gretalion.com/wp-content/uploads/2022/10/edit.svg" alt="edi"></a>
		<h3 class="checkout-title-section" id="first_icon"><span>1 </span><?php esc_html_e( 'Shipping Address', 'woocommerce' ); ?></h3>
	<?php else : ?>
		<a href="javascript:void()" class="edit_btn_design" id="bill_edit"><?php esc_html_e('Edit','wocommerce');?>  <img class="edit_icon" src="https://gretalion.com/wp-content/uploads/2022/10/edit.svg" alt="edi"></a>
		<h3><?php esc_html_e( 'Billing details', 'woocommerce' ); ?></h3>
	<?php endif; ?>

	<!-- Customer Billing info start -->
	<div class="shipping__container"></div>
		<!-- Customer Billing info start -->
	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>
	<div class="pay_btn">
		<p id="error_msg"></p>
	<span class="required-copy"><?php esc_html_e('All fields are required except if mentioned optional.','woocommerce');?></span>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );
		foreach ( $fields as $key => $field ) {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
	</div>
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>	
		<button class="btn_design" id="billing_for_payement"><?php esc_html_e('Continue To Payment','woocommerce');  ?></button>
		<?php else:?>
	<button class="btn_design" id="next_pay2"><?php esc_html_e('Continue To Payment','woocommerce') ?></button>
		<?php endif;?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>
			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>