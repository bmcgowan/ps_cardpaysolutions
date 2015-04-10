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
<link href="{$module_dir|escape:'htmlall':'UTF-8'}views/css/1.5/back.css" rel="stylesheet" type="text/css">
<div class="cardpay-module-wrapper">
  <div class="cardpay-module-header">
    <a rel="external" href="http://www.cardpaymerchant.com" target="_blank">
      <img class="cardpay-logo" alt="Cardpay Solutions" width="254" height="59" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cardpay_logo.png">
    </a>
    <span class="cardpay-module-intro">Secure payment software for both traditional and high-risk merchants.</span>
    <a class="cardpay-module-create-btn" rel="external" href="http://www.cardpaymerchant.com" target="_blank">
      <span>Apply Online Today!</span>
    </a>
  </div>
  <div class="cardpay-module-wrap">
    <div class="cardpay-module-col1 floatRight">
      <div class="cardpay-module-col1-wrap">
        <h3>Security Built In!</h3>
        <p>
          Our proprietary Three Step Redirect technology sends the sensitive card information directly from your customer's browser to our gateway 
          so that it never touches your server. This makes the process of meeting the card industry's PCI Compliance requirements as simple as
          filling out a short survey. There is no need for security scans of your server or expensive and complicated server software upgrades.
        </p>
        
      </div>
    </div>
    <div class="cardpay-module-col2">
      <div class="cardpay-module-col1inner">
        <h3>Why Us?</h3>
        <ul>
          <li>Rates starting at 1.89% + $0.23</li>
          <li>Free account set-up</li>
          <li>Next day funding</li>
          <li>Dedicated account manager</li>
          <li>Multiple bank relationships</li>
          <li>Chargeback Mitigation</li>
          <li>Fraud detection tools</li>
          <li>Free virtual terminal</li>
          <li>Automated recurring billing</li>
          <li>Simplified PCI compliance</li>
        </ul>
      </div>
      <div class="cardpay-module-col1inner floatRight">
        <h3>Supported Industries</h3>
        <ul>
          <li>All Traditional e-Commerce</li>
          <li>e-Cigarettes & Vaporizers</li>
          <li>Adult Products</li>
          <li>Supplements & Nutraceuticals</li>
          <li>Diet Programs</li>
          <li>PC Technical Support</li>
          <li>Tobacco Products</li>
          <li>Multi-Level Marketing</li>
          <li>Travel Agencies</li>
          <li>Furniture Stores</li>
          <li>Firearms & Accessories</li>
          <li>and many more...</li>
        </ul>
      </div>
      <div class="cardpay-module-col2inner">
        <h3>Accept all major credit cards!</h3>
        <p>
          <img class="cardpay-cc" alt="Cardpay Solutions" src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/cardpay-cc.png">
          <a class="cardpay-module-btn" href="http://www.cardpaymerchant.com" target="_blank">
            <strong>Apply Online Today!</strong>
          </a>
        </p>
      </div>
    </div>
  </div>
</div>

