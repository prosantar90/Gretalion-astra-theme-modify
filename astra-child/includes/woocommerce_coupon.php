<?php 
// Custom Coupon Functions
add_shortcode('coupon_code','coupon_code_file');
function coupon_code_file(){
global $woocommerce;
global $product;
$coupon_pid = array('106','2881', '6249','6202','6250','6251');
$pId= $product->get_id();	
$coupon_applied =WC()->cart->get_applied_coupons();
    foreach ($coupon_applied as $coupon) {
        $coupon = new WC_Coupon( $coupon );
        $t= $coupon->get_product_ids();
            if(in_array($pId, $t)){
            echo '<div class="text-center">';
            esc_html_e('Discount applied: ','wocommerce');
            wc_cart_totals_coupon_html( $coupon );
            echo '</div>';
            $coupon_code = $coupon->get_code();
    }
    }
    if (WC()->cart->has_discount($coupon_code) && $coupon_code !='') {
        return;
    }else{ 
        if (in_array($pId, $coupon_pid)) {
          ?>
        <p class="result"><?php if(isset($message)){echo $message; } ?> </p>
        <div class="toogle_coupon">
            <?php esc_html_e('Have a coupon code?','wocommerce');?> <a href="javascript:void(0)"
                class="showcoupon"><?php esc_html_e('Click here to enter','wocommerce');?></a>
        </div>
        <form id="coupon-redeem" style="display:none;" method="post">
            <p class="coupon_container">
                <input type="hidden" value="<?= $pId?>" id="product_id" name="add-to_cart">
                <input type="text" name="coupon_code" class="input-text"
                    placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
                <?php if ( ! WC()->cart->is_empty() ) {?>
                <button type="submit" id="apply_coupon_pro" class="button" name="apply_coupon_pro"
                    value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
                <?php }else{?>
                <button  type="submit" id="apply_coupon_pro" class="button" name="apply_coupon_pro"
                    value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
                <?php }?>
            </p>
            <div class="clear"></div>
        </form>
    <?php
    }
    }
}
function filter_woocommerce_remove_text( $coupon_html, $coupon, $discount_amount_html ) {
    if ('percent' === $coupon->get_discount_type()) {
        echo $coupon->get_amount().'% ';
    }else{
        echo $coupon->get_amount().' € ';
    }
    $coupon_html= '('.$discount_amount_html.')';
    return $coupon_html;
}
add_filter( 'woocommerce_cart_totals_coupon_html', 'filter_woocommerce_remove_text', 10, 3 );


// Coupon Ajax File 
add_action('wp_footer',function(){
	?>
	<script>
		var $= jQuery;
		$(function(){
			$(document).on('click','#apply_coupon_pro', function(e){
				e.preventDefault()
				// $('#open_cart').trigger('click');
				var coupon= $("#coupon_code").val();
                var product_id = $('#product_id').val();
				var data = {
					'action': 'example_ajax_request',
					'coupon_code':coupon,
                    'product_id':product_id,
				}
				$.ajax({
					type:"GET",
					url:'<?php echo admin_url( 'admin-ajax.php' );?>',
					data:data,
					success:function(r){
                        console.log(r);
						if(r=== 'ok'){
								window.open("<?php echo wc_get_cart_url(); ?>",'_self');
							  $('#elementor-menu-cart__toggle_button').trigger('click');

						}else{
							console.log(r);
							// $(".result").text(r);
							// $('#coupon-redeem').hide();
						}
					}
				})
			});
		});
	</script>
<?php 
});

function example_ajax_request() {
    // The $_REQUEST contains all the data sent via ajax
    if ( isset( $_REQUEST ) ) {       
		$coupon = esc_attr( $_REQUEST['coupon_code'] );
        $product_id = $_REQUEST['product_id'];
        $insert_id =WC()->cart->add_to_cart($product_id, '1');
        if ($insert_id) {
            $applied_coupons = WC()->cart->get_applied_coupons();
            if ( ! in_array( $coupon, $applied_coupons ) ) {
                $applied = WC()->cart->apply_coupon($coupon);
                if ( $applied ) {
                        echo 'ok';
                } else {
                    $message = sprintf( __('Please add the product to the cart first before applying the coupon or you entered the code incorrectly.'), $coupon);
                }
            } else {
                $message = sprintf( __('You have already applied "%s" and can therefore not apply it again.'), $coupon);
            }
            wc_clear_notices();
        }
      
    }
	echo $message;
	die();
}
add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );
add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');