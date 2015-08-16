<?php

if (!defined('_CAN_LOAD_FILES_'))
    exit;

class BlockLayered extends Module {

    private $products;
    private $nbr_products;
    private $search_query;
    private $search_resultIds;
    private $resultSet;

    public function __construct() {
        global $cookie;
        $this->name = 'blocklayered';
        $this->tab = 'front_office_features';
        $this->version = 1.3;
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->resultSet = null;

        parent::__construct();

        $this->displayName = $this->l('Layered navigation block');
        $this->description = $this->l('Displays a block with layered navigation filters.');
        $this->search_query = Search::sanitize(Tools::getValue('search_query'), (int) $cookie->id_lang);
    }

    public function install() {
        if ($result = parent::install() AND $this->registerHook('leftColumn') AND $this->registerHook('header') AND $this->registerHook('categoryAddition') AND $this->registerHook('categoryUpdate') AND $this->registerHook('categoryDeletion')) {
            Configuration::updateValue('PS_LAYERED_NAVIGATION_CHECKBOXES', 1);
            $this->rebuildLayeredStructure();
        }

        return $result;
    }

    public function uninstall() {
        /* Delete all configurations */
        Configuration::deleteByName('PS_LAYERED_NAVIGATION_CHECKBOXES');
        return parent::uninstall();
    }

    public function hookLeftColumn($params) {
        return $this->generateFiltersBlock($this->getSelectedFilters());
    }

    public function hookRightColumn($params) {
        return $this->hookLeftColumn($params);
    }

    public function hookHeader($params) {
        $id_parent = (int) Tools::getValue('id_category', Tools::getValue('id_category_layered', 1));
        if ($id_parent == 1 && !$this->search_query && !Tools::getValue('id_manufacturer', false))
            return;
    }

    public function hookCategoryAddition($params) {

    }

    public function hookCategoryUpdate($params) {

    }

    public function hookCategoryDeletion($params) {
        Db::getInstance()->Execute('DELETE FROM ' . _DB_PREFIX_ . 'layered_category WHERE id_category = ' . (int) $params['category']->id);
    }

