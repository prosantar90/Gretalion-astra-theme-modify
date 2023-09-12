<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.2' );
/**
 * Enqueue styles
 */
function child_enqueue_styles() {
  wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
  wp_enqueue_script(
    'saved-script',
    get_stylesheet_directory_uri() . '/assets/js/save_woo_data.js',
    array( 'jquery' ),
    '',
    true
  );
wp_enqueue_script(
  'custom-script',
  get_stylesheet_directory_uri() . '/assets/js/custom.js',
  array( 'jquery' ),
  '',
  true
);
wp_deregister_script('wc-checkout');
wp_enqueue_script('wc-checkout', get_stylesheet_directory_uri() . '/woocommerce/js/checkout.js', array('jquery', 'woocommerce', 'wc-country-select', 'wc-address-i18n'), null, true);
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
require_once 'includes/checkout-form.php';
require_once 'includes/custom-payment-gateway.php';

// Cart page redirect
add_action('template_redirect','check_if_logged_in');
function check_if_logged_in(){
	if(! is_user_logged_in() && is_checkout()){
		wp_redirect(site_url().'/my-account-registration/');
		exit();
	}
	     
}
// Template redirect
add_action('template_redirect','check_if_logged_in_lt');
function check_if_logged_in_lt()
{
    $pageid = 2756; // your checkout page id
    if(!is_user_logged_in() && is_page($pageid))
    {
        $url = add_query_arg(
            'redirect_to',
            get_permalink($pagid),
            site_url('/mano-paskyros-registracija/') // your my acount url
        );
        wp_redirect($url);
        exit;
    }
}

// Register Page Redirect
function gretalion_register_redirect( $redirect ) {
	return wc_get_page_permalink( 'checkout' );
	die();
}
add_filter( 'woocommerce_registration_redirect', 'gretalion_register_redirect' );
// Login Page Redirect
function gretalion_login_redirect( $redirect ) {
	return wc_get_page_permalink( 'checkout' );
	die();
}
add_filter( 'woocommerce_login_redirect', 'gretalion_login_redirect' );
// My Order Reivew fragments
add_filter( 'woocommerce_update_order_review_fragments', 'my_custom_shipping_table_update');

function my_custom_shipping_table_update( $fragments ) {
    ob_start();
    ?>
    <table class="my-custom-shipping-table">
        <tbody>
        <?php wc_cart_totals_shipping_html(); ?>
        </tbody>
    </table>
    <?php
    $woocommerce_shipping_methods = ob_get_clean();
    $fragments['.my-custom-shipping-table'] = $woocommerce_shipping_methods;
    return $fragments;
}
// Show Thumbnails
add_filter( 'woocommerce_cart_item_name', 'gretalion_product_image_review_order_checkout', 9999, 3 );
function gretalion_product_image_review_order_checkout( $name, $cart_item, $cart_item_key ) {
    if ( ! is_checkout() ) return $name;
    $product = $cart_item['data'];
    $thumbnail = $product->get_image( array( '50', '50' ), array( 'class' => 'alignleft' ) );
    return $thumbnail . '<strong>'.$name.'</strong>';
}
// Show Items
add_action('show_items', function(){
  global $woocommerce; 
  echo $woocommerce->cart->cart_contents_count;
});
add_action('total_amount', 'GetOrderTotal');
function GetOrderTotal($order_id) {
global $woocommerce;
echo "€ " . $woocommerce->cart->total;
}
// For header Section
add_action('wp_head', function(){
  if ( is_checkout()== true ) {
    ?>
    <style>
    #top{background:#000}.method-Toggle{display:none}.woocommerce-error{margin:0}.e-wc-error-notice .woocommerce-error{border:1px solid #b81c23;padding:15px;background:#fff!important;border-radius:5px;font-size:13px;font-weight:300}.e-wc-error-notice .woocommerce-error strong{font-size:13px;font-weight:500;display:inline-block!important}
</style>
    <?php
  }
    if (is_cart() == true) {
    ?>
    <style>
      .woocommerce ul#shipping_method {
        display: none;
      }
    </style>
    <?php
    }
    if (is_account_page() == true) {
      ?>
      <style>
        #top{background:#000;}
      </style>
      <?php
    }
    if ( is_front_page() && is_home() && is_product() == true) {
      ?>
      <style>
        #ppc-button-minicart{
          display: none;
        }
      </style>
      <?php
    }
});
add_filter(  'gettext',  'register_text'  );
add_filter(  'ngettext',  'register_text'  );
function register_text( $translated ) {
     $translated = str_ireplace(  'Register',  'Continue',  $translated );
     return $translated;
}
// Reset shipping method
function reset_default_shipping_method( $method, $available_methods ) {
  $default_method = ''; //provide here the service name which will selected default
  if( array_key_exists($method, $available_methods ) )
    return $default_method;
  else
    return $method;
}
add_filter('woocommerce_shipping_chosen_method', 'reset_default_shipping_method', 10, 2);
// Disable Cart message
add_filter( 'wc_add_to_cart_message_html', '__return_false' );
// Cart ajax qty
add_action( 'wp_footer', function() {
	?><script>
	jQuery( function( $ ) {
    $('form.woocommerce-checkout').on( 'change', 'select.qty', function(){
            // Set the select value in a variable
            var a = $(this).val();
            $('body').trigger('update_checkout');
            $('select#qty option[value='+a+']').prop('selected', true);
            // console.log('trigger "update_checkout"');
            // Once checkout has been updated
            $('body').on('updated_checkout', function(){
                $('select#qty option[value='+a+']').prop('selected', true);
                // console.log('"updated_checkout" event, restore selected option value: '+a);
                location.reload(true);
            });
        });
  $('form.cart').on( 'click', 'button.plus, button.minus', function(e) {
            e.preventDefault();
            // Get current quantity values
            var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
            var val   = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));
            // Change the value if plus or minus
            if ( $( this ).is( '.plus' ) ) {
               if ( max && ( max <= val ) ) {
                  qty.val( max );
               } else {
                  qty.val( val + step );
               }
            } else {
               if ( min && ( min >= val ) ) {
                  qty.val( min );
               } else if ( val > 1 ) {
                  qty.val( val - step );
               }
            } 
         }); 
	} );
  
	$("#billing_country").on('change', function(){
		let get_country = $(this).val();
    

		if(get_country == "LT" || get_country=="EE"){
			$('.wc_payment_method.payment_method_paysera').show();
		}else{
			$('.wc_payment_method.payment_method_paysera').hide();
		}
	});

  function myFunction(){
   const get= document.querySelector("#update_cart");
   if(get){
    get.click();
   }
  }
		  
