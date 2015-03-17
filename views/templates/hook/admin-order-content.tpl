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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="tab-pane" id="cardpaysolutions">
  {if isset($cardpay_message)}<p class="alert alert-success">{$cardpay_message|escape:'htmlall':'UTF-8'}</p>{/if}
  {if isset($cardpay_error)}<p class="alert alert-danger">{$cardpay_error|escape:'htmlall':'UTF-8'}</p>{/if}
  <table class="table" style="margin-bottom:20px;">
    <tr>
      <td style="width:200px;">{l s='Status:' mod='cardpaysolutions'}</td>
      <td><span style="font-weight: bold; color: {if $cardpay_responsetext == 'SUCCESS'}green;">{l s='Approved' mod='cardpaysolutions'}{else}red;">{l s='Declined' mod='cardpaysolutions'}{/if}</span></td>
    </tr>
    <tr>
      <td>{l s='Bank message:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_responsetext|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='Trans type:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_trans_type|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='Amount:' mod='cardpaysolutions'}</td>
      <td><span style="font-weight: bold;">{$cardpay_amount|escape:'htmlall':'UTF-8'}</span></td>
    </tr>
    <tr>
      <td>{l s='Card:' mod='cardpaysolutions'}</td>
      <td>***{$cardpay_cc_last_four|escape:'htmlall':'UTF-8'} ({$cardpay_card_type|escape:'htmlall':'UTF-8'})</td>
    </tr>
    <tr>
      <td>{l s='Card expiry:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_ccexp|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='Card Holder:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_cardholder_name|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='Authorization Number:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_authcode|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='Transaction ID:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_transactionid|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='AVS Response:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_avsresponse|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='CVV Response:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_cvvresponse|escape:'htmlall':'UTF-8'}</td>
    </tr>
    <tr>
      <td>{l s='Transaction Date:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_date_add|escape:'htmlall':'UTF-8'}</td>
    </tr>
    {if $cardpay_date_capture != ''}
    <tr>
      <td>{l s='Capture Date:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_date_capture|escape:'htmlall':'UTF-8'}</td>
    </tr>
    {/if}
    {if $cardpay_date_void != ''}
    <tr>
      <td>{l s='Void Date:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_date_void|escape:'htmlall':'UTF-8'}</td>
    </tr>
    {/if}
    {if $cardpay_date_refund != ''}
    <tr>
      <td>{l s='Refund Date:' mod='cardpaysolutions'}</td>
      <td>{$cardpay_date_refund|escape:'htmlall':'UTF-8'}</td>
    </tr>
    {/if}
    
  </table>
  {if $cardpay_responsetext == 'SUCCESS' && ($cardpay_date_void == '' || $cardpay_date_refund == '')}
    <form action="{$cardpay_form|escape:'htmlall':'UTF-8'}" method="post">
      <div class="row">
        {if $cardpay_trans_type == 'auth' && $cardpay_date_void == '' && $cardpay_date_capture == ''}
          <div class="col-lg-2">
            <input class="btn btn-primary btn-block cc-action" onclick="return confirm('{l s='Are you sure you want to capture this transaction?' mod='cardpaysolutions' js=1}');" type="submit" name="submitCapture" value="{l s='Capture' mod='cardpaysolutions'}" />
          </div>
        {/if}
        {if $cardpay_date_void == '' && $cardpay_date_refund == ''}
          <div class="col-lg-2">
            <input class="btn btn-primary btn-block cc-action" onclick="return confirm('{l s='Are you sure you want to void this transaction?' mod='cardpaysolutions' js=1}');" type="submit" name="submitVoid" value="{l s='Void' mod='cardpaysolutions'}" />
          </div>
        {/if}
        {if ($cardpay_trans_type == 'sale' && $cardpay_date_refund == '' && $cardpay_date_void =='') || ($cardpay_trans_type == 'auth' && $cardpay_date_capture != '' && $cardpay_date_refund == '' && $cardpay_date_void =='')}
          <div class="col-lg-2">
            <input class="btn btn-primary btn-block cc-action" onclick="return confirm('{l s='Are you sure you want to refund the full amount of this transaction?' mod='cardpaysolutions' js=1}');" type="submit" name="submitRefund" value="{l s='Refund' mod='cardpaysolutions'}" />
          </div>
        {/if}
      </div>
    </form>
  {/if}
  <p>To process a partial refund, to run a manual transaction in the virtual terminal, or for advanced transaction reporting, please <a href="https://cardpaysolutions.transactiongateway.com/merchants/login.php" target="_blank">Click Here</a> to log into your Cardpay Solutions gateway account.</p>
</div>