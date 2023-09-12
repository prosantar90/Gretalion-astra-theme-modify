var $ = jQuery;
$(function () {

    $("#add_number_checkbox").on('change', function () {
        if (this.checked) {
            jQuery('#additional_phone_field').fadeIn();
            jQuery('#additional_phone_field').attr('required', true);
            jQuesry('#additional_phone_field').prop('pattern', "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$");
        } else {
            jQuery('#additional_phone_field').fadeOut();
            jQuery('#additional_phone_field input').val('');
            jQuery('#additional_phone_field').attr('required', false);
        }
    })


    $("#billing_for_payement, #2nd_step").on('click', function (e) {
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
            $('#title').css("border-color", "red");
            $("#error_msg").text('Title required');
        }
        else if ($('#billing_first_name').val().trim() == '') {
            $('#billing_first_name').css('border-color', 'red');
            $("#error_msg").text('First name required');
        }
        else if ($('#billing_last_name').val().trim() == '') {
            $('#billing_last_name').css('border-color', 'red');
            $("#error_msg").text('Last name required');
        }
        else if ($('#billing_city').val().trim() == '') {
            $("#billing_city").css('border-color', 'red');
            $("#error_msg").text('City required');
        }

        else if ($('#billing_address_1').val().trim() == '') {
            $("#billing_address_1").css('border-color', 'red');
            $("#error_msg").text('Address required');
        }
        else if ($('#billing_postcode').val().trim() == '') {
            $('#billing_postcode').css('border-color', 'red');
            $("#error_msg").text('Postcode required');
        }
        else if ($('#billing_phone').val().trim() == '') {
            $('#billing_phone').css('border-color', 'red');
            $("#error_msg").text('Phone required');
        } else {
            $(".pay_btn").slideUp('fast');
            $(".shi_container").slideDown('slow');
            $("#bill_edit").show();
            $("#first_icon span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
            $('.shipp_wapper .checkout-title-section').css('color', '#000');
            $('.shipping__container').show();
            $('.shipping__container').html(
                `<div class="shipping-item-order-info">
                    <p class="shipping-name">${titleNeme}.  ${fName} ${lName}</p>
                    <p class="shipping-address">${cAdrress} </p>
                    <p class="shipping-address">${cCity} ${cPostCode}</p>
                    <p class="shipping-address">${cPhone} </p>
                </div>
                `);
            scrollTop: $(".shipping__container").offset() + 60
            // 			$('html, body').animate({
            //              scrollTop: $(".my-custom-shipping-table")
            //             }, 700);
        }
    });
$(document).on('click', '#next_pay2', function (e) {
        e.preventDefault();
        //    console.log('I am clicked');
        var titleNeme = $('#title').val().toUpperCase();
        var fName = $('#billing_first_name').val();
        var lName = $('#billing_last_name').val();
        var instagram = $('#instagram_name').val();
        var cPhone = $('#billing_phone').val();
        if ($('#title').val().trim() == '') {
            $('#title').css("border-color", "red");
            $("#error_msg").text('Title required');
        }
        else if ($('#billing_first_name').val().trim() == '') {
            $('#billing_first_name').css('border-color', 'red');
            $("#error_msg").text('First name required');
        }
        else if ($('#billing_last_name').val().trim() == '') {
            $('#billing_last_name').css('border-color', 'red');
            $("#error_msg").text('Last name required');
        }
        else if ($('#billing_phone').val().trim() == '') {
            $('#billing_phone').css('border-color', 'red');
            $("#error_msg").text('Phone required');
        } else {
            $(".pay_btn").slideUp('fast');
            $(".pay_method").slideDown('slow');
            $("#bill_edit").show();
            $("#first_icon span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
            $('.shipp_wapper .checkout-title-section').css('color', '#000');
            $('.shipping__container').show();
            $('.shipping__container').html(
                `<div class="shipping-item-order-info">
                    <p class="shipping-name">${titleNeme}.  ${fName} ${lName}</p>
                    <p class="shipping-address">${instagram} </p>
                    <p class="shipping-address">${cPhone} </p>
                </div>
                `);
            scrollTop: $(".shipping__container").offset() + 60
            // 			$('html, body').animate({
            //              scrollTop: $(".my-custom-shipping-table")
            //             }, 700);
        }
        
    });    
	
	$("#billing_phone,#billing_first_name,#billing_last_name,#billing_address_1,#billing_city,#billing_postcode").on('keyup', function () {
        $('#error_msg').text('');
        $(this).css('border-color', 'green');
    })

    // $('.omnivalt_terminal')
    $(".add-gift-message").on('click', function (e) {
        e.preventDefault();
        $(".pay_btn").hide();
        $(".shi_container").slideUp();
        $(".gift-wrapper").slideDown();
        $("#shipping_edit").show();
        $("#2nd_step span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
        $("#checkout_payments .checkout-title-section").css('color', '#000');
    });
    $("#next_pay").on('click', function (e) {
        e.preventDefault();
        $(".pay_btn").hide();
        $(".shi_container").slideUp();
        $(".pay_method").slideDown();
        $("#shipping_edit").show();
        $("#2nd_step span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
        $("#checkout_payments .checkout-title-section").css('color', '#000');
    });

    $("#addGift, .skip-btn").on('click', function (e) {
        e.preventDefault();
        $(".pay_btn").hide();
        $(".gift-wrapper").slideUp();
        $(".pay_method").slideDown();
        $("#gift_edit").show();
        $("#third_step span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
        $("#third_step").css('color', '#000');
    });
    $('#gift_edit').on('click', function (e) {
        e.preventDefault();
        $(this).hide();
        $(".pay_btn").hide();
        $(".shi_container").slideUp();
        $(".gift-wrapper").slideDown();
        $(".pay_method").slideUp();
        $(".shi_container").slideUp();
        $("#2nd_step span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
        $("#checkout_payments .checkout-title-section").css('color', '#000');
    })
    $("#scroltoT").click(function (e) {
        e.preventDefault();
        //$("html, body").animate({ scrollTop: 20 }, "slow");
        $("#pay_edit").show();
        $("#3rd_step span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
        return false;
    });

    $("#bill_edit, #first_icon").on('click', function () {
        $(".pay_btn").slideDown();
        $(".shi_container").hide();
        $("#bill_edit").hide();
        $(".pay_method").hide();
        $('.shipping__container').hide();

    });
    $("#shipping_edit").on('click', function () {
        $(".pay_btn").hide();
        $(".shi_container").slideDown();
        $("#shipping_edit").hide();
        $(".pay_method").hide();
        $(".gift-wrapper").slideUp();
        $("#2nd_step").css('color', '#000');
        $("html, body").animate({ scrollTop: 20 }, "slow");
    });
    $("#pay_edit, #3rd_step").on('click', function () {
        $(".pay_btn").hide();
        $(".shi_container").hide();
        $("#pay_edit").hide();
        $(".pay_method").slideDown();
        $("#3rd_step").css('color', '#000');
    });

    $("#view_details").on('click', function () {
        $(".stock").slideDown();
        $(this).hide();
        $('#view_less').show();
    });
    $("#view_less").on('click', function () {
        // const view_text = $(this)
        $(".stock").slideUp();
        $(this).hide();
        $('#view_details').show();

    });
    $("#title").select2();
    var regExp = /[a-z]/i;
    $('#additional_phone').on('keydown keyup', function (e) {
        var value = String.fromCharCode(e.which) || e.key;

        // No letters
        if (regExp.test(value)) {
            e.preventDefault();
            return false;
        }
    });

    $(".method-Toggle").on('click', function () {
        $("#shipping_method").slideToggle();
    });

    $('.paysera-payment-method label').off().on('click', function () {
        $('.paysera-payment-method-label').not(this).addClass('hide');
        $('.payment-group-title').hide('slow');
        $('#change_gate').show();
        if ($(window).width() < 960) {
            $('#place_order').addClass('fixd_btn');
        }
    });
    $(document).on('click', '#default_btn', function (e) {
        e.preventDefault();
        $(".single_add_to_cart_button").trigger('click')
        setTimeout(function () {
            $("#apply_coupon_pro").trigger('click')
        }, 3000);
    });

});
$(document).on('click', '#change_gate', function () {
    $('.paysera-payment-method').find('.hide').removeClass('hide');
    $('#place_order').removeClass('fixd_btn')
    $(this).hide();
})
$(document).on('click', '.showcoupon', function () {
    $('#coupon-redeem').toggle();
});

if ($(window).width() < 960) {
    $(document).on('click', '.wc_payment_method', function () {
        $(this).siblings().hide();
		$('.wc_payment_method i').hide();
        $('#change_option').show();

    });
    $(document).on('click', '#change_option', function () {
        $(this).hide();
		$('#change_gate').hide();
        $('.wc_payment_method').slideDown();
        $('.payment_box').hide();
		$('.wc_payment_method i').show();
    })
}
$(document).on('change keyup', '.wcgwp-note', function () {
    let max_legth = 200;
    let currentLenght = $(this).val().length;
    let inquery = $('.inquery-counter');
    let inqueryCounter = max_legth - currentLenght;
    inquery.html(inqueryCounter);
})
$(document).on('click','.custom-li', function (e) {
    let radio = $(this).find('input:radio')
    radio.prop('checked', true);
})