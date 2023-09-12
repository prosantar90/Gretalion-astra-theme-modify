<?php 
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );
add_filter( 'woocommerce_checkout_fields' , 'gretanlion_checkout_billing_fields', 20, 1 );
function gretanlion_checkout_billing_fields( $billing_fields ){
	 	// Remove Action
		 unset($billing_fields['billing']['billing_company']);
		 unset($billing_fields['billing']['billing_email']);
		 unset($billing_fields['billing']['billing_state']);
   		 unset($billing_fields['billing']['billing_address_2']);

		// unset($fields['order']['order_comments']);
       // Change placeholder
        $billing_fields['billing']['title']= array(
        'label'     => __('Title', 'woocommerce'),
        'required'  => true,
        'class'     => array('col-10'),
        'input_class'=>array('select2-search__field'),
        'type'		=>'select',
        'options' => array('mr' => __('Mr', 'woocommerce'), 'mrs' => __('Mrs', 'woocommerce'), 'miss' => __('Miss', 'woocommerce')),
        // 'clear'     => true
      );
        
		$billing_fields['billing']['billing_first_name']= array(
			'label'     => __('First Name', 'woocommerce'),
			'required'  => true,
			'class'     => array('col-40'),
			'clear'     => true
			);

			$billing_fields['billing']['billing_last_name']= array(
				'label'     => __('Sure Name', 'woocommerce'),
				'required'  => true,
				'class'     => array('col-40'),
				'clear'     => true
			);
       $billing_fields['billing']['billing_address_1']= array(
        'label'     => __('Address', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-wide'),
        'clear'     => true
		);
        $billing_fields['billing_country']['class'] = array('my-field-class form-row-first');
         
        $billing_fields['billing']['billing_city']= array(
        'label'     => __('City', 'woocommerce'),
        'required'  => true,
        'class'     => array('col-40'),
        'clear'     => true
        );
        
      $billing_fields['billing']['billing_postcode']= array(
      'label'     => __('Postcode', 'woocommerce'),
      'required'  => true,
      'clear'     => true
      );
      $billing_fields['billing']['billing_phone']= array(
        'label'     => __('Mobile', 'woocommerce'),
        'class'     => array('form-row-wide'),
        'required'  => true,
        'clear'     => true
        );
	      $billing_fields['billing']['instagram_name']= array(
		  'label'     => __('Instagram account name', 'woocommerce'),
		  'required'  => true,
		  'clear'     => true
		  );
        $billing_fields['billing']['add_number_checkbox']= array(
        'label'     => __('Add additional contact number.', 'woocommerce'),
        'type'      =>'checkbox',
        'class'     =>array('form-row-wide'),
        'required'  => false,
        'clear'     => true
        );
        $billing_fields['billing']['additional_phone']= array(
          'label'     => __('ALTERNATIVE MOBILE', 'woocommerce'),
          'type'      =>'text',
          'class'     =>array('form-row-wide'),
          'required'  => false,
          'clear'     => true
          );


// Check if there are both physical and downloadable products in the cart
    $has_physical_products = false;
    $has_downloadable_products = false;
    foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
        if ( $cart_item['data']->is_downloadable() ) {
            $has_downloadable_products = true;
        } else {
            $has_physical_products = true;
        }
    }
		$billing_fields['billing']['title']['priority'] = 1;
		$billing_fields['billing']['billing_first_name']['priority'] = 2;
		$billing_fields['billing']['billing_last_name']['priority'] = 3;
    	$billing_fields['billing']['billing_address_1']['priority'] = 4;
		$billing_fields['billing']['billing_country']['priority'] = 6;
		$billing_fields['billing']['billing_city']['priority'] = 7;
		$billing_fields['billing']['billing_postcode']['priority'] = 8;
		$billing_fields['billing']['billing_phone']['priority'] = 9;
		$billing_fields['billing']['instagram_name']['priority'] = 10;
	     if ( ! WC()->cart->needs_shipping() && WC()->cart->show_shipping() ){
   		 unset($billing_fields['billing']['billing_address_1']);
   		 unset($billing_fields['billing']['billing_city']);
   		 unset($billing_fields['billing']['billing_postcode']);
	    $billing_fields['billing']['instagram_name']['priority'] = 9;
		$billing_fields['billing']['billing_phone']['priority'] = 10;
         }else{
            if ( $has_physical_products && $has_downloadable_products ) {
                $billing_fields['billing']['instagram_name']['priority'] = 9;
                $billing_fields['billing']['billing_phone']['priority'] = 10;
            }else{
                unset($billing_fields['billing']['instagram_name']);
            }		
		 }
   
   return $billing_fields;
}

