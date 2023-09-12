<?php 
add_action('after_setup_theme', 'custom_autologin');
function custom_autologin($user){
  if (isset($_POST['login'])) {
    $userName = sanitize_text_field($_POST['username']);
    $the_user = get_user_by('email', $userName);
    if ($the_user) {
      $the_user_id = $the_user->ID; 
      $user = get_userdata($the_user_id);
      $user_roles = $user->roles;
      if ( in_array( 'customer', $user_roles, true ) ) {
        if (!is_user_logged_in()) {
            $user = wp_get_current_user();
            wp_set_current_user($the_user_id, $UserLogin);
            wp_set_auth_cookie($the_user_id);
            do_action('wp_login', $the_user->user_login, $user);
           if(ICL_LANGUAGE_CODE == 'lt'){
              wp_redirect(site_url().'/atsiskaitymas' );   
            }else{
            wp_redirect(site_url().'/checkout');   
            }

            exit;
        } 
      }
    }else{
      ?>
      <script>
        alert('This user not exists');
      </script>
      <?php
    } 
  }

  if (isset($_REQUEST['email_exists'])) {
    $userName = sanitize_text_field($_REQUEST['email_exists']);
    $the_user = get_user_by('email', $userName);
    if ($the_user) {
      $the_user_id = $the_user->ID; 
      $user = get_userdata($the_user_id);
      $user_roles = $user->roles;
      if ( in_array( 'customer', $user_roles, true ) ) {
        if (!is_user_logged_in()) {
            $user = wp_get_current_user();
            wp_set_current_user($the_user_id, $UserLogin);
            wp_set_auth_cookie($the_user_id);
            do_action('wp_login', $the_user->user_login, $user);
           if(ICL_LANGUAGE_CODE == 'lt'){
              wp_redirect(site_url().'/atsiskaitymas' );   
            }else{
            wp_redirect(site_url().'/checkout');   
            }
            exit;
        } 
      }
    }else{
      ?>
      <script>
        alert('This user not exists');
      </script>
      <?php
    } 
  } 
}
add_filter( 'woocommerce_registration_error_email_exists', 'shipperhelp_woocommerce_registration_error_email_exists_filter', 10, 2 );
/**
 * Function for `woocommerce_registration_error_email_exists` filter-hook.
 * 
 * @param  $__    
 * @param  $email 
 *
 * @return 
 */
function shipperhelp_woocommerce_registration_error_email_exists_filter( $html, $email ){
	// filter...
  if (email_exists($email)) {
    $html= '<div class="already_exists_mail">';
    $html .='<div class="exists_info__box">';
    $html .= '<h1>'.__('Welcome back! ','woocommerce').' </h1>';
    $html .= '<p>'.__('We found that you already have an account in our store', 'woocommerce').', <b>'.$email.'</b> '.__('click login to continue.', 'woocommerce').'</p>';
    $html .='</div>';
    $html .='<a class="exists_login__btn" href="'.esc_url( home_url( '/' ) ).'?email_exists='.$email.'"><b>'.__('Login','woocommerce').'</b></a>';
    $html .='</div>';
    ?>
    <style>
      .woocommerce-form.woocommerce-form-register.register {
        display: none;
      }
      .exist_title{
        display: none;
      }
 .jet-wishlist-count-button__link {
    padding: 9px 0px 0px 7px !important;
}
.fa-search::before {
    content: "\f002";
    bottom: 0;
    margin-bottom: 21px !important;
}
    </style>
    <?php
  }
  return $html;
}