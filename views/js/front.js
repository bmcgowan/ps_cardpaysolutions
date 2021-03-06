/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    Cardpay Solutions, Inc. <sales@cardpaymerchant.com>
 *  @copyright 2015 Cardpay Solutions, Inc.
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

$(document).ready(function () {
  $("#exp_month").change(function () {
    $("#billing-cc-exp").val($("#exp_month").val()+$("#exp_year").val());
  });
  $("#exp_year").change(function () {
    $("#billing-cc-exp").val($("#exp_month").val()+$("#exp_year").val());
  });
});

$(document).ready(function () {
  $("#cardpay_form").submit(function () {
  	$("#cardpay_submit").val("Processing, please wait.....");
	$("#cardpay_submit").attr("disabled", true);
  });
});

$(document).ready(function () {
  if (window.location.search.match("cardpayError")) {
  	$('html, body').animate({
      scrollTop: $("#HOOK_PAYMENT").offset().top
    }, 100);
  }
});