<form action="{$cardpay_form|escape:'htmlall':'UTF-8'}" method="post">
  <fieldset>
    <legend><img src="{$module_dir|escape:'htmlall':'UTF-8'}img/icon-config.gif" alt="" />{l s='Configuration' mod='cardpaysolutions'}</legend>
    <div style="clear: both;">
      <label>Live mode</label>
      <div class="margin-form" style="padding-top:5px;">
        <label class="t" for="CARDPAYSOLUTIONS_LIVE_MODE_on">
          <img title="Yes" alt="Yes" src="../img/admin/enabled.gif" />
        </label>
        <input id="CARDPAYSOLUTIONS_LIVE_MODE_on" type="radio" value="1" name="CARDPAYSOLUTIONS_LIVE_MODE" {if $CARDPAYSOLUTIONS_LIVE_MODE}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_LIVE_MODE_on"> Yes</label>
        <label class="t" for="CARDPAYSOLUTIONS_LIVE_MODE_off">
          <img style="margin-left: 10px;" title="No" alt="No" src="../img/admin/disabled.gif">
        </label>
        <input id="CARDPAYSOLUTIONS_LIVE_MODE_off" type="radio" value="0" name="CARDPAYSOLUTIONS_LIVE_MODE" {if !$CARDPAYSOLUTIONS_LIVE_MODE}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_LIVE_MODE_off"> No</label>
        <p style="clear:both">Use this module in live mode</p>
      </div>
    </div>
    <div style="clear: both;">
      <label>API Key</label>
      <div class="margin-form" style="padding-top:5px;">
        <input type="text" value="{$CARDPAYSOLUTIONS_API_KEY|escape:'htmlall':'UTF-8'}" name="CARDPAYSOLUTIONS_API_KEY" size="40">
        <p style="clear:both">API Key from your Cardpay Solutions account</p>
      </div>
    </div>
    <div style="clear: both;">
      <label>Default transaction type</label>
      <div class="margin-form" style="padding-top:5px;">
        <select id="CARDPAYSOLUTIONS_DEFAULT_TYPE" name="CARDPAYSOLUTIONS_DEFAULT_TYPE">
          <option value="sale">Authorize & Capture (sale)</option>
          <option value="auth">Authorize Only (auth)</option>
        </select>
      </div>
    </div>
    <div style="clear: both;">
      <label>Visa</label>
      <div class="margin-form" style="padding-top:5px;">
        <label class="t" for="CARDPAYSOLUTIONS_VI_ENABLED_on">
          <img title="Yes" alt="Yes" src="../img/admin/enabled.gif" />
        </label>
        <input id="CARDPAYSOLUTIONS_VI_ENABLED_on" type="radio" value="1" name="CARDPAYSOLUTIONS_VI_ENABLED" {if $CARDPAYSOLUTIONS_VI_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_VI_ENABLED_on"> Yes</label>
        <label class="t" for="CARDPAYSOLUTIONS_VI_ENABLED_off">
          <img style="margin-left: 10px;" title="No" alt="No" src="../img/admin/disabled.gif">
        </label>
        <input id="CARDPAYSOLUTIONS_VI_ENABLED_off" type="radio" value="0" name="CARDPAYSOLUTIONS_VI_ENABLED" {if !$CARDPAYSOLUTIONS_VI_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_VI_ENABLED_off"> No</label>
      </div>
    </div>
    <div style="clear: both;">
      <label>MasterCard</label>
      <div class="margin-form" style="padding-top:5px;">
        <label class="t" for="CARDPAYSOLUTIONS_MC_ENABLED_on">
          <img title="Yes" alt="Yes" src="../img/admin/enabled.gif" />
        </label>
        <input id="CARDPAYSOLUTIONS_MC_ENABLED_on" type="radio" value="1" name="CARDPAYSOLUTIONS_MC_ENABLED" {if $CARDPAYSOLUTIONS_MC_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_MC_ENABLED_on"> Yes</label>
        <label class="t" for="CARDPAYSOLUTIONS_MC_ENABLED_off">
          <img style="margin-left: 10px;" title="No" alt="No" src="../img/admin/disabled.gif">
        </label>
        <input id="CARDPAYSOLUTIONS_MC_ENABLED_off" type="radio" value="0" name="CARDPAYSOLUTIONS_MC_ENABLED" {if !$CARDPAYSOLUTIONS_MC_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_MC_ENABLED_off"> No</label>
      </div>
    </div>
    <div style="clear: both;">
      <label>Discover</label>
      <div class="margin-form" style="padding-top:5px;">
        <label class="t" for="CARDPAYSOLUTIONS_DS_ENABLED_on">
          <img title="Yes" alt="Yes" src="../img/admin/enabled.gif" />
        </label>
        <input id="CARDPAYSOLUTIONS_DS_ENABLED_on" type="radio" value="1" name="CARDPAYSOLUTIONS_DS_ENABLED" {if $CARDPAYSOLUTIONS_DS_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_DS_ENABLED_on"> Yes</label>
        <label class="t" for="CARDPAYSOLUTIONS_DS_ENABLED_off">
          <img style="margin-left: 10px;" title="No" alt="No" src="../img/admin/disabled.gif">
        </label>
        <input id="CARDPAYSOLUTIONS_DS_ENABLED_off" type="radio" value="0" name="CARDPAYSOLUTIONS_DS_ENABLED" {if !$CARDPAYSOLUTIONS_DS_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_DS_ENABLED_off"> No</label>
      </div>
    </div>
    <div style="clear: both;">
      <label>American Express</label>
      <div class="margin-form" style="padding-top:5px;">
        <label class="t" for="CARDPAYSOLUTIONS_AX_ENABLED_on">
          <img title="Yes" alt="Yes" src="../img/admin/enabled.gif" />
        </label>
        <input id="CARDPAYSOLUTIONS_AX_ENABLED_on" type="radio" value="1" name="CARDPAYSOLUTIONS_AX_ENABLED" {if $CARDPAYSOLUTIONS_AX_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_AX_ENABLED_on"> Yes</label>
        <label class="t" for="CARDPAYSOLUTIONS_AX_ENABLED_off">
          <img style="margin-left: 10px;" title="No" alt="No" src="../img/admin/disabled.gif">
        </label>
        <input id="CARDPAYSOLUTIONS_AX_ENABLED_off" type="radio" value="0" name="CARDPAYSOLUTIONS_AX_ENABLED" {if !$CARDPAYSOLUTIONS_AX_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_AX_ENABLED_off"> No</label>
      </div>
    </div>
    <div style="clear: both;">
      <label>JCB</label>
      <div class="margin-form" style="padding-top:5px;">
        <label class="t" for="CARDPAYSOLUTIONS_JC_ENABLED_on">
          <img title="Yes" alt="Yes" src="../img/admin/enabled.gif" />
        </label>
        <input id="CARDPAYSOLUTIONS_JC_ENABLED_on" type="radio" value="1" name="CARDPAYSOLUTIONS_JC_ENABLED" {if $CARDPAYSOLUTIONS_JC_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_JC_ENABLED_on"> Yes</label>
        <label class="t" for="CARDPAYSOLUTIONS_JC_ENABLED_off">
          <img style="margin-left: 10px;" title="No" alt="No" src="../img/admin/disabled.gif">
        </label>
        <input id="CARDPAYSOLUTIONS_JC_ENABLED_off" type="radio" value="0" name="CARDPAYSOLUTIONS_JC_ENABLED" {if !$CARDPAYSOLUTIONS_JC_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_JC_ENABLED_off"> No</label>
      </div>
    </div>
    <div style="clear: both;">
      <label>Diners Club</label>
      <div class="margin-form" style="padding-top:5px;">
        <label class="t" for="CARDPAYSOLUTIONS_DN_ENABLED_on">
          <img title="Yes" alt="Yes" src="../img/admin/enabled.gif" />
        </label>
        <input id="CARDPAYSOLUTIONS_DN_ENABLED_on" type="radio" value="1" name="CARDPAYSOLUTIONS_DN_ENABLED" {if $CARDPAYSOLUTIONS_DN_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_DN_ENABLED_on"> Yes</label>
        <label class="t" for="CARDPAYSOLUTIONS_DN_ENABLED_off">
          <img style="margin-left: 10px;" title="No" alt="No" src="../img/admin/disabled.gif">
        </label>
        <input id="CARDPAYSOLUTIONS_DN_ENABLED_off" type="radio" value="0" name="CARDPAYSOLUTIONS_DN_ENABLED" {if !$CARDPAYSOLUTIONS_DN_ENABLED}checked="checked"{/if}>
        <label class="t" for="CARDPAYSOLUTIONS_DN_ENABLED_off"> No</label>
      </div>
    </div>
    <div style="clear:both; margin-top: 10px;">
      <label>&nbsp;</label>
      <input class="button" type="submit" name="submitCardpaysolutionsModule" value=" Save ">
    </div>
  </fieldset>
</form>