$(document).on('click','#shipping_method_0_local_pickup8', function(){
	$('.ship_desc').slideDown();
});
$(document).on('click','#shipping_method_0_omnivalt_pt,#shipping_method_0_omnivalt_c',function(){
	$('.ship_desc').slideUp();
})
	</script><?php
} );
remove_filter( 'woocommerce_login_credentials', 'filter_woocommerce_login_credentials', 10, 1 );

include 'includes/woocommerce_autologin.php';

add_filter( 'woocommerce_terms_is_checked_default', '__return_true' );

// Checkout page
add_filter( 'woocommerce_checkout_cart_item_quantity', '__return_empty_string' );
// ----------------------------
// Add Quantity Inputs
   
add_filter( 'woocommerce_cart_item_subtotal', 'gretalion_checkout_item_quantity_input', 9999, 3 );
 
function gretalion_checkout_item_quantity_input( $product_quantity, $cart_item, $cart_item_key ) {
     if ( is_checkout() ) {
      $product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
      $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );   
      $product_quantity = woocommerce_quantity_input( array(
         'input_name'  => 'shipping_method_qty_' . $product_id,
         'input_value' => $cart_item['quantity'],
         'max_value'   => $product->get_max_purchase_quantity(),
         'min_value'   => '0',
      ), $product, false );
      $product_quantity .= '<input type="hidden" name="product_key_' . $product_id . '" value="' . $cart_item_key . '">';
   }
   return $product_quantity;
}
 
// ----------------------------
// Detect Quantity Change and Recalculate Totals
 
add_action( 'woocommerce_checkout_update_order_review', 'gretalion_update_item_quantity_checkout' );
function gretalion_update_item_quantity_checkout( $post_data ) {
   parse_str( $post_data, $post_data_array );
   $updated_qty = false;
   foreach ( $post_data_array as $key => $value ) {   
      if ( substr( $key, 0, 20 ) === 'shipping_method_qty_' ) {         
         $id = substr( $key, 20 );   
         WC()->cart->set_quantity( $post_data_array['product_key_' . $id], $post_data_array[$key], false );
         $updated_qty = true;
      }      
   }   
   if ( $updated_qty ) WC()->cart->calculate_totals();
}

//add_action("woocommerce_order_status_changed", "my_awesome_publication_notification");
function my_awesome_publication_notification($order_id, $checkout=null) {
   global $woocommerce;
   $order = new WC_Order( $order_id );
  $shipping_method = @array_shift( $order->get_shipping_methods() );
  $shipping_method_id = $shipping_method['method_id'];

   if($order->status === 'completed' ) {
      // Create a mailer
      if ( 'local_pickup' == $shipping_method_id ) {
            $mailer = $woocommerce->mailer();
		  	remove_action( 'woocommerce_email_header', 'email_header');
            $header = sprintf( __( 'Užsakymo %s atsiėmimas' ), $order->get_order_number() );
            $message_body = __( 'Labas 💚<br><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Ačiū, kad perkate Greta Lion! 
Prekę/es pasirinkote atsiimti vietoje. Norime informuoti, jog Jūsų  užsakymas jau yra paruoštas ir jį galėsite atsiimti iš anksto sutartu laiku. 
Adresas: Polocko 17, Vilnius.
Kontaktinis telefonas +37067429657<br><br>
Iki greito 🙂','wocommerce' );
            //$message = $mailer->wrap_message($header,$message_body );
      // Cliente email, email subject and message.
        $mailer->send( $order->billing_email, $header,$message_body );
        }
     }
   }
// Custom code for coupon code using shortcode
include 'includes/woocommerce_coupon.php';

// Showing country name in order page
add_filter( 'woocommerce_formatted_address_force_country_display', '__return_true' );
add_action( 'wp_footer', function() {
    if ( WC()->cart->is_empty() ) {
        echo '<style type="text/css">.cart-header, .cart_page-logo, .cart-section, .hide-right-content{ display: none; }</style>';
    }else{
        echo '<style type="text/css">.empty-cart{ display: none; }</style>';
    }
});