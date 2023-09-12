<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <div class="cart-container">

        <?php do_action( 'woocommerce_before_cart_table' ); ?>
        <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <?php do_action( 'woocommerce_before_cart_contents' ); ?>
            <?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
            <div
                class="cart-wrapper woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                <div class="product-thumbnail">
                    <?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							if ( ! $product_permalink ) {
								echo $thumbnail; // PHPCS: XSS ok.
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
							}
							?>
                </div>
                <div class="product-title">
                    <?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
                    <!-- Product Subtotal for mobile -->
                    <div class="for-mobile__device">
                        <div class="product-subtotal__for-mobile">
                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.?>
                        </div>
                        <!-- Product Quantity for mobile -->
                        <div class="product_quantity__for_mobile quantity">
                            <?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
                        </div>
                    </div>

                    <div class="footer-item">
                        <div class="baglist-item-availability">
                            <div class="shipping-info">
								<?php
									$productId = $cart_item['product_id'];
									 $sproduct = wc_get_product( $productId );
								if ( $sproduct->is_virtual() || $sproduct->is_downloadable() ) {?>
								 <p class="subtitle"><?php esc_html_e('You will get access to your Instagram account','woocommerce');?></p>
								<?php 
								}else{?>
                                <p class="title"><?php esc_html_e('AVAILABLE','woocommerce');?></p>
       							<div class="subtitle">
								<?php esc_html_e('Estimated shipping within 1-2 business days.', 'woocommerce');?>
								 </div>
							<?php }
									?>
                                

                            </div>
                        </div>
                    </div>
                    <div class="footer-section">
                        <!-- Product remove -->
                        <?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() ),
											esc_html__( 'Remove', 'woocommerce' ),
											
										),
										$cart_item_key
									);

							$applied_coupons = WC()->cart->get_applied_coupons();
							foreach($applied_coupons as $coupon){
								$coupon = new WC_Coupon($coupon);
								 $coupon->get_code();
								$pid= $coupon->get_product_ids();
								 if (in_array($cart_item ['product_id'],$pid)) {
									 ?>
									<style>
									.footer-section a {
										margin: 0;
										padding-right: 5px;
									}
									</style><?php
											echo '<span class="dicount_price">';
											esc_html_e('Discount applied: ', 'wocommerce');
											wc_cart_totals_coupon_html( $coupon );
											echo '</span>'; 
											}
										}
												
										?>
                    			</div>

                </div>
                <div class="cart-right quantity">
                    <?php
							if (wp_is_mobile()) {
								echo 'This is mobile ';
							}else{
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
							}
							?>
                </div>
                <div class="product-subtotal">
					<?php  ?>
                    <?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
                </div>
            </diV>
            <?php }}?>
            <?php do_action( 'woocommerce_cart_contents' ); ?>
            <div>
                <div colspan="6" class="actions">
				<?php if ( wc_coupons_enabled() ) { ?>
						<div class="cart_coupon_wapper toogle_coupon">
							<?php esc_html_e('Have a coupon code?','wocommerce');?> <a href="javascript:void(0)"
								class="showcoupon"><?php esc_html_e('Click here to enter','wocommerce');?></a>
						</div>
						<div id="coupon-redeem" class="coupon" style="display:none;">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="coupon_custom_btn button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>
                    <button type="submit" id="update_cart" class="button" name="update_cart"
                        value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                    <?php do_action( 'woocommerce_cart_actions' ); ?>
                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </div>
            </div>
        </div>
        <?php do_action( 'woocommerce_after_cart_table' ); ?>
    </div>
</form>
<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-summery-container">
    <?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>