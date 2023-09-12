<?php 
add_action('payement_method','my_custom_display_payments');

/**
 * Displaying the Payment Gateways 
 */
function my_custom_display_payments() {
  if ( WC()->cart->needs_payment() ) {
    $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
    WC()->payment_gateways()->set_current_gateway( $available_gateways );
  } else {
    $available_gateways = array();
  }
  ?>
  <div id="checkout_payments">
	<a href="javascript:void()" class="edit_btn_design" id="pay_edit"><?php esc_html_e('Edit','wocommerce')?> <img class="edit_icon" src="https://gretalion.com/wp-content/uploads/2022/10/edit.svg" alt="edit"></a>
  <h3 class="checkout-title-section" id="3rd_step"><span>4</span><?php esc_html_e( 'Payment', 'woocommerce' ); ?></h3>
    <?php if ( WC()->cart->needs_payment() ) : ?>
      <div class="pay_method">
        <ul class="wc_payment_methods payment_methods methods">
        <?php
        if ( ! empty( $available_gateways ) ) {
          foreach ( $available_gateways as $gateway ) {
            wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
          }
        } else {
          echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
        }
        ?>
				<p id="change_option"><?php esc_html_e('Change','wocommerce');?></p>
        </ul>
        <div class="pay_desc"> <!-- Pay Des Start-->
			<p id="change_gate"><?php esc_html_e('Change','wocommerce');?></p>
        <?php if (! empty( $available_gateways)) {
           foreach ( $available_gateways as $gateway ) {
             ?>
              <?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
              <div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?> style="display:none;" <?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
                <?php $gateway->payment_fields(); ?>
              </div>
            <?php endif; ?>
             <?php
          }
        }?>
          </div><!-- ./ pay des-->
          <button class="btn_design" id="scroltoT"><?php esc_html_e( 'Confirm Details', 'woocommerce' ); ?></button>
    </div>
  <?php endif; ?>
  </div>
<?php
}
function my_custom_payment_fragment( $fragments ) {
	ob_start();
	my_custom_display_payments();
	$html = ob_get_clean();
	$fragments['#checkout_payments'] = $html;
	return $fragments;
}