<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">
	<?php do_action( 'woocommerce_before_cart_totals' ); ?>
	<div class="summery-header">
		<h2 class="order-summary-title"><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h2>
	</div>
	<div class="summery-total">
		<ul>
			<li class="summery">
				<?php esc_html_e('Subtotal', 'woocommerce')?>
				<span class="text-right"><?php echo WC()->cart->total. ' €';?></span>
			</li>		
			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<li>
				<?php wc_cart_totals_coupon_label( $coupon ); ?>
				<span class="text-right"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
				</li>
				<?php endforeach; ?>
			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
					<li>
						<?php echo esc_html( $fee->name ); ?>
						<span class="text-right"><?php wc_cart_totals_fee_html( $fee ); ?></span>
					</li>
			<?php endforeach; ?>

				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
				<?php wc_cart_totals_shipping_html(); ?>
				<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
			<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
				<li class="shipping_calculation">
					<?php esc_html_e( 'Shipping Time', 'woocommerce' ); ?>
					<span><?php printf( '<a href="#" class="shipping-calculator-button">%s</a>', esc_html( ! empty( $button_text ) ? $button_text : __( 'Select Country', 'woocommerce' ) ) ); ?></span>
					<?php woocommerce_shipping_calculator(); ?>
				</li>
				<li class="total_price">
					<?php esc_html_e('Total price including shipping price will be calculated at checkout', 'woocommerce')?>
				</li>
				<?php else:?>
					<li class="total_price">
						<?php esc_html_e('Instructions how to watch the lessions you will get with an email.', 'wocommerce'); ?>
					</li>
				<?php endif;?>
		</ul>
	
		<div class="summery-collapse">
		<h3 id="view_details"><?php esc_html_e('View Details','woocommerce'); ?><span><i class="fa fa-plus" aria-hidden="true"></i></span></h3>
		<h3 id="view_less"><?php esc_html_e('View Less','woocommerce'); ?> <span><i class="fa fa-minus" aria-hidden="true"></i></span></h3>
		<p><?php esc_html_e('If you order and pay now on the checkout page, we will send your package to your address within one working day and send you an email with shipping information. If you have any further questions, please contact us at ','woocommerce');?><a href="mailto:info@gretalion.com">info@gretalion.com</a></p>
		<div class="stock">
			<div class="icon">
				<p><?php esc_html_e('In stock','woocommerce')?></p>
			</div>
			<div class="stock_amount">
				<p><?php do_action('total_amount');?></p>
			</div>
		</div>

		</div>
	</div>
	<div class="checout-botton">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>
	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>