add_action('woocommerce_checkout_process', 'gretanlion_custom_checkout_field_process');
function gretanlion_custom_checkout_field_process() {
    // Check if set, if its not set add an error.
    if ( ! $_POST['title'] )
        wc_add_notice( __( 'Please Select Name title.' ), 'error' );
}
/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
function my_custom_checkout_field_update_order_meta( $order_id ) {
   if ( ! empty( $_POST['title'] ) ) {
        update_post_meta( $order_id, 'Title', sanitize_text_field( $_POST['title'] ) );
    }

    if ( ! empty( $_POST['additional_phone'] ) ) {
      update_post_meta( $order_id, 'Alternative Number', sanitize_text_field( $_POST['additional_phone'] ) );
  }
      if ( ! empty( $_POST['instagram_name'] ) ) {
      update_post_meta( $order_id, 'Instagram account name', sanitize_text_field( $_POST['instagram_name'] ) );
  }
}

/**
 * Update the user meta with field value
 **/
add_action('woocommerce_checkout_update_user_meta', 'my_custom_checkout_field_update_user_meta');

function my_custom_checkout_field_update_user_meta( $user_id ) {
	if ($user_id && $_POST['title']) update_user_meta( $user_id, 'title', esc_attr($_POST['title']) );
	if ($user_id && $_POST['instagram_name']) update_user_meta( $user_id, 'instagram_name', esc_attr($_POST['instagram_name']) );
}
/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Title').':</strong> ' . get_post_meta( $order->id, 'Title', true ) . '</p>';
    echo '<p><strong>'.__('Alternative Number').':</strong> <a href="tel:' . get_post_meta( $order->id, 'Alternative Number', true ) . '"> '.get_post_meta( $order->id, 'Alternative Number', true ).'</a></p>';
    echo '<p><strong>'.__('Instagram account name').':</strong> ' . get_post_meta( $order->id, 'Instagram account name', true ) . '</p>';
}

