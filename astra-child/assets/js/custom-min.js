var $ = jQuery; $((function () { $("#add_number_checkbox").on("change", (function () { this.checked ? (jQuery("#additional_phone_field").fadeIn(), jQuery("#additional_phone_field").attr("required", !0), jQuesry("#additional_phone_field").prop("pattern", "^[a-zA-Z]{6}[0-9]{2}[a-zA-Z][0-9]{2}[a-zA-Z][0-9]{3}[a-zA-Z]$")) : (jQuery("#additional_phone_field").fadeOut(), jQuery("#additional_phone_field input").val(""), jQuery("#additional_phone_field").attr("required", !1)) })), $("#billing_for_payement, #2nd_step").on("click", (function (e) { e.preventDefault(); var i = $("#title").val().toUpperCase(), n = $("#billing_first_name").val(), t = $("#billing_last_name").val(), o = $("#billing_address_1").val(), l = $("#billing_city").val(), s = $("#billing_postcode").val(), r = $("#billing_phone").val(); "" == $("#title").val().trim() ? ($("#title").css("border-color", "red"), $("#error_msg").text("Title required")) : "" == $("#billing_first_name").val().trim() ? ($("#billing_first_name").css("border-color", "red"), $("#error_msg").text("First name required")) : "" == $("#billing_last_name").val().trim() ? ($("#billing_last_name").css("border-color", "red"), $("#error_msg").text("Last name required")) : "" == $("#billing_city").val().trim() ? ($("#billing_city").css("border-color", "red"), $("#error_msg").text("City required")) : "" == $("#billing_address_1").val().trim() ? ($("#billing_address_1").css("border-color", "red"), $("#error_msg").text("Address required")) : "" == $("#billing_postcode").val().trim() ? ($("#billing_postcode").css("border-color", "red"), $("#error_msg").text("Postcode required")) : "" == $("#billing_phone").val().trim() ? ($("#billing_phone").css("border-color", "red"), $("#error_msg").text("Phone required")) : ($(".pay_btn").slideUp("fast"), $(".shi_container").slideDown("slow"), $("#bill_edit").show(), $("#first_icon span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>'), $(".shipp_wapper .checkout-title-section").css("color", "#000"), $(".shipping__container").show(), $(".shipping__container").html(`<div class="shipping-item-order-info">\n                    <p class="shipping-name">${i}.  ${n} ${t}</p>\n                    <p class="shipping-address">${o} </p>\n                    <p class="shipping-address">${l} ${s}</p>\n                    <p class="shipping-address">${r} </p>\n                </div>\n                `), $(".shipping__container").offset()) })), $("#billing_phone,#billing_first_name,#billing_last_name,#billing_address_1,#billing_city,#billing_postcode").on("keyup", (function () { $("#error_msg").text(""), $(this).css("border-color", "green") })), $("#next_pay").on("click", (function (e) { e.preventDefault(), $(".pay_btn").hide(), $(".shi_container").slideUp(), $(".pay_method").slideDown(), $("#shipping_edit").show(), $("#2nd_step span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>'), $("#checkout_payments .checkout-title-section").css("color", "#000") })), $("#scroltoT").click((function (e) { return e.preventDefault(), $("#pay_edit").show(), $("#3rd_step span").html('<i class="fa fa-check-circle" aria-hidden="true"></i>'), !1 })), $("#bill_edit, #first_icon").on("click", (function () { $(".pay_btn").slideDown(), $(".shi_container").hide(), $("#bill_edit").hide(), $(".pay_method").hide(), $(".shipping__container").hide() })), $("#shipping_edit").on("click", (function () { $(".pay_btn").hide(), $(".shi_container").slideDown(), $("#shipping_edit").hide(), $(".pay_method").hide(), $("#2nd_step").css("color", "#000"), $("html, body").animate({ scrollTop: 20 }, "slow") })), $("#pay_edit, #3rd_step").on("click", (function () { $(".pay_btn").hide(), $(".shi_container").hide(), $("#pay_edit").hide(), $(".pay_method").slideDown(), $("#3rd_step").css("color", "#000") })), $("#view_details").on("click", (function () { $(".stock").slideDown(), $(this).hide(), $("#view_less").show() })), $("#view_less").on("click", (function () { $(".stock").slideUp(), $(this).hide(), $("#view_details").show() })), $("#title").select2(); var e = /[a-z]/i; $("#additional_phone").on("keydown keyup", (function (i) { var n = String.fromCharCode(i.which) || i.key; if (e.test(n)) return i.preventDefault(), !1 })), $(".method-Toggle").on("click", (function () { $("#shipping_method").slideToggle() })), $(".paysera-payment-method label").off().on("click", (function () { $(".paysera-payment-method-label").not(this).addClass("hide"), $(".payment-group-title").hide("slow"), $("#change_gate").show(), $(window).width() < 960 && $("#place_order").addClass("fixd_btn") })), $(document).on("click", "#default_btn", (function (e) { e.preventDefault(), $(".single_add_to_cart_button").trigger("click"), setTimeout((function () { $("#apply_coupon_pro").trigger("click") }), 3e3) })) })), $(document).on("click", "#change_gate", (function () { $(".paysera-payment-method").find(".hide").removeClass("hide"), $("#place_order").removeClass("fixd_btn"), $(this).hide() })), $(document).on("click", ".showcoupon", (function () { $("#coupon-redeem").toggle() })), $(document).on("click", ".wc_payment_method", (function () { $(this).siblings().hide(), $("#change_option").show() })), $(document).on("click", "#change_option", (function () { $(this).hide(), $(".wc_payment_method").slideDown(), $(".payment_box").hide() }));