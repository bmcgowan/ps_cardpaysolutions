<?php
/**
 * 2007-2014 PrestaShop
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

if (!defined('_PS_VERSION_'))
	exit;

class Cardpaysolutions extends PaymentModule
{
	protected $config_form = false;

	public function __construct()
	{
		$this->name          = 'cardpaysolutions';
		$this->tab           = 'payments_gateways';
		$this->version       = '1.0.2';
		$this->author        = 'Cardpay Solutions Inc';
		$this->module_key    = '82a58aa802f1dcf3971a79c229d0cc59';
		$this->need_instance = 0;

		/**
		 * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
		 */
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Cardpay Solutions');
		$this->description = $this->l('Accept credit card payments (specializing in both traditional and high-risk merchant categories)');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall the Cardpay Solutions module?');

		/* Ensure that cURL is enabled */
		if (!is_callable('curl_exec'))
			$this->warning = $this->l('cURL extension must be enabled on your server to use this module.');

		if (_PS_VERSION_ < '1.5')
			require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
	}

	/**
	 * Don't forget to create update methods if needed:
	 * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
	 */
	public function install()
	{
		Configuration::updateValue('CARDPAYSOLUTIONS_LIVE_MODE', true);
		Configuration::updateValue('CARDPAYSOLUTIONS_DEFAULT_TYPE', 'sale');
		Configuration::updateValue('CARDPAYSOLUTIONS_VI_ENABLED', true);
		Configuration::updateValue('CARDPAYSOLUTIONS_MC_ENABLED', true);
		Configuration::updateValue('CARDPAYSOLUTIONS_DS_ENABLED', true);
		Configuration::updateValue('CARDPAYSOLUTIONS_AX_ENABLED', true);
		Configuration::updateValue('CARDPAYSOLUTIONS_JC_ENABLED', true);
		Configuration::updateValue('CARDPAYSOLUTIONS_DN_ENABLED', true);

		include(dirname(__FILE__).'/sql/install.php');

		return parent::install() && $this->registerHook('header') && $this->registerHook('payment') && $this->registerHook('adminOrder')
			&& $this->registerHook('BackOfficeHeader') && $this->registerHook('orderConfirmation') && $this->registerHook('displayAdminOrderTabOrder')
			&& $this->registerHook('displayAdminOrderContentOrder');
	}

	public function uninstall()
	{
		Configuration::deleteByName('CARDPAYSOLUTIONS_LIVE_MODE');
		Configuration::deleteByName('CARDPAYSOLUTIONS_API_KEY');
		Configuration::deleteByName('CARDPAYSOLUTIONS_DEFAULT_TYPE');
		Configuration::deleteByName('CARDPAYSOLUTIONS_VI_ENABLED');
		Configuration::deleteByName('CARDPAYSOLUTIONS_MC_ENABLED');
		Configuration::deleteByName('CARDPAYSOLUTIONS_DS_ENABLED');
		Configuration::deleteByName('CARDPAYSOLUTIONS_AX_ENABLED');
		Configuration::deleteByName('CARDPAYSOLUTIONS_JC_ENABLED');
		Configuration::deleteByName('CARDPAYSOLUTIONS_DN_ENABLED');

		include(dirname(__FILE__).'/sql/uninstall.php');

		return parent::uninstall();
	}

	/**
	 * Load the configuration form
	 */
	public function getContent()
	{
		/**
		 * If values have been submitted in the form, process.
		 */
		$api_key = Tools::getValue('CARDPAYSOLUTIONS_API_KEY');
		$this->context->smarty->assign('module_dir', $this->_path);

		if (_PS_VERSION_ > '1.5.9.9')
			$output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/1.6/configure.tpl');
		else
		{
			$this->context->smarty->assign('cardpay_form', './index.php?tab=AdminModules&configure=cardpaysolutions&token='
				.Tools::getAdminTokenLite('AdminModules').'&tab_module='.$this->tab.'&module_name=cardpaysolutions');
			$this->context->smarty->assign($this->getConfigFormValues());
		}

		if (Tools::isSubmit('submitCardpaysolutionsModule'))
		{
			if (!empty($api_key))
			{
				if (_PS_VERSION_ > '1.5.9.9')
				{
					$this->postProcess();
					$output .= $this->displayConfirmation($this->l('Configuration values successfully saved.'));
				}
				else
				{
					$this->postProcess();
					$this->context->smarty->assign('cardpay_conf', $this->l('Configuration values successfully saved.'));
					$this->context->smarty->assign($this->getConfigFormValues());
				}
			}
			else
			{
				if (_PS_VERSION_ > '1.5.9.9')
					$output .= $this->displayError($this->l('Please complete all required fields.'));
				else
					$this->context->smarty->assign('cardpay_error', $this->l('Please complete all required fields.'));
			}
		}
		if (_PS_VERSION_ > '1.5.9.9')
			return $output.$this->renderForm();
		else
			return $this->display(__FILE__, 'views/templates/admin/1.5/configure.tpl');
	}

	/**
	 * Create the form that will be displayed in the configuration of your module.
	 */
	protected function renderForm()
	{
		$helper = new HelperForm();

		$helper->show_toolbar             = false;
		$helper->table                    = $this->table;
		$helper->module                   = $this;
		$helper->default_form_language    = $this->context->language->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

		$helper->identifier    = $this->identifier;
		$helper->submit_action = 'submitCardpaysolutionsModule';
		$helper->currentIndex  = $this->context->link->getAdminLink('AdminModules', false)
			.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token         = Tools::getAdminTokenLite('AdminModules');

		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFormValues(),
			/* Add values for your inputs */
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array(
			$this->getConfigForm()
		));
	}

	/**
	 * Create the structure of your form.
	 */
	protected function getConfigForm()
	{
		return array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'radio',
						'label' => $this->l('Live mode'),
						'name' => 'CARDPAYSOLUTIONS_LIVE_MODE',
						'class' => 't',
						'is_bool' => true,
						'desc' => $this->l('Use this module in live mode'),
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						)
					),
					array(
						'col' => 3,
						'type' => 'text',
						'desc' => $this->l('API Key from your Cardpay Solutions account'),
						'name' => 'CARDPAYSOLUTIONS_API_KEY',
						'required' => true,
						'label' => $this->l('API Key')
					),
					array(
						'type' => 'select',
						'label' => $this->l('Default transaction type'),
						'name' => 'CARDPAYSOLUTIONS_DEFAULT_TYPE',
						'required' => true,
						'options' => array(
							'query' => array(
								array(
									'id_option' => 'sale',
									'name' => 'Authorize & Capture (sale)'
								),
								array(
									'id_option' => 'auth',
									'name' => 'Authorize Only (auth)'
								)
							),
							'id' => 'id_option',
							'name' => 'name'
						)
					),
					array(
						'type' => 'radio',
						'label' => $this->l('Visa'),
						'name' => 'CARDPAYSOLUTIONS_VI_ENABLED',
						'class' => 't',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						)
					),
					array(
						'type' => 'radio',
						'label' => $this->l('MasterCard'),
						'name' => 'CARDPAYSOLUTIONS_MC_ENABLED',
						'class' => 't',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						)
					),
					array(
						'type' => 'radio',
						'label' => $this->l('Discover'),
						'name' => 'CARDPAYSOLUTIONS_DS_ENABLED',
						'class' => 't',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						)
					),
					array(
						'type' => 'radio',
						'label' => $this->l('American Express'),
						'name' => 'CARDPAYSOLUTIONS_AX_ENABLED',
						'class' => 't',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						)
					),
					array(
						'type' => 'radio',
						'label' => $this->l('JCB'),
						'name' => 'CARDPAYSOLUTIONS_JC_ENABLED',
						'class' => 't',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						)
					),
					array(
						'type' => 'radio',
						'label' => $this->l('Diners Club'),
						'name' => 'CARDPAYSOLUTIONS_DN_ENABLED',
						'class' => 't',
						'is_bool' => true,
						'values' => array(
							array(
								'id' => 'active_on',
								'value' => true,
								'label' => $this->l('Enabled')
							),
							array(
								'id' => 'active_off',
								'value' => false,
								'label' => $this->l('Disabled')
							)
						)
					)
				),
				'submit' => array(
					'title' => $this->l('Save'),
					'class' => 'button'
				)
			)
		);
	}

	/**
	 * Set values for the inputs.
	 */
	protected function getConfigFormValues()
	{
		return array(
			'CARDPAYSOLUTIONS_LIVE_MODE' => Configuration::get('CARDPAYSOLUTIONS_LIVE_MODE'),
			'CARDPAYSOLUTIONS_API_KEY' => Configuration::get('CARDPAYSOLUTIONS_API_KEY'),
			'CARDPAYSOLUTIONS_DEFAULT_TYPE' => Configuration::get('CARDPAYSOLUTIONS_DEFAULT_TYPE'),
			'CARDPAYSOLUTIONS_VI_ENABLED' => Configuration::get('CARDPAYSOLUTIONS_VI_ENABLED'),
			'CARDPAYSOLUTIONS_MC_ENABLED' => Configuration::get('CARDPAYSOLUTIONS_MC_ENABLED'),
			'CARDPAYSOLUTIONS_DS_ENABLED' => Configuration::get('CARDPAYSOLUTIONS_DS_ENABLED'),
			'CARDPAYSOLUTIONS_AX_ENABLED' => Configuration::get('CARDPAYSOLUTIONS_AX_ENABLED'),
			'CARDPAYSOLUTIONS_JC_ENABLED' => Configuration::get('CARDPAYSOLUTIONS_JC_ENABLED'),
			'CARDPAYSOLUTIONS_DN_ENABLED' => Configuration::get('CARDPAYSOLUTIONS_DN_ENABLED')
		);
	}

	/**
	 * Save form data.
	 */
	protected function postProcess()
	{
		$form_values = $this->getConfigFormValues();

		foreach (array_keys($form_values) as $key)
			Configuration::updateValue($key, Tools::getValue($key));
	}

	/**
	 * Add the CSS & JavaScript files you want to be loaded in the BO.
	 */
	public function hookBackOfficeHeader()
	{
		$this->context->controller->addJS($this->_path.'views/js/back.js');
		$this->context->controller->addCSS($this->_path.'views/css/back.css');
	}

	/**
	 * Add the CSS & JavaScript files you want to be added on the FO.
	 */
	public function hookHeader()
	{
		$this->context->controller->addJS($this->_path.'views/js/front.js');
		$this->context->controller->addCSS($this->_path.'views/css/front.css');
	}

	public function hookDisplayAdminOrderTabOrder($params)
	{
		if (!$this->active)
			return false;
		$order = new Order((int)$params['order']->id);
		if ($order->module != $this->name)
			return false;
		if (!Validate::isLoadedObject($order))
			return false;

		return $this->display(__FILE__, 'views/templates/hook/1.6/admin-order-tab.tpl');
	}

	public function hookDisplayAdminOrderContentOrder($params)
	{
		if (!$this->active)
			return false;
		if (_PS_VERSION_ > '1.5.9.9')
			$order = new Order((int)$params['order']->id);
		else
			$order = new Order((int)$params['id_order']);
		if ($order->module != $this->name)
			return false;
		if (!Validate::isLoadedObject($order))
			return false;

		if (Tools::isSubmit('submitCapture'))
			$transaction_type = 'capture';
		if (Tools::isSubmit('submitVoid'))
			$transaction_type = 'void';
		if (Tools::isSubmit('submitRefund'))
			$transaction_type = 'refund';

		$transaction = $this->getTransaction((int)$order->id_cart);

		$avs_messages = $this->avsResponses();
		$cvv_messages = $this->cvvResponses();

		if (isset($transaction_type))
		{
			$mode = Configuration::get('CARDPAYSOLUTIONS_LIVE_MODE');
			$api_key = $mode ? Configuration::get('CARDPAYSOLUTIONS_API_KEY') : '2F822Rw39fx762MaV7Yy86jXGTC7sCDy';

			$xml_request = new DOMDocument('1.0', 'UTF-8');
			$xml_request->formatOutput = true;
			$xml_trans = $xml_request->createElement($transaction_type);
			$this->appendXmlNode($xml_request, $xml_trans, 'api-key', $api_key);
			$this->appendXmlNode($xml_request, $xml_trans, 'transaction-id', (int)$transaction['transactionid']);
			if ($transaction_type != 'void')
				$this->appendXmlNode($xml_request, $xml_trans, 'amount', number_format((float)$transaction['amount'], 2, '.', ''));
			$xml_request->appendChild($xml_trans);
			$response = $this->doPost($xml_request);

			if ((string)$response->result == 1)
			{
				if ($transaction_type == 'capture')
				{
					Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'cardpaysolutions` SET date_capture = NOW() WHERE `id_cart` = '.(int)$order->id_cart);
					$conf_message = $this->l('Order successfully captured.');
				}
				if ($transaction_type == 'void')
				{
					Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'cardpaysolutions` SET date_void = NOW() WHERE `id_cart` = '.(int)$order->id_cart);
					$conf_message = $this->l('Order successfully voided.');
				}
				if ($transaction_type == 'refund')
				{
					Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'cardpaysolutions` SET date_refund = NOW() WHERE `id_cart` = '.(int)$order->id_cart);
					$conf_message = $this->l('Order successfully refunded.');
				}
				$transaction = $this->getTransaction((int)$order->id_cart);
			}
			else
				$error_message = (string)$response->{'result-text'};
		}

		$this->context->smarty->assign(array(
			'cardpay_form' => './index.php?tab=AdminOrders&id_order='.(int)$order->id.'&vieworder&token='.Tools::getAdminTokenLite('AdminOrders'),
			'cardpay_responsetext' => $transaction['responsetext'],
			'cardpay_trans_type' => $transaction['trans_type'],
			'cardpay_cc_last_four' => $transaction['cc_last_four'],
			'cardpay_card_type' => $transaction['card_type'],
			'cardpay_amount' => number_format($transaction['amount'], 2, '.', ''),
			'cardpay_cardholder_name' => $transaction['cardholder_name'],
			'cardpay_ccexp' => $transaction['ccexp'],
			'cardpay_transactionid' => $transaction['transactionid'],
			'cardpay_avsresponse' => $avs_messages[$transaction['avsresponse']],
			'cardpay_cvvresponse' => $cvv_messages[$transaction['cvvresponse']],
			'cardpay_authcode' => $transaction['authcode'],
			'cardpay_date_add' => $transaction['date_add'],
			'cardpay_date_void' => $transaction['date_void'],
			'cardpay_date_refund' => $transaction['date_refund'],
			'cardpay_date_capture' => $transaction['date_capture'],
			'cardpay_message' => $conf_message,
			'cardpay_error' => $error_message,
			'ps_version' => _PS_VERSION_
		));

		return $this->display(__FILE__, (_PS_VERSION_ > '1.5.9.9' ? 'views/templates/hook/1.6/':'views/templates/hook/1.5/').'admin-order-content.tpl');
	}

	public function hookAdminOrder($params)
	{
		return $this->hookDisplayAdminOrderContentOrder($params);
	}

	public function hookOrderConfirmation($params)
	{
		if ($params['objOrder']->module != $this->name)
			return false;
		if ($params['objOrder'] && Validate::isLoadedObject($params['objOrder']) && isset($params['objOrder']->valid))
		{
			if (version_compare(_PS_VERSION_, '1.5', '>=') && isset($params['objOrder']->reference))
			{
				$this->context->smarty->assign('cardpay_order', array(
					'id' => $params['objOrder']->id,
					'reference' => $params['objOrder']->reference,
					'valid' => $params['objOrder']->valid
				));
			}
			else
			{
				$this->context->smarty->assign('cardpay_order', array(
					'id' => $params['objOrder']->id,
					'reference' => '#'.sprintf('%06d', $params['objOrder']->id),
					'valid' => $params['objOrder']->valid
				));
			}
			return $this->display(__FILE__, 'views/templates/hook/order-confirmation.tpl');
		}
	}

	public function hookPayment()
	{
		if (!$this->active)
			return;
		if (!Configuration::get('CARDPAYSOLUTIONS_API_KEY'))
			return false;
		$cart = $this->context->cart;
		$customer = new Customer((int)$cart->id_customer);
		$billing_address = new Address((int)$cart->id_address_invoice);
		$cart_summary = $cart->getSummaryDetails();
		$mode = Configuration::get('CARDPAYSOLUTIONS_LIVE_MODE');
		$api_key = $mode ? Configuration::get('CARDPAYSOLUTIONS_API_KEY') : '2F822Rw39fx762MaV7Yy86jXGTC7sCDy';

		$xml_request = new DOMDocument('1.0', 'UTF-8');
		$xml_request->formatOutput = true;
		$xml_trans = $xml_request->createElement(Tools::safeOutput(Configuration::get('CARDPAYSOLUTIONS_DEFAULT_TYPE')));
		$this->appendXmlNode($xml_request, $xml_trans, 'api-key', Tools::safeOutput($api_key));
		$this->appendXmlNode($xml_request, $xml_trans, 'redirect-url', _PS_BASE_URL_.$this->_path.'validation.php?cart='.$cart->id);
		$this->appendXmlNode($xml_request, $xml_trans, 'amount', number_format((float)$cart->getOrderTotal(true, 3), 2, '.', ''));
		$this->appendXmlNode($xml_request, $xml_trans, 'order-id', (int)$cart->id);
		$this->appendXmlNode($xml_request, $xml_trans, 'po-number', (int)$cart->id);
		$this->appendXmlNode($xml_request, $xml_trans, 'tax-amount', number_format((float)$cart_summary['total_tax'], 2, '.', ''));
		$this->appendXmlNode($xml_request, $xml_trans, 'shipping-amount', number_format((float)$cart->getOrderShippingCost(), 2, '.', ''));
		$xml_billing_address = $xml_request->createElement('billing');
		$this->appendXmlNode($xml_request, $xml_billing_address, 'first-name', Tools::safeOutput($customer->firstname));
		$this->appendXmlNode($xml_request, $xml_billing_address, 'last-name', Tools::safeOutput($customer->lastname));
		$this->appendXmlNode($xml_request, $xml_billing_address, 'address1', Tools::safeOutput($billing_address->address1));
		$this->appendXmlNode($xml_request, $xml_billing_address, 'postal', Tools::safeOutput($billing_address->postcode));
		$xml_trans->appendChild($xml_billing_address);
		$xml_request->appendChild($xml_trans);
		$response = $this->doPost($xml_request);

		if ((string)$response->result != 1)
			$this->context->smarty->assign('cardpay_error', $response->{'result-text'});

		$this->context->smarty->assign(array(
			'form_url' => $response->{'form-url'},
			'current_year' => date('y'),
			'cardpay_ps_version' => _PS_VERSION_,
			'cardpay_live_mode' => Configuration::get('CARDPAYSOLUTIONS_LIVE_MODE'),
			'cardpay_vi_enabled' => Configuration::get('CARDPAYSOLUTIONS_VI_ENABLED'),
			'cardpay_mc_enabled' => Configuration::get('CARDPAYSOLUTIONS_MC_ENABLED'),
			'cardpay_ds_enabled' => Configuration::get('CARDPAYSOLUTIONS_DS_ENABLED'),
			'cardpay_ax_enabled' => Configuration::get('CARDPAYSOLUTIONS_AX_ENABLED'),
			'cardpay_jc_enabled' => Configuration::get('CARDPAYSOLUTIONS_JC_ENABLED'),
			'cardpay_dn_enabled' => Configuration::get('CARDPAYSOLUTIONS_DN_ENABLED')
		));
		return $this->display(__FILE__, (_PS_VERSION_ > '1.5.9.9' ? 'views/templates/hook/1.6/':'views/templates/hook/1.5/').'payment.tpl');
	}

	public function validation()
	{
		$cart = $this->context->cart;

		if (Validate::isLoadedObject($cart) && $cart->id == Tools::getValue('cart') && !Order::getOrderByCartId((int)Tools::getValue('cart')))
		{
			$customer = new Customer((int)$cart->id_customer);
			$mode = Configuration::get('CARDPAYSOLUTIONS_LIVE_MODE');
			$api_key = $mode ? Configuration::get('CARDPAYSOLUTIONS_API_KEY') : '2F822Rw39fx762MaV7Yy86jXGTC7sCDy';
			$token_id = Tools::getValue('token-id');
			$xml_request = new DOMDocument('1.0', 'UTF-8');
			$xml_request->formatOutput = true;
			$xml_complete_transaction = $xml_request->createElement('complete-action');
			$this->appendXmlNode($xml_request, $xml_complete_transaction, 'api-key', $api_key);
			$this->appendXmlNode($xml_request, $xml_complete_transaction, 'token-id', $token_id);
			$xml_request->appendChild($xml_complete_transaction);
			$response = $this->doPost($xml_request);

			if ((string)$response->result == 1)
			{
				$this->insertTransaction(array(
					'id_cart' => (int)$cart->id,
					'trans_type' => pSQL(Configuration::get('CARDPAYSOLUTIONS_DEFAULT_TYPE')),
					'responsetext' => pSQL((string)$response->{'result-text'}),
					'cc_last_four' => pSQL(Tools::substr($response->billing->{'cc-number'}, -4)),
					'card_type' => pSQL($this->getCardType((string)$response->billing->{'cc-number'})),
					'amount' => pSQL(number_format((float)$cart->getOrderTotal(true, 3), 2, '.', '')),
					'cardholder_name' => pSQL($customer->firstname.' '.$customer->lastname),
					'ccexp' => pSQL($response->billing->{'cc-exp'}),
					'authcode' => pSQL((string)$response->{'authorization-code'}),
					'transactionid' => pSQL((string)$response->{'transaction-id'}),
					'avsresponse' => pSQL((string)$response->{'avs-result'}),
					'cvvresponse' => pSQL((string)$response->{'cvv-result'}),
					'date_add' => date('Y-m-d H:i:s')
				));
				$this->validateOrder((int)$cart->id, (int)Configuration::get('PS_OS_PAYMENT'), (float)$cart->getOrderTotal(),
					$this->displayName, null, array(), null, false, $cart->secure_key);
				Configuration::updateValue('CARDPAYSOLUTIONS_CONF_OK', true);

				/** @since 1.5.0 Attach the Transaction ID to this Order */
				if (_PS_VERSION_ >= '1.5')
				{
					$new_order = new Order((int)$this->currentOrder);
					if (Validate::isLoadedObject($new_order))
					{
						$payment                     = $new_order->getOrderPaymentCollection();
						$payment[0]->transaction_id  = (string)$response->{'transaction-id'};
						$payment[0]->card_number     = Tools::substr($response->billing->{'cc-number'}, -4);
						$payment[0]->card_brand      = $this->getCardType((string)$response->billing->{'cc-number'});
						$payment[0]->card_expiration = (string)$response->billing->{'cc-exp'};
						$payment[0]->card_holder     = $customer->firstname.' '.$customer->lastname;
						$payment[0]->save();
					}
				}

				$link_params = array(
					'key' => $this->context->customer->secure_key,
					'id_cart' => (int)$cart->id,
					'id_module' => (int)$this->id,
					'id_order' => (int)$this->currentOrder
				);
				if (_PS_VERSION_ >= 1.5)
					Tools::redirect($this->context->link->getPageLink('order-confirmation', null, null, $link_params));
				else
				{
					$redirect = __PS_BASE_URI__.'order-confirmation.php?id_cart='.(int)$this->context->cart->id.'&id_module='.(int)$this->id.'&id_order='
						.(int)$this->currentOrder.'&key='.$this->context->customer->secure_key;
					Tools::redirect($redirect);
					exit;
				}
			}
			else
			{
				$error_msg = Tools::safeOutput($response->{'result-text'});

				Logger::AddLog('[Cardpaysolutions] '.Tools::safeOutput($error_msg), 2);
				$checkout_type = Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order';
				$url = (_PS_VERSION_ >= '1.5' ? 'index.php?controller='.$checkout_type.'&' : $checkout_type.'.php?').'step=3&cgv=1&cardpayError='.$error_msg;

				if (!isset($_SERVER['HTTP_REFERER']) || strstr($_SERVER['HTTP_REFERER'], 'order'))
					Tools::redirect($url);
				elseif (strstr($_SERVER['HTTP_REFERER'], '?'))
					Tools::redirect(Tools::safeOutput($_SERVER['HTTP_REFERER']).'&cardpayError='.$error_msg, '');
				else
					Tools::redirect(Tools::safeOutput($_SERVER['HTTP_REFERER']).'?cardpayError='.$error_msg, '');
			}
		}
		else
			die('Unfortunately your order could not be validated. Error: "Invalid Cart ID", please contact us.');
	}

	private function insertTransaction($params)
	{
		if (_PS_VERSION_ < '1.5.0.5')
			return Db::getInstance()->autoExecute(_DB_PREFIX_.'cardpaysolutions', $params, 'INSERT');
		else
			return Db::getInstance()->insert('cardpaysolutions', $params);
	}

	private function getTransaction($id_cart)
	{
		return Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'cardpaysolutions` WHERE `id_cart` = '.(int)$id_cart);
	}

	private function getCardType($number)
	{
		if (preg_match('/^4/', $number))
			return 'Visa';
		elseif (preg_match('/^(34|37)/', $number))
			return 'American Express';
		elseif (preg_match('/^5[1-5]/', $number))
			return 'MasterCard';
		elseif (preg_match('/^60/', $number))
			return 'Discover';
		elseif (preg_match('/^21|18|35/', $number))
			return 'JCB';
		elseif (preg_match('/^30[0-5]|36|38/', $number))
			return 'Diners Club';
	}

	private function avsResponses()
	{
		return array(
			'X' => 'Exact match, 9-character numeric ZIP',
			'Y' => 'Exact match, 5-character numeric ZIP',
			'D' => 'Exact match, 5-character numeric ZIP',
			'M' => 'Exact match, 5-character numeric ZIP',
			'A' => 'Address match only',
			'B' => 'Address match only',
			'W' => '9-character numeric ZIP match only',
			'Z' => '5-character ZIP match only',
			'P' => '5-character ZIP match only',
			'L' => '5-character ZIP match only',
			'N' => 'No address or ZIP match only',
			'C' => 'No address or ZIP match only',
			'U' => 'Address unavailable',
			'G' => 'Non-U.S. issuer does not participate',
			'I' => 'Non-U.S. issuer does not participate',
			'R' => 'Issuer system unavailable',
			'E' => 'Not a mail/phone order',
			'S' => 'Service not supported',
			'O' => 'AVS not available',
			'B' => 'AVS not available'
		);
	}

	private function cvvResponses()
	{
		return array(
			'M' => 'CVV2/CVC2 match',
			'N' => 'CVV2/CVC2 no match',
			'P' => 'Not processed',
			'S' => 'Merchant has indicated that CVV2/CVC2 is not present on card',
			'U' => 'Issuer is not certified and/or has not provided Visa encryption keys'
		);
	}

	private function appendXmlNode($dom_document, $parent_node, $name, $value)
	{
		$child_node = $dom_document->createElement($name);
		$child_node_value = $dom_document->createTextNode($value);
		$child_node->appendChild($child_node_value);
		$parent_node->appendChild($child_node);
	}

	private function doPost($xml_request)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://cardpaysolutions.transactiongateway.com/api/v2/three-step');

		$headers = array();
		$headers[] = 'Content-type: text/xml';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$xml_string = $xml_request->saveXML();
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PORT, 443);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_string);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		if (!($data = curl_exec($ch)))
			return ERROR;
		curl_close($ch);
		unset($ch);
		$response = @new SimpleXMLElement((string)$data);
		return $response;
	}
}