<?php
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

$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'cardpaysolutions` (
    `id_cardpaysolutions` int(11) NOT NULL AUTO_INCREMENT,
    `id_cart` int(11) NOT NULL,
    `trans_type` varchar(11) DEFAULT NULL,
    `responsetext` varchar(11) DEFAULT NULL,
    `cc_last_four` varchar(11) DEFAULT NULL,
    `card_type` varchar(11) DEFAULT NULL,
    `amount` decimal(20,6) NOT NULL,
    `cardholder_name` varchar(11) DEFAULT NULL,
    `ccexp` varchar(11) DEFAULT NULL,
    `authcode` varchar(11) DEFAULT NULL,
    `transactionid` varchar(11) DEFAULT NULL,
    `avsresponse` varchar(11) DEFAULT NULL,
    `cvvresponse` varchar(11) DEFAULT NULL,
    `id_shop` int(10) DEFAULT NULL,
    `date_add` datetime NOT NULL,
    `date_void` datetime DEFAULT NULL,
    `date_refund` datetime DEFAULT NULL,
    `date_capture` datetime DEFAULT NULL,
    PRIMARY KEY  (`id_cardpaysolutions`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query)
	if (Db::getInstance()->execute($query) == false)
		return false;