    public function getContent() {
        $errors = array();
        $html = '';

        if (Tools::isSubmit('submitLayeredCache')) {
            $this->rebuildLayeredStructure();
            $this->rebuildLayeredCache();

            $html .= '
			<div class="conf confirm">
				<img src="../img/admin/ok.gif" alt="" title="" />
				' . $this->l('Layered navigation database was initialized successfully') . '
			</div>';
        } elseif (Tools::isSubmit('submitLayeredSettings')) {
            if (Tools::getValue('share_url')) {
                if (Tools::getValue('bitly_username') == '')
                    $errors[] = $this->l('Bit.ly username is empty');
                if (Tools::getValue('bitly_api_key') == '')
                    $errors[] = $this->l('Bit.ly api_key is empty');
            }

            if (!sizeof($errors)) {
                Configuration::updateValue('PS_LAYERED_BITLY_USERNAME', Tools::getValue('bitly_username'));
                Configuration::updateValue('PS_LAYERED_BITLY_API_KEY', Tools::getValue('bitly_api_key'));
                Configuration::updateValue('PS_LAYERED_SHARE', Tools::getValue('share_url'));
                $html .= '
					<div class="conf confirm">
						<img src="../img/admin/ok.gif" alt="" title="" />
						' . $this->l('Settings saved successfully') . '
					</div>';
            } else {
                $html .= '
				<div class="error">
					<img src="../img/admin/error.png" alt="" title="" />' . $this->l('Settings not saved :') . '<ul>';
                foreach ($errors as $error)
                    $html .= '<li>' . $error . '</li>';
                $html .= '</ul></div>';
            }
        }

        $html .= '<script>
					$(document).ready(function()
					{
						$(\'.share_url\').change(function(){
							toggleBitly();
						});
						toggleBitly();

						function toggleBitly(){
							if ($(\'#share_url_on\').attr(\'checked\'))
								$(\'#bitly\').slideDown();
							else
								$(\'#bitly\').slideUp();
						}
					});
				</script>
		<h2>' . $this->l('Layered navigation') . '</h2>
		<p class="warning" style="font-weight: bold;"><img src="../img/admin/information.png" alt="" /> ' . $this->l('This module is in beta version and will be improved') . '</p><br />
		<fieldset class="width2">
			<legend><img src="../img/admin/asterisk.gif" alt="" />' . $this->l('10 upcoming improvements') . '</legend>
			<ol>
				<li>' . $this->l('Real-time refresh of the cache table') . ' <img src="../img/admin/enabled.gif" alt="" /></li>
				<li>' . $this->l('Additional filters (prices, weight)') . '</li>
				<li>' . $this->l('Ability to manage filters by category in the module configuration') . '</li>
				<li>' . $this->l('Ability to hide filter groups with no values and filter values with 0 products') . '</li>
				<li>' . $this->l('Statistics and analysis') . '</li>
				<li>' . $this->l('Manage products sort & pagination') . ' <img src="../img/admin/enabled.gif" alt="" /></li>
				<li>' . $this->l('Add a check on the category_group table') . '</li>
				<li>' . $this->l('SEO links & real time URL building (ability to give the URL to someone)') . ' <img src="../img/admin/enabled.gif" alt="" /> </li>
				<li>' . $this->l('Add more options in the module configuration') . '</li>
				<li>' . $this->l('Performances improvements') . '</li>
			</ol>
		</fieldset><br />

		<fieldset class="width2">
			<legend><img src="../img/admin/database_gear.gif" alt="" />' . $this->l('Cache initialization') . '</legend>
			<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
				<div class="warning">
						<p style="color: red; font-weight: bold;">' . $this->l('Before using this module for the first time you have to initialize the cache') . '</p>
					<p><b>' . $this->l('Warning: This could take several minutes.') . '</b><br /><br />
					' . $this->l('If you do not, this cache table might become larger and larger (less efficient), and all the new choices (attributes, features) will not be offered to your visitors.') . '</p>
				</div>
				<p style="text-align: center;"><input type="submit" class="button" name="submitLayeredCache" value="' . $this->l('Initialize the layered navigation database') . '" /></p>
			</form>
		</fieldset><br />
		<fieldset class="width2">
			<legend><img src="../img/admin/cog.gif" alt="" />' . $this->l('Configuration') . '</legend>
			<form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
				<label>' . $this->l('Enable share URL') . ' : </label>
						<div class="margin-form">
							<label class="t" for="share_url_on"><img src="../img/admin/enabled.gif" alt="Yes" title="Yes"></label>
							<input type="radio" id="share_url_on" name="share_url" class="share_url" value="1" ' . (Configuration::get('PS_LAYERED_SHARE') ? 'checked="checked"' : '') . '>
							<label class="t" for="share_url_off"><img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;"></label>
							<input type="radio" id="share_url_off" name="share_url" class="share_url" value="0" ' . (!Configuration::get('PS_LAYERED_SHARE') ? 'checked="checked"' : '') . '>
							<p>' . $this->l('By enabling this option, your visitors can share the URL of their research') . '</p>
						</div>
						<div class="clear"></div>
						<div id="bitly">
							<p>' . $this->l('To offer your customers short links, create an account on bit.ly, then copy and paste login and API key.') . '
							<a style="text-decoration:underline" href="http://bit.ly/a/sign_up">' . $this->l('Sign Up') . '</a></p>
							<label>' . $this->l('Login bit.ly') . '</label>
							<div class="margin-form">
									<input type="text" name="bitly_username" value="' . Tools::getValue('bitly_username', Configuration::get('PS_LAYERED_BITLY_USERNAME')) . '">
							</div>
							<label>' . $this->l('API Key bit.ly') . '</label>
							<div class="margin-form">
								<input type="text" name="bitly_api_key" value="' . Tools::getValue('bitly_api_key', Configuration::get('PS_LAYERED_BITLY_API_KEY')) . '">
							</div>
						</div>
				<p style="text-align: center;"><input type="submit" class="button" name="submitLayeredSettings" value="' . $this->l('Save configuration') . '" /></p>
			</form>
		</fieldset>';
        return $html;
    }

    private function getSelectedFilters() {
        global $cookie;
        $id_parent = (int) Tools::getValue('id_category', Tools::getValue('id_category_layered', 1));
        $id_manufacturer = Tools::getValue('id_manufacturer', false);
        $new_products = Tools::getValue('latest', false);
        $sale_products = Tools::getValue('sale', false);
        $express_shipping = Tools::getValue('express_shipping', false);
        $cat_id = Tools::getValue('cat_id', false);
        if ($id_parent == 1 && !$this->search_query && !$id_manufacturer && !$new_products && !$sale_products && !$express_shipping && !$cat_id)
            return;

        /* Analyze all the filters selected by the user and store them into a tab */
        $selectedFilters = array('category' => array(),
            'manufacturer' => array(),
            'pr' => array(),
            'color' => array(),
            'fabric' => array(),
            'customization' => array(),
            'size' => array(),
            'stone' => array(),
            'plating' => array(),
            'material' => array(),
            'look' => array(),
            'handbag_occasion' => array(),
            'handbag_style' => array(),
            'handbag_material' => array(),
            'sla' => array(),
        );
        foreach ($_GET AS $key => $value) {
            if (substr($key, 0, 8) == 'layered_') {
                preg_match('/^(.*)_[\-0-9a-zA-Z]+$/', substr($key, 8, strlen($key) - 8), $res);
                if (isset($res[1])) {
                    $tmpTab = explode('_', $value);
                    $value = $tmpTab[0];
                    $id_key = false;
                    if (isset($tmpTab[1]))
                        $id_key = $tmpTab[1];
                    if (in_array($res[1], array('category', 'manufacturer', 'pr', 'color', 'fabric', 'customization', 'size', 'stone', 'plating', 'material', 'look','handbag_occasion','handbag_style','handbag_material','sla'))) {
                        if (!isset($selectedFilters[$res[1] . ($id_key ? '_' . $id_key : '')]))
                            $selectedFilters[$res[1] . ($id_key ? '_' . $id_key : '')] = array();
                        $filterValue = array();
                        $filterValue['id'] = $value;
                        if ($res[1] == 'category') {
                            $cat = new Category((int) $value);
                            $filterValue['name'] = 'Category: ' . $cat->getName(1);
                        } elseif ($res[1] == 'manufacturer')
                            $filterValue['name'] = 'Brand: ' . Manufacturer::getNameById((int) $value);
                        elseif ($res[1] == 'pr') {
                            if ($cookie->id_currency == 4)
                                switch ((int) $value) {
                                    case 1: $filterValue['name'] = 'Price: 0 - 1000';
                                        break;
                                    case 2: $filterValue['name'] = 'Price: 1000 - 2500';
                                        break;
                                    case 3: $filterValue['name'] = 'Price: 2500 - 5000';
                                        break;
                                    case 4: $filterValue['name'] = 'Price: 5000 - 10000';
                                        break;
                                    case 5: $filterValue['name'] = 'Price: > 10000';
                                        break;
                                }
                            else {
                                $curr_currency = CurrencyCore::getCurrency($cookie->id_currency); 
                                $conversion_rate = $curr_currency['conversion_rate'];
                                switch ((int) $value) {
                                    case 1: $filterValue['name'] = 'Price: 0 - '. Tools::ps_round(50/$conversion_rate);
                                        break;
                                    case 2: $filterValue['name'] = 'Price: '. Tools::ps_round(50/$conversion_rate) .' - '. Tools::ps_round(100/$conversion_rate);
                                        break;
                                    case 3: $filterValue['name'] = 'Price: '. Tools::ps_round(100/$conversion_rate) .' - '. Tools::ps_round(150/$conversion_rate);
                                        break;
                                    case 4: $filterValue['name'] = 'Price: '.Tools::ps_round(150/$conversion_rate).' - '. Tools::ps_round(200/$conversion_rate);
                                        break;
                                    case 5: $filterValue['name'] = 'Price: > '. Tools::ps_round(200/$conversion_rate);
                                        break;
                                }
                            }
                        } elseif ($res[1] == 'color') {
                            $filterValue['name'] = 'Color: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'fabric') {
                            $filterValue['name'] = 'Fabric: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'customization') {
                            $filterValue['name'] = 'Customization: ' . ($filterValue['id'] == 0 ? 'Ready To wear' : 'Customizable');
                        } elseif ($res[1] == 'size') {
                            $filterValue['name'] = 'Size: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'stone') {
                            $filterValue['name'] = 'Stone: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'plating') {
                            $filterValue['name'] = 'Plating: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'material') {
                            $filterValue['name'] = 'Material: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'look') {
                            $filterValue['name'] = 'Look: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'handbag_occasion') {
                            $filterValue['name'] = 'Occasion: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'handbag_style') {
                            $filterValue['name'] = 'Style: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif ($res[1] == 'handbag_material') {
                            $filterValue['name'] = 'Material: ' . ucwords(str_replace("-", " ", $filterValue['id']));
                        } elseif( $res[1] == 'sla') {
                            switch ((int) $value) {
                                case 1: $filterValue['name'] = 'Shipping SLA: 0 - 5';
                                    break;
                                case 2: $filterValue['name'] = 'Shipping SLA: 5 - 10';
                                    break;
                                case 3: $filterValue['name'] = 'Shipping SLA: 10 - 15';
                                    break;
                                case 4: $filterValue['name'] = 'Shipping SLA: 15 - 20';
                                    break;
                                case 5: $filterValue['name'] = 'Shipping SLA: > 20';
                                    break;
                            }
                        }
                        $selectedFilters[$res[1] . ($id_key ? '_' . $id_key : '')][] = $filterValue;
                    }
                }
            }
        }
        //echo var_dump($selectedFilters);
        return $selectedFilters;
    }

    /**
     * @param unknown_type $id_category
     * @param unknown_type $search_query
     * @param unknown_type $id_manufacturer
     * @param unknown_type $selectedFilters
     * @return Solarium_Result_Select
     */
    public function getResults($id_category, $search_query, $id_manufacturer, $selectedFilters = array(), $andquery = TRUE) {
        global $cookie, $cart, $smarty;

        //set the price field fro country
        $price_field = 'offer_price';
        $sla_field = 'shipping_sla';

        //get the right address for this cart
        $id_country = (int) Country::getDefaultCountryId();
        if ($cart->id_address_delivery) {
            $address = new Address($cart->id_address_delivery);
            if ($address->id_country) {
                $id_country = $address->id_country;
            } elseif (isset($cookie->id_country)) {
                $id_country = (int) $cookie->id_country;
            }
        }
        $curr_currency = CurrencyCore::getCurrency($cookie->id_currency); 
        $conversion_rate = $curr_currency['conversion_rate'];

        $smarty->assign('price_tax_country', $id_country);

        if ($id_country == 110)
            $price_field = 'offer_price_in';
        if ($cookie->id_currency == 4)
            $price_field = $price_field . "_rs";

        $new_products = Tools::getValue('latest', false);
        $sale_products = Tools::getValue('sale', false);
        $express_shipping = Tools::getValue('express_shipping', false);
        $cat_id = Tools::getValue('cat_id', false);
        if ($this->resultSet)
            return $this->resultSet;

        $n = (int) Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'));
        $start = ((int) (Tools::getValue('p', 1)) - 1) * $n;
        $rows = $n;

        $orderby = Tools::getValue('orderby');
        $orderway = Tools::getValue('orderway');

        //get the facet info
        // create a client instance
        $client = SolrSearch::getClient();

        // get a select query instance
        $query = $client->createSelect();

        if ($new_products) {
            $query->setQuery('date_add:[NOW/DAY-1MONTH/DAY TO *]');
        } else if ($sale_products) {
            $query->setQuery('discount:[1 TO *]');
        } else if ($express_shipping) {
            $query->setQuery('shipping_sla:[1 TO 2]');
        }

        if ($search_query) {
            $dismax = $query->getDisMax();
            $dismax->setQueryFields('name^10 text^1.2 tags^3 reference^10 style_tips^15');
            $query->setQuery($search_query);
        }

        // add filter queries
        if ($id_category)
            $catFilter = $query->createFilterQuery('cat')->setQuery('+cat_id:' . $id_category);

        if ($id_manufacturer) {
            $manFilter = $query->createFilterQuery('man')->setQuery('+brand_id:' . $id_manufacturer);
            $id_categories = Tools::getValue('cat_id');
            if( !empty($id_categories) ) {
                $id_categories = explode("-",$id_categories);
                if( is_array($id_categories) ) {
                    $id_categories = implode(" OR ",$id_categories);
                    $query->createFilterQuery("des_cat")->setQuery("cat_id: ($id_categories)");
                }
            }
        }

        if (isset($selectedFilters['pr']) && count($selectedFilters['pr']) > 0) {
            $filterquery = '+' . $price_field . ':(';
            $pricefilter = $query->createFilterQuery('maxprice');
            $pricefilter->addTag($price_field);
            $selectedPrices = array();

            foreach ($selectedFilters['pr'] as $range) {
                if ($cookie->id_currency == 4)
                    switch ($range['id']) {
                        case 1:
                            $selectedPrices[] = '[1 TO 1000]';
                            break;
                        case 2:
                            $selectedPrices[] = '[1001 TO 2500]';
                            break;
                        case 3:
                            $selectedPrices[] = '[2501 TO 5000]';
                            break;
                        case 4:
                            $selectedPrices[] = '[5001 TO 10000]';
                            break;
                        case 5:
                            $selectedPrices[] = '[10001 TO *]';
                            break;
                    }
                else {
                       
                    switch ($range['id']) {
                        case 1:
                            $selectedPrices[] = '['.Tools::ps_round(1/$conversion_rate).' TO '.Tools::ps_round(50/$conversion_rate).']';
                            break;
                        case 2:
                            $selectedPrices[] = '['.Tools::ps_round(51/$conversion_rate).' TO '.Tools::ps_round(100/$conversion_rate).']';
                            break;
                        case 3:
                            $selectedPrices[] = '['.Tools::ps_round(101/$conversion_rate).' TO '.Tools::ps_round(150/$conversion_rate).']';
                            break;
                        case 4:
                            $selectedPrices[] = '['.Tools::ps_round(151/$conversion_rate).' TO '.Tools::ps_round(200/$conversion_rate).']';
                            break;
                        case 5:
                            $selectedPrices[] = '['.Tools::ps_round(201/$conversion_rate).' TO *]';
                            break;
                    }
                }
            }

            $filterquery .= implode(" OR ", $selectedPrices);
            $pricefilter->setQuery($filterquery . ")");
        }

        if (isset($selectedFilters['manufacturer']) && count($selectedFilters['manufacturer']) > 0) {
            $brandfilter = $query->createFilterQuery('brand');
            $brandfilter->addTag('brands');

            $brandQuery = '+brand_id:(';
            $brandsSelected = array();

            foreach ($selectedFilters['manufacturer'] as $brand)
                $brandsSelected[] = $brand['id'];
            $brandQuery .= implode(" OR ", $brandsSelected);

            $brandfilter->setQuery($brandQuery . ")");
        }

        if (isset($selectedFilters['fabric']) && count($selectedFilters['fabric']) > 0) {
            $fabricfilter = $query->createFilterQuery('fabric');
            $fabricfilter->addTag('fabrics');

            $fabricQuery = '+fabric:(';
            $fabricsSelected = array();

            foreach ($selectedFilters['fabric'] as $fabric)
                $fabricsSelected[] = $fabric['id'];
            $fabricQuery .= implode(" OR ", $fabricsSelected);

            $fabricfilter->setQuery($fabricQuery . ")");
        }

        if (isset($selectedFilters['stone']) && count($selectedFilters['stone']) > 0) {
            $stonefilter = $query->createFilterQuery('stone');
            $stonefilter->addTag('stones');

            $stoneQuery = '+stone:(';
            $stonesSelected = array();

            foreach ($selectedFilters['stone'] as $stone)
                $stonesSelected[] = $stone['id'];
            $stoneQuery .= implode(" OR ", $stonesSelected);

            $stonefilter->setQuery($stoneQuery . ")");
        }

        if (isset($selectedFilters['plating']) && count($selectedFilters['plating']) > 0) {
            $platingfilter = $query->createFilterQuery('plating');
            $platingfilter->addTag('platings');

            $platingQuery = '+plating:(';
            $platingsSelected = array();

            foreach ($selectedFilters['plating'] as $plating)
                $platingsSelected[] = $plating['id'];
            $platingQuery .= implode(" OR ", $platingsSelected);

            $platingfilter->setQuery($platingQuery . ")");
        }

        if (isset($selectedFilters['material']) && count($selectedFilters['material']) > 0) {
            $materialfilter = $query->createFilterQuery('material');
            $materialfilter->addTag('materials');

            $materialQuery = '+material:(';
            $materialsSelected = array();

            foreach ($selectedFilters['material'] as $material)
                $materialsSelected[] = $material['id'];
            $materialQuery .= implode(" OR ", $materialsSelected);

            $materialfilter->setQuery($materialQuery . ")");
        }

        if (isset($selectedFilters['look']) && count($selectedFilters['look']) > 0) {
            $lookfilter = $query->createFilterQuery('look');
            $lookfilter->addTag('looks');

            $lookQuery = '+look:(';
            $looksSelected = array();

            foreach ($selectedFilters['look'] as $look)
                $looksSelected[] = $look['id'];
            $lookQuery .= implode(" OR ", $looksSelected);

            $lookfilter->setQuery($lookQuery . ")");
        }

        if (isset($selectedFilters['size']) && count($selectedFilters['size']) > 0) {
            $sizefilter = $query->createFilterQuery('size');
            $sizefilter->addTag('sizes');

            $sizeQuery = '+size:(';
            $sizesSelected = array();

            foreach ($selectedFilters['size'] as $size)
                $sizesSelected[] = $size['id'];
            $sizeQuery .= implode(" OR ", $sizesSelected);

            $sizefilter->setQuery($sizeQuery . ")");
        }

        if (isset($selectedFilters['customization']) && count($selectedFilters['customization']) > 0) {
            $custfilter = $query->createFilterQuery('cust');
            $custfilter->addTag('customizations');

            $custQuery = '+is_customizable:(';
            $custsSelected = array();

            foreach ($selectedFilters['customization'] as $cust)
                $custsSelected[] = $cust['id'];
            $custQuery .= implode(" OR ", $custsSelected);

            $custfilter->setQuery($custQuery . ")");
        }

        if (isset($selectedFilters['color']) && count($selectedFilters['color']) > 0) {
            $colorfilter = $query->createFilterQuery('color');
            $colorfilter->addTag('colors');

            $colorQuery = '+color:(';
            $colorsSelected = array();

            foreach ($selectedFilters['color'] as $color)
                $colorsSelected[] = $color['id'];
            $colorQuery .= implode(" OR ", $colorsSelected);

            $colorfilter->setQuery($colorQuery . ")");
        }
        
        if (isset($selectedFilters['handbag_occasion']) && count($selectedFilters['handbag_occasion']) > 0) {
            $handbag_occasionfilter = $query->createFilterQuery('handbag_occasion');
            $handbag_occasionfilter->addTag('handbag_occasions');

            $handbag_occasionQuery = '+handbag_occasion:(';
            $handbag_occasionsSelected = array();

            foreach ($selectedFilters['handbag_occasion'] as $handbag_occasion)
                $handbag_occasionsSelected[] = $handbag_occasion['id'];
            $handbag_occasionQuery .= implode(" OR ", $handbag_occasionsSelected);

            $handbag_occasionfilter->setQuery($handbag_occasionQuery . ")");
        }

        if (isset($selectedFilters['handbag_style']) && count($selectedFilters['handbag_style']) > 0) {
            $handbag_stylefilter = $query->createFilterQuery('handbag_style');
            $handbag_stylefilter->addTag('handbag_styles');

            $handbag_styleQuery = '+handbag_style:(';
            $handbag_stylesSelected = array();

            foreach ($selectedFilters['handbag_style'] as $handbag_style)
                $handbag_stylesSelected[] = $handbag_style['id'];
            $handbag_styleQuery .= implode(" OR ", $handbag_stylesSelected);

            $handbag_stylefilter->setQuery($handbag_styleQuery . ")");
        }
        if (isset($selectedFilters['handbag_material']) && count($selectedFilters['handbag_material']) > 0) {
            $handbag_materialfilter = $query->createFilterQuery('handbag_material');
            $handbag_materialfilter->addTag('handbag_materials');

            $handbag_materialQuery = '+handbag_material:(';
            $handbag_materialsSelected = array();

            foreach ($selectedFilters['handbag_material'] as $handbag_material)
                $handbag_materialsSelected[] = $handbag_material['id'];
            $handbag_materialQuery .= implode(" OR ", $handbag_materialsSelected);

            $handbag_materialfilter->setQuery($handbag_materialQuery . ")");
        }

        if (isset($selectedFilters['sla']) && count($selectedFilters['sla']) > 0) {
            $filterquery = '+' . $sla_field . ':(';
            $slafilter = $query->createFilterQuery('shipping_sla');
            $slafilter->addTag($sla_field);
            $selectedSlas = array();

            foreach ($selectedFilters['sla'] as $range) {
                    switch ($range['id']) {
                        case 1:
                            $selectedSlas[] = '[1 TO 5]';
                            break;
                        case 2:
                            $selectedSlas[] = '[6 TO 10]';
                            break;
                        case 3:
                            $selectedSlas[] = '[11 TO 15]';
                            break;
                        case 4:
                            $selectedSlas[] = '[16 TO 20]';
                            break;
                        case 5:
                            $selectedSlas[] = '[21 TO *]';
                            break;
                    }
            }

            $filterquery .= implode(" OR ", $selectedSlas);
            $slafilter->setQuery($filterquery . ")");
        }


        $facetSet = $query->getFacetSet();
        $facetSet->setMinCount(1);

        $facetSet->createFacetField('cat_id')->setField('cat_id');

        $facet = $facetSet->createFacetRange('priceranges');
        $facet->setField($price_field);
        $facet->setStart(0);
        if ($cookie->id_currency == 4) {
            $facet->setGap(500);
            $facet->setEnd(10000);
        } else {
            $facet->setGap(Tools::ps_round(50/$conversion_rate));
            $facet->setEnd(Tools::ps_round(200/$conversion_rate));
        }
        $facet->setInclude(Solarium_Query_Select_Component_Facet_Range::INCLUDE_UPPER);
        $facet->setOther(Solarium_Query_Select_Component_Facet_Range::OTHER_AFTER);

        $facet->addExclude($price_field);
        
        $facet = $facetSet->createFacetRange('slaranges');
        $facet->setField($sla_field);
        $facet->setStart(0);
        $facet->setGap(5);
        $facet->setEnd(20);
        $facet->setInclude(Solarium_Query_Select_Component_Facet_Range::INCLUDE_UPPER);
        $facet->setOther(Solarium_Query_Select_Component_Facet_Range::OTHER_AFTER);

        $facet->addExclude($sla_field);

        if (!$id_manufacturer) {
            $facet = $facetSet->createFacetField('brand_id');
            $facet->setField('brand_id');
            $facet->addExclude('brands');
        }

        $facet = $facetSet->createFacetField('stone');
        $facet->setField('stone');
        $facet->addExclude('stones');

        $facet = $facetSet->createFacetField('plating');
        $facet->setField('plating');
        $facet->addExclude('platings');

        $facet = $facetSet->createFacetField('material');
        $facet->setField('material');
        $facet->addExclude('materials');

        $facet = $facetSet->createFacetField('look');
        $facet->setField('look');
        $facet->addExclude('looks');

        $facet = $facetSet->createFacetField('fabric');
        $facet->setField('fabric');
        $facet->addExclude('fabrics');

        $facet = $facetSet->createFacetField('size');
        $facet->setField('size');
        $facet->addExclude('sizes');

        $facet = $facetSet->createFacetField('is_customizable');
        $facet->setField('is_customizable');
        $facet->addExclude('customizations');

        $facet = $facetSet->createFacetField('color');
        $facet->setField('color');
        $facet->addExclude('colors');

        $facet = $facetSet->createFacetField('handbag_occasion');
        $facet->setField('handbag_occasion');
        $facet->addExclude('handbag_occasions');
        
        $facet = $facetSet->createFacetField('handbag_style');
        $facet->setField('handbag_style');
        $facet->addExclude('handbag_styles');
         
        $facet = $facetSet->createFacetField('handbag_material');
        $facet->setField('handbag_material');
        $facet->addExclude('handbag_materials');
        
        $facet = $facetSet->createFacetField('shipping_sla');
        $facet->setField('shipping_sla');
        $facet->addExclude('shipping_slas');
        
        $query->setStart($start)->setRows($rows);
        $query->addSort('inStock', Solarium_Query_Select::SORT_DESC);

        if ($orderby && $orderway) {
            $way = Solarium_Query_Select::SORT_DESC;
            if ($orderby == 'price') {
                $orderby = $price_field;
                if ($orderway == 'asc')
                    $way = Solarium_Query_Select::SORT_ASC;
                else
                    $way = Solarium_Query_Select::SORT_DESC;
            }
            elseif ($orderby == 'discount')
                $orderby = 'discount';
            elseif ($orderby == 'hot') {
                if ($search_query)
                    $query->addSort('score', Solarium_Query_Select::SORT_DESC);
                $orderby = 'sales';
            }
            elseif ($orderby == 'new') {
                if ($search_query)
                    $query->addSort('score', Solarium_Query_Select::SORT_DESC);
                $orderby = 'date_add';
            }
            if ($express_shipping)
                $query->addSort('shipping_sla', Solarium_Query_Select::SORT_ASC);
            $query->addSort($orderby, $way);
            /*if ($orderby != 'hot') {
                $query->addSort('sales', Solarium_Query_Select::SORT_DESC);
                $query->addSort('date_add', Solarium_Query_Select::SORT_DESC);
            }*/
        } elseif ($search_query) {
            $query->addSort('score', Solarium_Query_Select::SORT_DESC);
            //$query->addSort('sales', Solarium_Query_Select::SORT_DESC);
            $query->addSort('date_add', Solarium_Query_Select::SORT_DESC);
        } else {
            if ($express_shipping)
                $query->addSort('shipping_sla', Solarium_Query_Select::SORT_ASC);
            else {
                //$query->addSort('sales', Solarium_Query_Select::SORT_DESC);
                $query->addSort('date_add', Solarium_Query_Select::SORT_DESC);
            }
        }

        $this->resultSet = SolrSearch::getFromCache($query);

        if (!$this->resultSet) {
            $this->resultSet = $client->select($query);

            if ($this->resultSet->getNumFound() == 0) {
                if (isset($dismax))
                    $dismax->setMinimumMatch(0);
                $this->resultSet = $client->select($query);
            }
        }

        return $this->resultSet;
    }

    public function generateFiltersBlock($selectedFilters = array()) {
        global $smarty, $link, $cookie;
        $id_lang = (int) $cookie->id_lang;

        $id_manufacturer = Tools::getValue('id_manufacturer', false);
        $new_products = Tools::getValue('latest', false);
        $sale_products = Tools::getValue('sale', false);
        $express_shipping = Tools::getValue('express_shipping', false);
        $cat_id = Tools::getValue('cat_id', false);
        /* If the current category isn't defined of if it's homepage, we have nothing to display */
        $id_parent = (int) Tools::getValue('id_category', Tools::getValue('id_category_layered', 1));
        if ($id_parent == 1 && !$this->search_query && !$id_manufacturer && !$new_products && !$sale_products && !$express_shipping && !$cat_id)
            return;

        $curr_currency = CurrencyCore::getCurrency($cookie->id_currency); 

        /* First we need to get all subcategories of current category */
        $category = new Category((int) $id_parent);
        $selectedCategory = $category->getName($id_lang);

        //Set parent category if its a category navigation and current category is not the root
        if ($id_manufacturer || $this->search_query || $category->id_parent != 1) {
            $smarty->assign('parentID', $category->id_parent);
        }

        $subCategories = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT c.id_category, c.id_parent, cl.name
		FROM ' . _DB_PREFIX_ . 'category c
		LEFT JOIN ' . _DB_PREFIX_ . 'category_lang cl ON (cl.id_category = c.id_category)
		WHERE c.nleft > ' . (int) $category->nleft . ' and c.nright <= ' . (int) $category->nright . ' AND c.active = 1 AND c.id_parent = ' . (int) $category->id . ' AND cl.id_lang = ' . (int) $cookie->id_lang . '
		ORDER BY c.position, c.id_parent ASC');

        try {
            $resultSet = $this->getResults($id_parent, $this->search_query, $id_manufacturer, $selectedFilters);
        } catch (Exception $e) {
            return false;
        }

        $filterBlocks = array();

        //category filter block
        $filterBlocks[] = array('type' => 'category',
            'name' => 'Categories',
            'is_category' => true,
            'values' => null);
        $filterBlocks[] = array('type' => 'pr',
            'name' => 'Prices',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'manufacturer',
            'name' => 'Brands',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'fabric',
            'name' => 'Fabrics',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'stone',
            'name' => 'Stones',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'plating',
            'name' => 'Platings',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'material',
            'name' => 'Materials',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'look',
            'name' => 'Looks',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'size',
            'name' => 'Sizes',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'customization',
            'name' => 'Costomization',
            'is_category' => false,
            'values' => null);

        $filterBlocks[] = array('type' => 'color',
            'name' => 'Colors',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'handbag_occasion',
            'name' => 'Occasions',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'handbag_style',
            'name' => 'Styles',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'handbag_material',
            'name' => 'Materials',
            'is_category' => false,
            'values' => null);
        $filterBlocks[] = array('type' => 'sla',
            'name' => 'Shipped In',
            'is_category' => false,
            'values' => null);

        $selectedBrands = array();
        foreach ($selectedFilters['manufacturer'] as $selectedMan) {
            $selectedBrands[] = $selectedMan['id'];
        }

        $selectedPrices = array();
        foreach ($selectedFilters['pr'] as $selectedprice) {
            $selectedPrices[] = $selectedprice['id'];
        }

        $selectedColors = array();
        foreach ($selectedFilters['color'] as $selectedcolor) {
            $selectedColors[] = $selectedcolor['id'];
        }

        $selectedFabrics = array();
        foreach ($selectedFilters['fabric'] as $selectedfabric) {
            $selectedFabrics[] = $selectedfabric['id'];
        }

        $selectedStones = array();
        foreach ($selectedFilters['stone'] as $selectedstone) {
            $selectedStones[] = $selectedstone['id'];
        }

        $selectedPlatings = array();
        foreach ($selectedFilters['plating'] as $selectedplating) {
            $selectedPlatings[] = $selectedplating['id'];
        }

        $selectedMaterials = array();
        foreach ($selectedFilters['material'] as $selectedmaterial) {
            $selectedMaterials[] = $selectedmaterial['id'];
        }

        $selectedLooks = array();
        foreach ($selectedFilters['look'] as $selectedlook) {
            $selectedLooks[] = $selectedlook['id'];
        }

        $selectedSizes = array();
        foreach ($selectedFilters['size'] as $selectedsize) {
            $selectedSizes[] = $selectedsize['id'];
        }

        $selectedcustomizationTypes = array();
        foreach ($selectedFilters['customization'] as $selectedcustomizationType) {
            $selectedcustomizationTypes[] = $selectedcustomizationType['id'];
        }

        $selectedHandbagOcassions = array();
        foreach ($selectedFilters['handbag_occasion'] as $selectedhandbag_occasion) {
            $selectedHandbagOccasions[] = $selectedhandbag_occasion['id'];
        }

        $selectedHandbagStyles = array();
        foreach ($selectedFilters['handbag_style'] as $selectedhandbag_style) {
            $selectedHandbagStyles[] = $selectedhandbag_style['id'];
        }

        $selectedHandbagMaterials = array();
        foreach ($selectedFilters['handbag_material'] as $selectedhandbag_material) {
            $selectedHandbagMaterials[] = $selectedhandbag_material['id'];
        }
        
        $selectedSlas = array();
        foreach ($selectedFilters['sla'] as $selectedsla) {
            $selectedSlas[] = $selectedsla['id'];
        }

        foreach ($filterBlocks AS &$filterBlock) {
            if ($filterBlock['type'] == 'category') {
                $c = array();
                foreach ($subCategories AS $subCat) {
                    $c[] = (int) $subCat['id_category'];
                    $filterBlock['values'][(int) $subCat['id_category']]['name'] = $subCat['name'];

                    //init the number of product in this category
                    if (!isset($filterBlock['values'][(int) $subCat['id_category']]['nbr']))
                        $filterBlock['values'][(int) $subCat['id_category']]['nbr'] = 0;
                }

                //get cat numers form facet field
                $catFacet = $resultSet->getFacetSet()->getFacet('cat_id');
                $catCounts = $catFacet->getValues();

                //count nbr product in category
                foreach ($c AS $idSubCategory)
                    $filterBlock['values'][(int) $idSubCategory]['nbr'] = $catCounts[(int) $idSubCategory];
            }
            elseif ($filterBlock['type'] == 'manufacturer') {
                $filterBlock['name'] = $this->l('Brands');

                $man = array();

                if ($manFacet = $resultSet->getFacetSet()->getFacet('brand_id')) {
                    $manCounts = $manFacet->getValues();


                    foreach ($manCounts AS $manID => $manCount) {
                        $manName = Manufacturer::getNameById($manID);
                        $filterBlock['values'][(int) $manID]['name'] = $manName;
                        $filterBlock['values'][(int) $manID]['nbr'] = $manCount;
                        if (isset($selectedFilters['manufacturer']) AND in_array($manID, $selectedBrands))
                            $filterBlock['values'][(int) $manID]['checked'] = true;
                    }
                }
            }
            elseif ($filterBlock['type'] == 'pr') {
                $priceFacet = $resultSet->getFacetSet()->getFacet('priceranges');
                $priceCounts = $priceFacet->getValues();

                $prCounts = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);

                foreach ($priceCounts as $priceRange => $priceCount) {
                    if ($cookie->id_currency == 4) {
                        $rangeStart = floatval($priceRange);

                        if ($rangeStart >= 0.0 && $rangeStart < 1000.0)
                            $prCounts[1] += $priceCount;
                        elseif ($rangeStart >= 1000.0 && $rangeStart < 2500.0)
                            $prCounts[2] += $priceCount;
                        elseif ($rangeStart >= 2500.0 && $rangeStart < 5000.0)
                            $prCounts[3] += $priceCount;
                        elseif ($rangeStart >= 5000.0 && $rangeStart < 10000.0)
                            $prCounts[4] += $priceCount;
                    }
                    else {
                        $conversion_rate = $curr_currency['conversion_rate'];
                        $rangeStart = floatval($priceRange);

                        if ($rangeStart >= 0.0 && $rangeStart < Tools::ps_round(50/$conversion_rate))
                            $prCounts[1] += $priceCount;
                        elseif ($rangeStart >= Tools::ps_round(50/$conversion_rate) && $rangeStart < Tools::ps_round(100/$conversion_rate))
                            $prCounts[2] += $priceCount;
                        elseif ($rangeStart >= Tools::ps_round(100/$conversion_rate) && $rangeStart < Tools::ps_round(150/$conversion_rate))
                            $prCounts[3] += $priceCount;
                        elseif ($rangeStart >= Tools::ps_round(150/$conversion_rate) && $rangeStart < Tools::ps_round(200/$conversion_rate))
                            $prCounts[4] += $priceCount;
                    }
                }

                $prCounts[5] = $priceFacet->getAfter();

                if ($cookie->id_currency == 4) {
                    $filterBlock['values'][1]['name'] = '< Rs. 1000';
                    $filterBlock['values'][1]['nbr'] = $prCounts[1];
                    if (isset($selectedFilters['pr']) AND in_array(1, $selectedPrices))
                        $filterBlock['values'][1]['checked'] = true;
                    $filterBlock['values'][2]['name'] = 'Rs. 1000 - Rs. 2500';
                    $filterBlock['values'][2]['nbr'] = $prCounts[2];
                    if (isset($selectedFilters['pr']) AND in_array(2, $selectedPrices))
                        $filterBlock['values'][2]['checked'] = true;
                    $filterBlock['values'][3]['name'] = 'Rs. 2500 - Rs. 5000';
                    $filterBlock['values'][3]['nbr'] = $prCounts[3];
                    if (isset($selectedFilters['pr']) AND in_array(3, $selectedPrices))
                        $filterBlock['values'][3]['checked'] = true;
                    $filterBlock['values'][4]['name'] = 'Rs. 5000 - Rs. 10000';
                    $filterBlock['values'][4]['nbr'] = $prCounts[4];
                    if (isset($selectedFilters['pr']) AND in_array(4, $selectedPrices))
                        $filterBlock['values'][4]['checked'] = true;
                    $filterBlock['values'][5]['name'] = '> Rs. 10000';
                    $filterBlock['values'][5]['nbr'] = $prCounts[5];
                    if (isset($selectedFilters['pr']) AND in_array(5, $selectedPrices))
                        $filterBlock['values'][5]['checked'] = true;
                }
                else {
                    $sign = $curr_currency['sign'];
                    
                    $filterBlock['values'][1]['name'] = '< '.$sign.' 50';
                    $filterBlock['values'][1]['nbr'] = $prCounts[1];
                    if (isset($selectedFilters['pr']) AND in_array(1, $selectedPrices))
                        $filterBlock['values'][1]['checked'] = true;
                    $filterBlock['values'][2]['name'] = ''.$sign.' 50 - '.$sign.' 100';
                    $filterBlock['values'][2]['nbr'] = $prCounts[2];
                    if (isset($selectedFilters['pr']) AND in_array(2, $selectedPrices))
                        $filterBlock['values'][2]['checked'] = true;
                    $filterBlock['values'][3]['name'] = ''.$sign.' 100 - '.$sign.' 150';
                    $filterBlock['values'][3]['nbr'] = $prCounts[3];
                    if (isset($selectedFilters['pr']) AND in_array(3, $selectedPrices))
                        $filterBlock['values'][3]['checked'] = true;
                    $filterBlock['values'][4]['name'] = ''.$sign.' 150 - '.$sign.' 200';
                    $filterBlock['values'][4]['nbr'] = $prCounts[4];
                    if (isset($selectedFilters['pr']) AND in_array(4, $selectedPrices))
                        $filterBlock['values'][4]['checked'] = true;
                    $filterBlock['values'][5]['name'] = '> '.$sign.' 200';
                    $filterBlock['values'][5]['nbr'] = $prCounts[5];
                    if (isset($selectedFilters['pr']) AND in_array(5, $selectedPrices))
                        $filterBlock['values'][5]['checked'] = true;
                }
            }
            elseif ($filterBlock['type'] == 'fabric') {
                $filterBlock['name'] = $this->l('Fabrics');

                if ($fabricFacet = $resultSet->getFacetSet()->getFacet('fabric')) {
                    $fabricCounts = $fabricFacet->getValues();


                    foreach ($fabricCounts AS $fabricID => $manCount) {
                        if ($fabricID != '') {
                            $filterBlock['values'][$fabricID]['name'] = ucwords(str_replace("-", " ", $fabricID));
                            $filterBlock['values'][$fabricID]['nbr'] = $manCount;
                            if (isset($selectedFilters['fabric']) AND in_array($fabricID, $selectedFabrics))
                                $filterBlock['values'][$fabricID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'stone') {
                $filterBlock['name'] = 'Stones';

                if ($stoneFacet = $resultSet->getFacetSet()->getFacet('stone')) {
                    $stoneCounts = $stoneFacet->getValues();


                    foreach ($stoneCounts AS $stoneID => $manCount) {
                        if ($stoneID != '') {
                            $filterBlock['values'][$stoneID]['name'] = ucwords(str_replace("-", " ", $stoneID));
                            $filterBlock['values'][$stoneID]['nbr'] = $manCount;
                            if (isset($selectedFilters['stone']) AND in_array($stoneID, $selectedStones))
                                $filterBlock['values'][$stoneID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'plating') {
                $filterBlock['name'] = 'Platings';

                if ($platingFacet = $resultSet->getFacetSet()->getFacet('plating')) {
                    $platingCounts = $platingFacet->getValues();


                    foreach ($platingCounts AS $platingID => $manCount) {
                        if ($platingID != '') {
                            $filterBlock['values'][$platingID]['name'] = ucwords(str_replace("-", " ", $platingID));
                            $filterBlock['values'][$platingID]['nbr'] = $manCount;
                            if (isset($selectedFilters['plating']) AND in_array($platingID, $selectedPlatings))
                                $filterBlock['values'][$platingID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'material') {
                $filterBlock['name'] = 'Materials';

                if ($materialFacet = $resultSet->getFacetSet()->getFacet('material')) {
                    $materialCounts = $materialFacet->getValues();


                    foreach ($materialCounts AS $materialID => $manCount) {
                        if ($materialID != '') {
                            $filterBlock['values'][$materialID]['name'] = ucwords(str_replace("-", " ", $materialID));
                            $filterBlock['values'][$materialID]['nbr'] = $manCount;
                            if (isset($selectedFilters['material']) AND in_array($materialID, $selectedMaterials))
                                $filterBlock['values'][$materialID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'look') {
                $filterBlock['name'] = $this->l('Looks');

                if ($lookFacet = $resultSet->getFacetSet()->getFacet('look')) {
                    $lookCounts = $lookFacet->getValues();


                    foreach ($lookCounts AS $lookID => $manCount) {
                        if ($lookID != '') {
                            $filterBlock['values'][$lookID]['name'] = ucwords(str_replace("-", " ", $lookID));
                            $filterBlock['values'][$lookID]['nbr'] = $manCount;
                            if (isset($selectedFilters['look']) AND in_array($lookID, $selectedLooks))
                                $filterBlock['values'][$lookID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'size') {
                $filterBlock['name'] = $this->l('Sizes');

                if ($sizeFacet = $resultSet->getFacetSet()->getFacet('size')) {
                    $sizeCounts = $sizeFacet->getValues();


                    foreach ($sizeCounts AS $sizeID => $sizeCount) {
                        $filterBlock['values'][$sizeID]['name'] = ucwords($sizeID);
                        $filterBlock['values'][$sizeID]['nbr'] = $sizeCount;
                        if (isset($selectedFilters['size']) AND in_array($sizeID, $selectedSizes))
                            $filterBlock['values'][$sizeID]['checked'] = true;
                    }
                }
            }
            elseif ($filterBlock['type'] == 'customization') {
                $filterBlock['name'] = $this->l('Customization');

                if ($custFacet = $resultSet->getFacetSet()->getFacet('is_customizable')) {
                    $custCounts = $custFacet->getValues();

                    if (count($custCounts) > 1)
                        foreach ($custCounts AS $custType => $custCount) {
                            $filterBlock['values'][$custType]['name'] = $custType == 0 ? "Ready to wear" : "Customizable";
                            $filterBlock['values'][$custType]['nbr'] = $custCount;
                            if (isset($selectedFilters['customization']) AND in_array($custType, $selectedcustomizationTypes))
                                $filterBlock['values'][$custType]['checked'] = true;
                        }
                }
            }
            elseif ($filterBlock['type'] == 'color') {
                $filterBlock['name'] = $this->l('Colors');

                if ($colorFacet = $resultSet->getFacetSet()->getFacet('color')) {
                    $colorCounts = $colorFacet->getValues();


                    foreach ($colorCounts AS $colorID => $colorCount) {
                        $filterBlock['values'][$colorID]['name'] = ucwords(str_replace("-", " ", $colorID));
                        $filterBlock['values'][$colorID]['nbr'] = $colorCount;
                        if (isset($selectedFilters['color']) AND in_array($colorID, $selectedColors))
                            $filterBlock['values'][$colorID]['checked'] = true;
                    }
                }
            }
            elseif ($filterBlock['type'] == 'handbag_occasion') {
                $filterBlock['name'] = 'Occasions';

                if ($handbag_occasionFacet = $resultSet->getFacetSet()->getFacet('handbag_occasion')) {
                    $handbag_occasionCounts = $handbag_occasionFacet->getValues();


                    foreach ($handbag_occasionCounts AS $handbag_occasionID => $manCount) {
                        if ($handbag_occasionID != '') {
                            $filterBlock['values'][$handbag_occasionID]['name'] = ucwords(str_replace("-", " ", $handbag_occasionID));
                            $filterBlock['values'][$handbag_occasionID]['nbr'] = $manCount;
                            if (isset($selectedFilters['handbag_occasion']) AND in_array($handbag_occasionID, $selectedHandbagOcassions))
                                $filterBlock['values'][$handbag_occasionID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'handbag_style') {
                $filterBlock['name'] = 'Styles';

                if ($handbag_styleFacet = $resultSet->getFacetSet()->getFacet('handbag_style')) {
                    $handbag_styleCounts = $handbag_styleFacet->getValues();


                    foreach ($handbag_styleCounts AS $handbag_styleID => $manCount) {
                        if ($handbag_styleID != '') {
                            $filterBlock['values'][$handbag_styleID]['name'] = ucwords(str_replace("-", " ", $handbag_styleID));
                            $filterBlock['values'][$handbag_styleID]['nbr'] = $manCount;
                            if (isset($selectedFilters['handbag_style']) AND in_array($handbag_styleID, $selectedHandbagStyles))
                                $filterBlock['values'][$handbag_styleID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'handbag_material') {
                $filterBlock['name'] = 'Materials';

                if ($handbag_materialFacet = $resultSet->getFacetSet()->getFacet('handbag_material')) {
                    $handbag_materialCounts = $handbag_materialFacet->getValues();


                    foreach ($handbag_materialCounts AS $handbag_materialID => $manCount) {
                        if ($handbag_materialID != '') {
                            $filterBlock['values'][$handbag_materialID]['name'] = ucwords(str_replace("-", " ", $handbag_materialID));
                            $filterBlock['values'][$handbag_materialID]['nbr'] = $manCount;
                            if (isset($selectedFilters['handbag_material']) AND in_array($handbag_materialID, $selectedHandbagMaterials))
                                $filterBlock['values'][$handbag_materialID]['checked'] = true;
                        }
                    }
                }
            }
            elseif ($filterBlock['type'] == 'sla') {
                $slaFacet = $resultSet->getFacetSet()->getFacet('slaranges');
                $slaCounts = $slaFacet->getValues();
                $sCounts = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);

                foreach ($slaCounts as $slaRange => $slaCount) {
                        $rangeStart = intval($slaRange);

                        if ($rangeStart >= 0 && $rangeStart < 5)
                            $sCounts[1] += $slaCount;
                        elseif ($rangeStart >= 5 && $rangeStart < 10)
                            $sCounts[2] += $slaCount;
                        elseif ($rangeStart >= 10 && $rangeStart < 15)
                            $sCounts[3] += $slaCount;
                        elseif ($rangeStart >= 15 && $rangeStart < 20)
                            $sCounts[4] += $slaCount;
                }

                $sCounts[5] = $slaFacet->getAfter();

                $filterBlock['values'][1]['name'] = '< 5 days';
                $filterBlock['values'][1]['nbr'] = $sCounts[1];
                if (isset($selectedFilters['sla']) AND in_array(1, $selectedSlas))
                   $filterBlock['values'][1]['checked'] = true;
                    
                $filterBlock['values'][2]['name'] = '5-10 days';
                $filterBlock['values'][2]['nbr'] = $sCounts[2];
                if (isset($selectedFilters['sla']) AND in_array(2, $selectedSlas))
                    $filterBlock['values'][2]['checked'] = true;
                    
                $filterBlock['values'][3]['name'] = '10-15 days';
                $filterBlock['values'][3]['nbr'] = $sCounts[3];
                if (isset($selectedFilters['sla']) AND in_array(3, $selectedSlas))
                    $filterBlock['values'][3]['checked'] = true;

                $filterBlock['values'][4]['name'] = '15-20 days';
                $filterBlock['values'][4]['nbr'] = $sCounts[4];
                if (isset($selectedFilters['sla']) AND in_array(4, $selectedSlas))
                    $filterBlock['values'][4]['checked'] = true;

                $filterBlock['values'][5]['name'] = '> 20 days';
                $filterBlock['values'][5]['nbr'] = $sCounts[5];
                if (isset($selectedFilters['sla']) AND in_array(5, $selectedSlas))
                    $filterBlock['values'][5]['checked'] = true;
            }
        }
        $nFilters = 0;
        foreach ($selectedFilters AS $filters)
            $nFilters += sizeof($filters);

        $displayFilters = array();
        //echo var_dump($filterBlocks);exit;
        foreach ($filterBlocks as $filterblock) {
            if ($filterblock['type'] == 'customization')
                $displayFilters[0] = $filterblock;
            if ($filterblock['type'] == 'size')
                $displayFilters[1] = $filterblock;
            if ($filterblock['type'] == 'category')
                $displayFilters[2] = $filterblock;
            if ($filterblock['type'] == 'pr')
                $displayFilters[3] = $filterblock;
            if ($filterblock['type'] == 'sla')
                $displayFilters[4] = $filterblock;
            if ($filterblock['type'] == 'fabric')
                $displayFilters[5] = $filterblock;
            if ($filterblock['type'] == 'color')
                $displayFilters[6] = $filterblock;
            if ($filterblock['type'] == 'stone')
                $displayFilters[7] = $filterblock;
            if ($filterblock['type'] == 'plating')
                $displayFilters[8] = $filterblock;
            if ($filterblock['type'] == 'material')
                $displayFilters[9] = $filterblock;
            if ($filterblock['type'] == 'look')
                $displayFilters[10] = $filterblock;
            if ($filterblock['type'] == 'handbag_occasion')
                $displayFilters[11] = $filterblock;
            if ($filterblock['type'] == 'handbag_style')
                $displayFilters[12] = $filterblock;
            if ($filterblock['type'] == 'handbag_material')
                $displayFilters[13] = $filterblock;
            //if ($filterblock['type'] == 'manufacturer') $displayFilters[2] = $filterblock;
        }
        ksort($displayFilters);

        //echo var_dump($displayFilters);

        if ($id_manufacturer)
            $smarty->assign('brand', $id_manufacturer);

        if ($new_products)
            $smarty->assign('latest', 1);
        else
            $smarty->assign('latest', 0);

        if ($sale_products)
            $smarty->assign('sale', 1);
        else
            $smarty->assign('sale', 0);

        if ($express_shipping)
            $smarty->assign('express_shipping', 1);
        else
            $smarty->assign('express_shipping', 0);

	if( $cat_id )
		$smarty->assign('cat_id',$cat_id);
	else
		$smarty->assign('cat_id',0);

        if ($id_manufacturer || $this->search_query || $category->id_parent != 1 || $new_products || $sale_products || $express_shipping || $cat_id)
            $smarty->assign('isCategoryCloseable', '1');

        $smarty->assign(array(
            'name_category_layered' => $selectedCategory,
            'search_query' => $this->search_query,
            'layered_use_checkboxes' => (int) Configuration::get('PS_LAYERED_NAVIGATION_CHECKBOXES'),
            'id_category_layered' => (int) $id_parent,
            'selected_filters' => $selectedFilters,
            'n_filters' => (int) $nFilters,
            'nbr_filterBlocks' => sizeof($filterBlocks),
            'filters' => $displayFilters));

        $html_fragment = $this->display(__FILE__, 'blocklayered.tpl');
        return $html_fragment;
    }

    public function ajaxCall() {
        //sleep(1);
        global $smarty, $cookie;
        $selectedFilters = $this->getSelectedFilters();
        $id_parent = (int) Tools::getValue('id_category', Tools::getValue('id_category_layered', 1));
        $id_manufacturer = Tools::getValue('id_manufacturer', false);

        $sortInfo = '';
        if (Tools::getValue('orderby') && Tools::getValue('orderway'))
            $sortInfo = Tools::getProductsOrder('by', Tools::getValue('orderby')) . ':' . Tools::getProductsOrder('way', Tools::getValue('orderway'));

        //echo print_r($selectedFilters);
        //$products = $this->getProductByFilters($selectedFilters);
        $resultSet = $this->getResults($id_parent, $this->search_query, $id_manufacturer, $selectedFilters);
        $products = $resultSet->getData();
        $products = $products['response']['docs'];

        $nbProducts = $resultSet->getNumFound();
        $range = 3; /* how many pages around page selected */

        $n = (int) Tools::getValue('n', Configuration::get('PS_PRODUCTS_PER_PAGE'));
        $p = Tools::getValue('p', 1);

        if ($p < 0)
            $p = 0;

        if ($p > ($nbProducts / $n))
            $p = ceil($nbProducts / $n);
        $pages_nb = ceil($nbProducts / (int) ($n));

        $start = (int) ($p - $range);
        if ($start < 1)
            $start = 1;

        $stop = (int) ($p + $range);
        if ($stop > $pages_nb)
            $stop = (int) ($pages_nb);

        $smarty->assign('nb_products', $nbProducts);
        $pagination_infos = array(
            'pages_nb' => (int) ($pages_nb),
            'p' => (int) ($p),
            'n' => (int) ($n),
            'range' => (int) ($range),
            'start' => (int) ($start),
            'stop' => (int) ($stop),
            'nArray' => $nArray = (int) (Configuration::get('PS_PRODUCTS_PER_PAGE')) != 10 ? array((int) (Configuration::get('PS_PRODUCTS_PER_PAGE')), 10, 20, 50) : array(10, 20, 50)
        );
        $smarty->assign($pagination_infos);

        $smarty->assign('static_token', Tools::getToken(false));

        $smarty->assign('products', $products);

        $category = new Category((int) $id_parent);
        $selectedCategory = $category->getName(1);
        $productsTitle = $this->search_query ? $this->search_query : ($id_manufacturer ? Manufacturer::getNameById($id_manufacturer, 1) : $selectedCategory);
        $smarty->assign('lazy', 0);

        $nextPage = $p + 1;
        if ($p == $stop)
            $nextPage = 0;

        $smarty->assign('nextPage', $nextPage);

        $autoLoad = Tools::getValue('al', false);
        header('Content-type: application/json');

        if ($cookie->image_size == IMAGE_SIZE_LARGE)
            $productListContent = $smarty->fetch(_PS_THEME_DIR_ . 'product-list-page.tpl');
        else
            $productListContent = $smarty->fetch(_PS_THEME_DIR_ . 'product-list-page-small.tpl');

        if ($autoLoad) {
            $smarty->assign('autoload', 1);
            return Tools::jsonEncode(array(
                        'productList' => $productListContent,
                        'nextPage' => $nextPage
            ));
        } else {
            $smarty->assign('autoload', 0);
            return Tools::jsonEncode(array(
                        'filtersBlock' => $this->generateFiltersBlock($selectedFilters),
                        'productList' => $productListContent,
                        'pagination' => $smarty->fetch(_PS_THEME_DIR_ . 'pagination.tpl'),
                        'totalItems' => $nbProducts,
                        'sortInfo' => $sortInfo,
                        'productsTitle' => $productsTitle,
                        'nextPage' => $nextPage
            ));
        }
        //	return '<div id="layered_ajax_column">'.$this->generateFiltersBlock($selectedFilters).'</div><div id="layered_ajax_products">'.$smarty->fetch(_PS_THEME_DIR_.'product-list.tpl').'</div>';
    }

}
