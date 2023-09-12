<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
do_action( 'woocommerce_before_checkout_form', $checkout );
// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
$label = '_checkout';
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" target="_blank"
    action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <?php if ( $checkout->get_checkout_fields() ) : ?>
    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
    <div class="col2-set" id="customer_details">
        <div class="col-1">
            <div class="logged-in-info validator-form" data-email-address-data="">
                <h1 class="h1">
                    <span class="welcome-msg"><?php esc_html_e('you are checking out as:','woocommerce');?></span>
                    <span class="email"><?php 
					global $current_user;
						wp_get_current_user();
						echo $current_user->user_email;?> </span>
                    <span>
                    </span>
                </h1>
            </div>
            <?php //if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <!-- <button type="button" id="gfit_card_btn" data-toggle="modal"
                data-target=".giftwrapper_products_modal_checkout"
                class="wcgwp-modal-toggle wcgwp-modal-toggle_after_checkout btn fusion-button fusion-button-default edgtf-btn"
                data-label="_checkout"><?php //esc_html_e('Add a gift bag & a message','woocommerce');?></button> -->
            <?php //endif; ?>
            <?php do_action( 'woocommerce_checkout_billing' ); ?>
        </div>
        <div class="col-2">
            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
        </div>
        <div class="shipp_wapper">
            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <a href="javascript:void()" class="edit_btn_design"
                id="shipping_edit"><?php esc_html_e('Edit','wocommerce')?> <img class="edit_icon"
                    src="https://gretalion.com/wp-content/uploads/2022/10/edit.svg" alt="edit"></a>
            <h3 class="checkout-title-section" id="2nd_step"><span>2
                </span><?php esc_html_e( 'Shipping Options ', 'woocommerce' ); ?></h3>
            <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
            <div class="shi_container">
                <table class="my-custom-shipping-table">
                    <!-- Our table -->
                    <tbody>
                        <?php wc_cart_totals_shipping_html(); ?>
                    </tbody>
                </table>
                <div class="pay_desc">
                    <p class="ship_desc">
                        <?php esc_html_e('Pick up your order at Polocko st. 17, Vilnius. After you complete the order, You will get pick up instructions by email. It is essential to contact us before arrival.','wocommerce');?>
                    </p>
                </div>
                <button class="btn_design"
                    id="next_pay"><?php esc_html_e('Continue To Payment','woocommerce') ?></button>
                <span class="add-gift-message"><?php esc_html_e('Or add a gift message','wocommerce');?></span>
            </div>
            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
            <?php endif; ?>
        </div>
    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
        <div class="gift-container">
            <a href="javascript:void()" class="edit_btn_design"
                id="gift_edit"><?php esc_html_e('Edit','wocommerce')?> <img class="edit_icon"
                    src="https://gretalion.com/wp-content/uploads/2022/10/edit.svg" alt="edit"></a>
            <h3 id="third_step" class="checkout-title-section"><span>3</span><?php esc_html_e('Gifting', 'wocommerce');?></h3>
            <div class="gift-wrapper">
            <div class="gift-message-box">
                <label class="gift-subtitle" for="wcgwp-note-<?= $label;?>"><?php esc_html_e('Gift Message','wocommerce');?></label>
                <div class="editable-message-box">
                   <textarea name="wcgwp_note" id="wcgwp-note" class="wcgwp-note editable-message" placeholder="<?php esc_html_e('Write your personal message', 'wocommerce');?>"></textarea>
                   <div class="logo-place">
                    <img src="https://gretalion.com/storage/2022/03/Logo-lion-white-600x548.png" alt="Gretalion">
                   </div>
                    <div class="character-counter">
                        <span class="inquery-counter">200</span>
                        <?php esc_html_e('character left','wocommerce');?>
                    </div>
                </div><!--  End editable-message-box-->
            </div> <!--End Message box -->
        <div class="gift-product-container">
            <span class="gift-subtitle text-center"><?php esc_html_e('We offer these gift wrapping options:', 'wocommerce');?></span>
            <ul class="wcgwp-ul giftwrap_ul">
                <?php 
                    $products = wcgwp_get_products();
                    $product_count      = count( $products );
                    $i                  = 0;
					$image_output_open  = '';
					$image_output_close = '';
					$product_image      = '';
					$show_link          = get_option( 'wcgwp_link' );
					$hide_price         = get_option( 'wcgwp_hide_price', 'no' );
					$sizes              = wp_get_registered_image_subsizes();
					$thumb_size         = apply_filters( 'wcgwp_change_thumbnail', 'thumbnail' );
					$width              = $sizes[$thumb_size]['width'] ?? false;
                    foreach ($products as  $product) :
                        $product_id = $product->get_id();
                        $product_title = $product->get_title();
                        $product_price = $product->get_price_html();
                        $product_image = wp_get_attachment_image( get_post_thumbnail_id( $product_id ), $thumb_size, false, array( "alt" => $product_title ) );
                        $slug = $product->get_slug();
                        echo '<li class="wcgwp-li custom-li';
							if ( $width ) {
								echo ' style="max-width:' . esc_attr( $width ) . 'px"';
							}
							echo '>';
							if ( $product_count > 1 ) {
								echo '<input type="radio" name="wcgwp_product_id[]" data-productid="' . esc_attr( $product_id ) . '" id="' . esc_attr( $slug .'-_checkout' ) . '" class="wcgwp-input" ' . ( $i == 0 ? 'checked' : '' ) . '>';
							} else {
								echo '<input type="hidden" name="wcgwp_product_id[]" data-productid="' . esc_attr( $product_id ) . '" id="' . esc_attr( $slug .'-_checkout' ) . '" class="wcgwp-input">';
							}
							echo '<label for="' . esc_attr( $slug .'-'. $label ) . '" class="wcgwp-desc' . ( $product_count < 2 ? ' singular_label' : '' ). '">';
							echo '<span class="wcgwp-title"> ' . wp_kses_post( $product_title ) . '</span>';
							if ( 'no' === $hide_price ) {
								echo wp_kses_post( $price_html );
							}
							?>
                            <div class="wcgwp-thumb">
                            <?php 
                            echo wp_kses_post( $image_output_open ) . $product_image . wp_kses_post( $image_output_close ) . '</label>';
                            ?>
                            <p class="product_price"><?php echo wp_kses_post($product_price);?></p>
                            </div><?php
							echo '</li>';
							++$i;
                ?>
                <?php endforeach;?>
                </ul>
	            <?php wp_nonce_field( 'wcgwp_ajax_wrap', 'wcgwp_nonce-' . esc_attr( $label ) ); ?>
                <div class="submit-wrapper">
                    <button type="button" id="addGift" class="wcgwp-submit btn_design" data-label="<?php esc_attr_e( $label ); ?>"><?php esc_html_e("Add Gift product","wocommerce");?></button>
                    <span class="skip-btn"><?php esc_html_e('Skip','wocommerce');?></span>
                </div>
            </div><!-- End gift-product-container-->
        </div>
        <!-- End gift-wrappper -->
    </div><!-- End .gift-container -->
    <?php endif;?>
        <?php do_action('payement_method');?>
    </div>

    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
    <?php endif; ?>
    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
    <h3 id="order_review_heading"><img src="https://gretalion.com/wp-content/uploads/2022/04/shopping-bags.svg"
            alt="cart bag"> <?php do_action('show_items');?> <?php 
		if (WC()->cart->get_cart_contents_count()== 1) {
			esc_html_e( 'Item', 'woocommerce' );
		} else {
			esc_html_e( 'Items', 'woocommerce' );
		}
	 ?></h3>
    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
    <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
    </div>
    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
    <!-- Order Details Start -->
    <div id="order_review" class="woocommerce-checkout-review-order" style="width:30%; float:right;">
        <h3 id="view_details"><?php esc_html_e('View Details','woocommerce'); ?><span><i class="fa fa-plus"
                    aria-hidden="true"></i></span></h3>
        <h3 id="view_less"><?php esc_html_e('View Less','woocommerce'); ?> <span><i class="fa fa-minus"
                    aria-hidden="true"></i></span></h3>
        <p><?php //esc_html_e('You will be charged only at the time of shipment except for DIY orders where the full amount is charged at the time of purchase','woocommerce');?>
        </p>
        <div class="stock">
            <div class="icon">
                <p><?php esc_html_e('In stock','woocommerce')?></p>
            </div>
            <div class="stock_amount">
                <p><?php do_action('total_amount');?></p>
            </div>
        </div>
    </div>
    <!-- Order Details end -->
</form>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>