{*
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
*}
<div id="cardpay_module_1_5" {if $cardpay_ps_version < '1.5'} class="payment_module"{/if} style="border: 1px solid #595A5E; padding: 0.6em;{if $cardpay_ps_version < '1.5'} margin-left: 0.7em;{/if} margin-bottom: 2.0em;">
  <h3 class="cc-head-1-5"><img alt="" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/secure-icon.png" class="secure-icon" />{l s='Secure Credit Card Payment' mod='cardpaysolutions'}</h3>
  {if !$cardpay_live_mode}<div class="warning"><p>Warning: Payment Module is in test mode. Transaction will not be processed or funded.</p></div>{/if}
  {if isset($smarty.get.cardpayError)}<div class="error"><p>{$smarty.get.cardpayError|escape:'htmlall':'UTF-8'}</p></div>{/if}
  {if isset($cardpay_error)}<div class="error"><p>{$cardpay_error|escape:'htmlall':'UTF-8'}</p></div>{/if}
  <form action="{$form_url|escape:'htmlall':'UTF-8'}" method="post" name="cardpay_form" id="cardpay_form" class="form-horizontal">
    <input type="hidden" name="billing-cc-exp" id="billing-cc-exp" value=""/>
    <p class="text">
      <label>&nbsp;</label>
      <span class="logo-container"{if $cardpay_ps_version > '1.4.11'} style="margin-left:0"{/if}>
        {if $cardpay_vi_enabled}<img class="cc-logo" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cc-visa.png"/>{/if}
        {if $cardpay_mc_enabled}<img class="cc-logo" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cc-mastercard.png"/>{/if}
        {if $cardpay_ds_enabled}<img class="cc-logo" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cc-discover.png"/>{/if}
        {if $cardpay_ax_enabled}<img class="cc-logo" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cc-amex.png"/>{/if}
        {if $cardpay_jc_enabled}<img class="cc-logo" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cc-jcb.png"/>{/if}
        {if $cardpay_dn_enabled}<img class="cc-logo" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cc-diners.png"/>{/if}
      </span>
    </p>
    <p class="required text">
      <label for="ccnumber">{l s='Card Number:' mod='cardpaysolutions'} <sup>*</sup></label>
      <input type="text" name="billing-cc-number" id="billing-cc-number" autocomplete="off" />
    </p>
    <p class="required text">
      <label for="exp_month">{l s='Expiration Date:' mod='cardpaysolutions'} <sup>*</sup></label>
      <select id="exp_month" name="exp_month">
        <option value="">--</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select><span style="color:#000000; margin-right:5px;"> / </span>
      <select id="exp_year" name="exp_year">
        <option value="">--</option>
      {section name=date_y start=$current_year loop=$current_year+10}
        <option value="{$smarty.section.date_y.index|escape}">20{$smarty.section.date_y.index|escape}</option>
      {/section}
      </select>
    </p>
    <p class="required text">
      <label for="cvv">{l s='CVV:' mod='cardpaysolutions'} <sup>*</sup></label>
      <input type="text" name="cvv" id="cvv" />
    </p>
    <p class="cc-actions">
      <label>&nbsp;</label>
      <input type="submit" id="cardpay_submit" value="{l s='Complete Order' mod='cardpaysolutions'}" class="button btn btn-primary exclusive" style="display:inline;"{if isset($cardpay_error)} disabled{/if} />
    </p>
  </form>
</div>