// Checkout input field condition
add_action('wp_footer','checkout_field_js');
function checkout_field_js()
{
  if ( is_checkout()== true) {
    ?>
  <script type="text/javascript">
  var $=jQuery;
    $(function(){
       $("#billing_for_payement, #2nd_step, #next_pay2").on('click', function(e){
        e.preventDefault();
    //    console.log('I am clicked');
        var titleNeme = $('#title').val().toUpperCase();
        var fName = $('#billing_first_name').val();
        var lName = $('#billing_last_name').val();
        var cAdrress = $('#billing_address_1').val();
        var cCity = $('#billing_city').val();
        var cPostCode = $('#billing_postcode').val();
        var cPhone = $('#billing_phone').val();        
       if ($('#title').val().trim() == '') {
             $('#title').css("border-color","red");
             $("#error_msg").html('<?php esc_html_e('Title required', 'wocommerce')?>');
            // $('html, body').animate({scrollTop: $("#error_msg").offset().top}, 100);
        }
        else if ($('#billing_first_name').val().trim() == '') {
            $('#billing_first_name').css('border-color','red');
            $("#error_msg").text('<?php esc_html_e('First name required', 'wocommerce')?>');
             $('html, body').animate({scrollTop: $("#error_msg").offset().top}, 100);
        }
       else if ($('#billing_last_name').val().trim() == '') {
            $('#billing_last_name').css('border-color','red');
            $("#error_msg").text('<?php esc_html_e('Last name required', 'wocommerce')?>');
            //$('html, body').animate({scrollTop: $("#error_msg").offset().top}, 100);
        }
        else if ($('#billing_city').val().trim() == '') {
            $("#billing_city").css('border-color','red');
            $("#error_msg").text('<?php esc_html_e('City required','wocommerce') ?>');
            //$('html, body').animate({scrollTop: $("#error_msg").offset().top}, 100);
        }

        else if ($('#billing_address_1').val().trim() == '') {
            $("#billing_address_1").css('border-color','red');
            $("#error_msg").text('<?php esc_html_e('Address required','wocommerce') ?>');
//             $('html, body').animate({scrollTop: $("#error_msg").offset().top}, 100);
        }
        else if ($('#billing_postcode').val().trim() == '') {
            $('#billing_postcode').css('border-color','red');
            $("#error_msg").text('<?php esc_html_e('Postcode required','wocommerce') ?>');
//             $('html, body').animate({scrollTop: $("#error_msg").offset().top}, 100);

        }
        else if ($('#billing_phone').val().trim() == '') {
            $('#billing_phone').css('border-color','red');
            $("#error_msg").text('<?php esc_html_e('Phone required', 'wocommerce') ?>');
//             $('html, body').animate({scrollTop: $("#error_msg").offset().top}, 100);
        } else{
            $(".pay_btn").slideUp();
            $(".shi_container").slideDown();
            $("#bill_edit").show();
            $("#first_icon span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
            $('.shipp_wapper .checkout-title-section').css('color', '#000');
            $('.shipping__container').show();
            $('.shipping__container').html(
                `
                <div class="shipping-item-order-info">
                    <p class="shipping-name">${titleNeme}.  ${fName} ${lName}</p>
                    <p class="shipping-address">${cAdrress} </p>
                    <p class="shipping-address">${cCity} ${cPostCode}</p>
                    <p class="shipping-address">${cPhone} </p>
                </div>
                `
            );
        }
    });
    })
  </script>
  <?php
  }
}
function wpchris_unselect_payment_method() {
    echo "<script>jQuery( '.payment_methods input.input-radio' ).removeProp('checked');</script>";
}
add_action('woocommerce_review_order_before_submit','wpchris_unselect_payment_method' );

// function wpchris_filter_gateways( $gateways ){
//     global $woocommerce;
//  $has_downloadable_products = false;
//     foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
//         if ( $cart_item['data']->is_downloadable() ) {
//             $has_downloadable_products = true;
//             break;
//         }
//     }
//     foreach ($gateways as $gateway) {
//         $gateway->chosen = 0;
//     }
//     return $gateways;
// }
// add_filter( 'woocommerce_available_payment_gateways', 'wpchris_filter_gateways', 1);
add_filter( 'woocommerce_available_payment_gateways', 'disable_cod_for_downloadable_products' );

function disable_cod_for_downloadable_products( $available_gateways ) {
    if ( ! function_exists( 'WC' ) ) {
        return $available_gateways;
    }
    // Check if there are downloadable products in the cart
    $has_downloadable_products = false;
    if ( WC()->cart ) {
        foreach ( WC()->cart->get_cart_contents() as $cart_item ) {
            if ( $cart_item['data']->is_downloadable() ) {
                $has_downloadable_products = true;
                break;
            }
        }
    }
    // If there are downloadable products, remove COD from the available gateways
    if ( $has_downloadable_products ) {
        unset( $available_gateways['cod'] );
    }
foreach ($available_gateways as $gateway) {
        $gateway->chosen = 0;
    }
    return $available_gateways;
}