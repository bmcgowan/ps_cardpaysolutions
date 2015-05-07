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

{if $cardpay_order.valid == 1}
<p class="alert alert-success success">
  {l s='Thank You! Your order is complete. Your reference number for this order is ' mod='cardpaysolutions'}<strong>{$cardpay_order.reference|escape:'html':'UTF-8'}</strong>
</p>
{else}
<p class="alert alert-danger error">
  {l s='Unfortunately, an error occurred during the transaction. Please double-check your credit card details and try again.' mod='cardpaysolutions'}
</p>
{/if}