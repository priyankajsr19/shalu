<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6713 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class OrderPaymentHistoryCore extends ObjectModel
{
	/** @var integer Order id */
	public 		$id_order;
	
	/** @var integer Order state id */
	public 		$id_payment_state;
	
	/** @var integer Employee id for this history entry */
	public 		$id_employee;
	
	/** @var string Object creation date */
	public 		$date_add;

	/** @var string Object last modification date */
	public 		$date_upd;

	protected $tables = array ('order_payment_history');
	
	protected	$fieldsRequired = array('id_order', 'id_payment_state');
	protected	$fieldsValidate = array('id_order' => 'isUnsignedId', 'id_payment_state' => 'isUnsignedId', 'id_employee' => 'isUnsignedId');

	protected 	$table = 'order_payment_history';
	protected 	$identifier = 'id_order_payment_history';
	
	protected	$webserviceParameters = array(
		'objectsNodeName' => 'order_payment_histories',
		'fields' => array(
			'id_payment_state' => array('required' => true, 'xlink_resource'=> 'order_payment_states'),
			'id_order' => array('xlink_resource' => 'orders'),
		),
	);

	public function getFields()
	{
		parent::validateFields();
		
		$fields['id_order'] = (int)($this->id_order);
		$fields['id_payment_state'] = (int)($this->id_payment_state);
		$fields['id_employee'] = (int)($this->id_employee);
		$fields['date_add'] = pSQL($this->date_add);
				
		return $fields;
	}

	public function changeIdOrderPaymentState($new_payment_state = NULL, $id_order)
	{
		if ($new_payment_state != NULL)
		{
			$order = new Order((int)($id_order));
			
			$this->id_payment_state = (int)($new_payment_state);
			
			if (!Validate::isLoadedObject($order))
				die(Tools::displayError('Invalid new order state'));
		}
	}

	static public function getLastOrderState($id_order)
	{
		$id_payment_state = Db::getInstance()->getValue('
		SELECT `id_payment_state`
		FROM `'._DB_PREFIX_.'order_payment_history`
		WHERE `id_order` = '.(int)($id_order).'
		ORDER BY `date_add` DESC, `id_order_history` DESC');
		if (!$id_payment_state)
			return false;
		return $id_payment_state;
	}

	public function addState($autodate = true)
	{
		if (!parent::add($autodate))
			return false;

		return true;
	}
	
	public function isValidated()
	{
		return Db::getInstance()->getValue('
		SELECT COUNT(oph.`id_order_payment_history`) AS nb
		FROM  `'._DB_PREFIX_.'order_payment_history` oph 
		WHERE oph.`id_order` = '.(int)$this->id_order);
	}

}
