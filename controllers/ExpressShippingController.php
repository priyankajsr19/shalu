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
 *  @version  Release: $Revision: 6594 $
 *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class ExpressShippingControllerCore extends FrontController {

    protected $pageProducts;

    public function __construct() {
        $this->php_self = 'express-shipping.php';

        parent::__construct();
    }

    public function setMedia() {
        parent::setMedia();
        //Tools::addCSS(_THEME_CSS_DIR_.'product_list.css');
    }

    public function preProcess() {
        $this->productSort();
        $nbProducts = 0;
        $this->n = (int) (Configuration::get('PS_PRODUCTS_PER_PAGE'));
        $this->p = abs((int) (Tools::getValue('p', 1)));

        try {
            $products = SolrSearch::getExpressShippingProducts($nbProducts, $this->p, $this->n);
            $this->pagination($nbProducts);
            self::$smarty->assign('nbProducts', (int) $nbProducts);
        } catch (Exception $e) {
            self::$smarty->assign('fetch_error', 1);
        }

        $this->pageProducts = $products;
    }

    public function process() {
        parent::process();

        self::$smarty->assign(array(
            'products' => $this->pageProducts,
            'add_prod_display' => Configuration::get('PS_ATTRIBUTE_CATEGORY_DISPLAY'),
            'homeSize' => Image::getSize('home')
        ));
    }

    public function displayContent() {
        parent::displayContent();
        self::$smarty->display(_PS_THEME_DIR_ . 'new-products.tpl');
    }

}

