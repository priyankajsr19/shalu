<?php


class ProductControllerCore extends FrontController
{
    protected $product;
    protected $is_saree;
    protected $is_skd;
    protected $is_skd_rts;
    protected $has_bottom;
    protected $is_pakistani_rts;
    protected $is_anarkali = false;
    protected $is_lehenga = false;
    protected $is_bottoms = false;
    protected $is_cholis = false;
    protected $is_giftcard = false;
    protected $is_jewelry = false;
    protected $is_kids = false;
    protected $is_abaya = false;
    protected $is_men = false;
    protected $is_handbag = false;
    protected $is_wristwear = false;

    public function setMedia()
    {
        parent::setMedia();
    }

    public function preProcess()
    {
        if ($id_product = (int)Tools::getValue('id_product'))
        {
            $this->product = new Product($id_product, true, self::$cookie->id_lang);
		//if((int)Tools::getValue('pp') == 1){
		//	print_r($this->product->getPrice(false, null, 2));
		//}
            $id_product = (int)(Tools::getValue('id_product'));
            $productsViewed = (isset(self::$cookie->viewed) AND !empty(self::$cookie->viewed)) ? array_slice(explode(',', self::$cookie->viewed), 0, 12) : array();
            
            if (sizeof($productsViewed))
            {
                if ($id_product AND !in_array($id_product, $productsViewed))
                {
                    array_unshift($productsViewed, $id_product);
                }
            }
            else
                $productsViewed[] = $id_product;
            
            self::$cookie->viewed = implode(',', $productsViewed);
        }

        if (!Validate::isLoadedObject($this->product))
        {
            header('HTTP/1.1 404 Not Found');
            header('Status: 404 Not Found');
        }
        else
        {
            // Automatically redirect to the canonical URL if the current in is the right one
            // $_SERVER['HTTP_HOST'] must be replaced by the real canonical domain
            if (Validate::isLoadedObject($this->product))
            {
                $canonicalURL = self::$link->getProductLink($this->product);
                if (!preg_match('/^'.Tools::pRegexp($canonicalURL, '/').'([&?].*)?$/', Tools::getProtocol().$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) && !Tools::getValue('adtoken'))
                {
                    header('HTTP/1.0 301 Moved');
                    if (defined('_PS_MODE_DEV_') AND _PS_MODE_DEV_)
                        die('[Debug] This page has moved<br />Please use the following URL instead: <a href="'.$canonicalURL.'">'.$canonicalURL.'</a>');
                    Tools::redirectLink($canonicalURL);
                }
            }
        }

        parent::preProcess();

        if((int)(Configuration::get('PS_REWRITING_SETTINGS')))
            if ($id_product = (int)Tools::getValue('id_product'))
            {
                $rewrite_infos = Product::getUrlRewriteInformations((int)$id_product);

                $default_rewrite = array();
                foreach ($rewrite_infos AS $infos)
                    $default_rewrite[$infos['id_lang']] = self::$link->getProductLink((int)$id_product, $infos['link_rewrite'], $infos['category_rewrite'], $infos['ean13'], (int)$infos['id_lang']);

                self::$smarty->assign('lang_rewrite_urls', $default_rewrite);
            }
            
        //get categories
        $categories = $this->product->getCategories();

        if(in_array(CAT_SAREE, $categories)) {
            if( in_array(CAT_BOLLYWOOD_SAREE,$categories) )
                self::$smarty->assign('bollywood', true);
            $this->is_saree = true;
        }

        else if(in_array(CAT_SKD, $categories)) {
            if( in_array(CAT_BOLLYWOOD_SKD,$categories) )
                self::$smarty->assign('bollywood', true);
            
	if( $this->product->is_rts ) {
        
                $this->is_skd_rts = true;
                if(in_array(CAT_PAKISTANI_SKD,$categories))
                    $this->is_pakistani_rts = true;
		if($this->product->has_bottom)
                    $this->has_bottom = true;
            }
            else
                $this->is_skd = true;
        }
        else if(in_array(CAT_KURTI, $categories)) {
            
            //replace 4 with constant from defines later
            if( $this->product->is_rts )
                $this->is_skd_rts = true;
               else $this->is_skd = true;
	    if($this->product->has_bottom)
		$this->has_bottom = true;
        }
        else if(in_array(CAT_LEHENGA, $categories)) {
            if( in_array(CAT_BOLLYWOOD_LEHENGA,$categories) )
                self::$smarty->assign('bollywood', true);
            $this->is_lehenga = true;
        }
        else if(in_array(CAT_GIFTCARD, $categories))
            $this->is_giftcard = true;
        else if(in_array(CAT_JEWELRY, $categories))
            $this->is_jewelry = true;
        else if(in_array(CAT_KIDS, $categories))
            $this->is_kids = true;
        else if(in_array(CAT_MEN, $categories))
                $this->is_men = true;
        
        if(in_array(CAT_ANARKALI, $categories))
            $this->is_anarkali = true;
        if(in_array(CAT_BOTTOMS, $categories))
            $this->is_bottoms = true;
        if(in_array(CAT_CHOLIS, $categories))
            $this->is_cholis = true;
        if(in_array(CAT_ABAYA, $categories))
            $this->is_abaya = true;
        if(in_array(CAT_HANDBAG, $categories))
            $this->is_handbag = true;
        if(in_array(465, $categories))
            $this->is_wristwear = true;
    }

    public function process()
    {
        global $cart, $currency;;
        parent::process();

        if (!$id_product = (int)(Tools::getValue('id_product')) OR !Validate::isUnsignedId($id_product))
            $this->errors[] = Tools::displayError('Product not found');
        else
        {
            if (!Validate::isLoadedObject($this->product)
                OR (!$this->product->active AND (Tools::getValue('adtoken') != Tools::encrypt('PreviewProduct'.$this->product->id))
                || !file_exists(dirname(__FILE__).'/../'.Tools::getValue('ad').'/ajax.php')))
            {
                header('HTTP/1.1 404 page not found');
                $this->errors[] = Tools::displayError('Product is no longer available.');
            }
            elseif (!$this->product->checkAccess((int)(self::$cookie->id_customer)))
                $this->errors[] = Tools::displayError('You do not have access to this product.');
            else
            {
                self::$smarty->assign('virtual', ProductDownload::getIdFromIdProduct((int)($this->product->id)));

                if (!$this->product->active)
                    self::$smarty->assign('adminActionDisplay', true);

                /* rewrited url set */
                $rewrited_url = self::$link->getProductLink($this->product->id, $this->product->link_rewrite);

                /* Product pictures management */
                require_once('images.inc.php');
                self::$smarty->assign('customizationFormTarget', Tools::safeOutput(urldecode($_SERVER['REQUEST_URI'])));

                if (Tools::isSubmit('submitCustomizedDatas'))
                {
                    $this->pictureUpload($this->product, $cart);
                    $this->textRecord($this->product, $cart);
                    $this->formTargetFormat();
                }
                elseif (isset($_GET['deletePicture']) AND !$cart->deletePictureToProduct((int)($this->product->id), (int)(Tools::getValue('deletePicture'))))
                    $this->errors[] = Tools::displayError('An error occurred while deleting the selected picture');

                $files = self::$cookie->getFamily('pictures_'.(int)($this->product->id));
                $textFields = self::$cookie->getFamily('textFields_'.(int)($this->product->id));
                foreach ($textFields as $key => $textField)
                    $textFields[$key] = str_replace('<br />', "\n", $textField);
                self::$smarty->assign(array(
                    'pictures' => $files,
                    'textFields' => $textFields));

                $productPriceWithTax = Product::getPriceStatic($id_product, true, NULL, 6);
                if (Product::$_taxCalculationMethod == PS_TAX_INC)
                    $productPriceWithTax = Tools::ps_round($productPriceWithTax, 2);

                $productPriceWithoutEcoTax = (float)($productPriceWithTax - $this->product->ecotax);
                $configs = Configuration::getMultiple(array('PS_ORDER_OUT_OF_STOCK', 'PS_LAST_QTIES'));

                /* Features / Values */
                $features = $this->product->getFrontFeatures((int)(self::$cookie->id_lang));
                
                $attachments = $this->product->getAttachments((int)(self::$cookie->id_lang));

                /* Category */
                $category = false;
                if (isset($_SERVER['HTTP_REFERER']) AND preg_match('!^(.*)\/([0-9]+)\-(.*[^\.])|(.*)id_category=([0-9]+)(.*)$!', $_SERVER['HTTP_REFERER'], $regs) AND !strstr($_SERVER['HTTP_REFERER'], '.html'))
                {
                    if (isset($regs[2]) AND is_numeric($regs[2]))
                    {
                        if (Product::idIsOnCategoryId((int)($this->product->id), array('0' => array('id_category' => (int)($regs[2])))))
                            $category = new Category((int)($regs[2]), (int)(self::$cookie->id_lang));
                    }
                    elseif (isset($regs[5]) AND is_numeric($regs[5]))
                    {
                        if (Product::idIsOnCategoryId((int)($this->product->id), array('0' => array('id_category' => (int)($regs[5])))))
                            $category = new Category((int)($regs[5]), (int)(self::$cookie->id_lang));
                    }
                }
                if (!$category)
                    $category = new Category($this->product->id_category_default, (int)(self::$cookie->id_lang));

                if (isset($category) AND Validate::isLoadedObject($category))
                {
                    self::$smarty->assign(array(
                    'path' => Tools::getPath((int)$category->id, $this->product->name, true),
                    'category' => $category,
                    'subCategories' => $category->getSubCategories((int)(self::$cookie->id_lang), true),
                    'id_category_current' => (int)($category->id),
                    'id_category_parent' => (int)($category->id_parent),
                    'return_category_name' => Tools::safeOutput($category->name)));
                }
                else
                    self::$smarty->assign('path', Tools::getPath((int)$this->product->id_category_default, $this->product->name));

                self::$smarty->assign('return_link', (isset($category->id) AND $category->id) ? Tools::safeOutput(self::$link->getCategoryLink($category)) : 'javascript: history.back();');

                $lang = Configuration::get('PS_LANG_DEFAULT');
                if (Pack::isPack((int)($this->product->id), (int)($lang)) AND !Pack::isInStock((int)($this->product->id), (int)($lang)))
                    $this->product->quantity = 0;

                $group_reduction = (100 - Group::getReduction((int)(self::$cookie->id_customer))) / 100;
                $id_customer = (isset(self::$cookie->id_customer) AND self::$cookie->id_customer) ? (int)(self::$cookie->id_customer) : 0;
                $id_group = $id_customer ? (int)(Customer::getDefaultGroupId($id_customer)) : _PS_DEFAULT_CUSTOMER_GROUP_;
                $id_country = (int)($id_customer ? Customer::getCurrentCountry($id_customer) : Configuration::get('PS_COUNTRY_DEFAULT'));

                // Tax
                $tax = (float)(Tax::getProductTaxRate((int)($this->product->id), $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')}));
                self::$smarty->assign('tax_rate', $tax);

                $ecotax_rate = (float) Tax::getProductEcotaxRate($cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')});
                $ecotaxTaxAmount = Tools::ps_round($this->product->ecotax, 2);
                if (Product::$_taxCalculationMethod == PS_TAX_INC && (int)Configuration::get('PS_TAX'))
                    $ecotaxTaxAmount = Tools::ps_round($ecotaxTaxAmount * (1 + $ecotax_rate / 100), 2);

                $manufacturer = new Manufacturer((int)($this->product->id_manufacturer), 1);
                $sizechart = new Sizechart((int)($this->product->id_sizechart), 1);
                
                //see if the product is already in the wishlist
                if($id_customer)
                {
                    $sql = "select id from ps_wishlist where id_customer = " . $id_customer . " and id_product = " . $this->product->id;
                    $res = Db::getInstance()->ExecuteS($sql);
                    if($res)
                        self::$smarty->assign("in_wishlist", true);
                    else
                        self::$smarty->assign("in_wishlist", false);
                }
                else
                    self::$smarty->assign("in_wishlist", false);
                
                self::$smarty->assign(array(
                    'quantity_discounts' => $this->formatQuantityDiscounts(SpecificPrice::getQuantityDiscounts((int)($this->product->id), (int)(Shop::getCurrentShop()), (int)(self::$cookie->id_currency), $id_country, $id_group), $this->product->getPrice(Product::$_taxCalculationMethod == PS_TAX_INC, false), (float)($tax)),
                    'product' => $this->product,
                    'ecotax_tax_inc' => $ecotaxTaxAmount,
                    'ecotax_tax_exc' => Tools::ps_round($this->product->ecotax, 2),
                    'ecotaxTax_rate' => $ecotax_rate,
                    'homeSize' => Image::getSize('home'),
                    'product_manufacturer' => $manufacturer,
                    'token' => Tools::getToken(false),
                    'productPriceWithoutEcoTax' => (float)($productPriceWithoutEcoTax),
                    'features' => $features,
                    'attachments' => $attachments,
                    'allow_oosp' => $this->product->isAvailableWhenOutOfStock((int)($this->product->out_of_stock)),
                    'last_qties' =>  (int)($configs['PS_LAST_QTIES']),
                    'group_reduction' => $group_reduction,
                    'col_img_dir' => _PS_COL_IMG_DIR_,
                        'sizechart' => $sizechart->sizechart,
                    'sizechart_data' => $sizechart->sizechart_data
                ));
                self::$smarty->assign(array(
                    'HOOK_EXTRA_LEFT' => Module::hookExec('extraLeft'),
                    'HOOK_EXTRA_RIGHT' => Module::hookExec('extraRight'),
                    'HOOK_PRODUCT_OOS' => Hook::productOutOfStock($this->product),
                    'HOOK_PRODUCT_FOOTER' => Hook::productFooter($this->product, $category),
                    'HOOK_PRODUCT_ACTIONS' => Module::hookExec('productActions'),
                    'HOOK_PRODUCT_TAB' =>  Module::hookExec('productTab'),
                    'HOOK_PRODUCT_TAB_CONTENT' =>  Module::hookExec('productTabContent')
                ));

                $images = $this->product->getImages((int)(self::$cookie->id_lang));
                $productImages = array();
                foreach ($images AS $k => $image)
                {
                    if ($image['cover'])
                    {
                        self::$smarty->assign('mainImage', $images[0]);
                        $cover = $image;
                        $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($this->product->id.'-'.$image['id_image']) : $image['id_image']);
                        $cover['id_image_only'] = (int)($image['id_image']);
                    }
                    $productImages[(int)($image['id_image'])] = $image;
                }
                if (!isset($cover))
                    $cover = array('id_image' => Language::getIsoById(self::$cookie->id_lang).'-default', 'legend' => 'No picture', 'title' => 'No picture');
                $size = Image::getSize('large');
                self::$smarty->assign(array(
                    'cover' => $cover,
                    'imgWidth' => (int)($size['width']),
                    'mediumSize' => Image::getSize('medium'),
                    'largeSize' => Image::getSize('large'),
                    'accessories' => $this->product->getAccessories((int)(self::$cookie->id_lang))));
                if (sizeof($productImages))
                    self::$smarty->assign('images', $productImages);

                /* Attributes / Groups & colors */
                $colors = array();
                
                
                //see if the product has shades
                if($this->product->id_group && $this->product->id_group > 0)
                {
                    global $link;
                    $related_productIds = $this->product->getRelatedProducts();
                    $related_products = array();
                    
                    foreach ($related_productIds as &$productId)
                    {
                        $relProduct = new Product((int)$productId['id_product'], true, self::$cookie->id_lang);
                        $idImage = $relProduct->getCoverWs();
                        if($idImage)
                            $idImage = $relProduct->id.'-'.$idImage;
                        else
                            $idImage = Language::getIsoById(1).'-default';
                        
                        $relProduct->image_link = $link->getImageLink($relProduct->link_rewrite, $idImage, 'small');
                        $relProduct->link = $relProduct->getLink();
                        $related_products[] = $relProduct;
                    }
                    
                    self::$smarty->assign('relatedProducts', $related_products);
                }
                
                
                $attributesGroups = $this->product->getAttributesGroups((int)(self::$cookie->id_lang));  // @todo (RM) should only get groups and not all declination ?
                if (is_array($attributesGroups) AND $attributesGroups)
                {
                    $groups = array();
                    $combinationImages = $this->product->getCombinationImages((int)(self::$cookie->id_lang));
                    foreach ($attributesGroups AS $k => $row)
                    {
                        /* Color management */
                        if (((isset($row['attribute_color']) AND $row['attribute_color']) OR (file_exists(_PS_COL_IMG_DIR_.$row['id_attribute'].'.jpg'))) AND $row['id_attribute_group'] == $this->product->id_color_default)
                        {
                            $colors[$row['id_attribute']]['value'] = $row['attribute_color'];
                            $colors[$row['id_attribute']]['name'] = $row['attribute_name'];
                            if (!isset($colors[$row['id_attribute']]['attributes_quantity']))
                                $colors[$row['id_attribute']]['attributes_quantity'] = 0;
                            $colors[$row['id_attribute']]['attributes_quantity'] += (int)($row['quantity']);
                        }

                        if (!isset($groups[$row['id_attribute_group']]))
                        {
                            $groups[$row['id_attribute_group']] = array(
                                'name' =>            $row['public_group_name'],
                                'is_color_group' =>    $row['is_color_group'],
                                'default' =>        -1,
                            );
                        }

                        $groups[$row['id_attribute_group']]['attributes'][$row['id_attribute']] = $row['attribute_name'];
                        if ($row['default_on'] && $groups[$row['id_attribute_group']]['default'] == -1)
                            $groups[$row['id_attribute_group']]['default'] = (int)($row['id_attribute']);
                        if (!isset($groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']]))
                            $groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']] = 0;
                        $groups[$row['id_attribute_group']]['attributes_quantity'][$row['id_attribute']] += (int)($row['quantity']);

                        $combinations[$row['id_product_attribute']]['attributes_values'][$row['id_attribute_group']] = $row['attribute_name'];
                        $combinations[$row['id_product_attribute']]['attributes'][] = (int)($row['id_attribute']);
                        $combinations[$row['id_product_attribute']]['price'] = (float)($row['price']);
                        $combinations[$row['id_product_attribute']]['ecotax'] = (float)($row['ecotax']);
                        $combinations[$row['id_product_attribute']]['weight'] = (float)($row['weight']);
                        $combinations[$row['id_product_attribute']]['quantity'] = (int)($row['quantity']);
                        $combinations[$row['id_product_attribute']]['reference'] = $row['reference'];
                        $combinations[$row['id_product_attribute']]['unit_impact'] = $row['unit_price_impact'];
                        $combinations[$row['id_product_attribute']]['minimal_quantity'] = $row['minimal_quantity'];
                        $combinations[$row['id_product_attribute']]['id_image'] = isset($combinationImages[$row['id_product_attribute']][0]['id_image']) ? $combinationImages[$row['id_product_attribute']][0]['id_image'] : -1;
                    }

                    //wash attributes list (if some attributes are unavailables and if allowed to wash it)
                    if (!Product::isAvailableWhenOutOfStock($this->product->out_of_stock) && Configuration::get('PS_DISP_UNAVAILABLE_ATTR') == 0)
                    {
                        foreach ($groups AS &$group)
                            foreach ($group['attributes_quantity'] AS $key => &$quantity)
                                if (!$quantity)
                                    unset($group['attributes'][$key]);

                        foreach ($colors AS $key => $color)
                            if (!$color['attributes_quantity'])
                                unset($colors[$key]);
                    }

                    foreach ($groups AS &$group)
                        natcasesort($group['attributes']);

                    foreach ($combinations AS $id_product_attribute => $comb)
                    {
                        $attributeList = '';
                        foreach ($comb['attributes'] AS $id_attribute)
                            $attributeList .= '\''.(int)($id_attribute).'\',';
                        $attributeList = rtrim($attributeList, ',');
                        $combinations[$id_product_attribute]['list'] = $attributeList;
                    }

                    self::$smarty->assign(array(
                        'groups' => $groups,
                        'combinaisons' => $combinations, /* Kept for compatibility purpose only */
                        'combinations' => $combinations,
                        'colors' => (sizeof($colors) AND $this->product->id_color_default) ? $colors : false,
                        'combinationImages' => $combinationImages));
                }
                
                //$newProducts = Product::getNewProducts((int)(self::$cookie->id_lang), 0, 10, false, 'date_add', 'desc');
                $categoryProducts = $this->getRandomCatProducts();
                self::$smarty->assign('cat_products', $categoryProducts);
                
                //$brandProducts = $this->getRandomBrandProducts();
                //self::$smarty->assign('brand_products', $brandProducts);

                self::$smarty->assign(array(
                    'no_tax' => Tax::excludeTaxeOption() OR !Tax::getProductTaxRate((int)$this->product->id, $cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')}),
                    'customizationFields' => $this->product->getCustomizationFields((int)(self::$cookie->id_lang))
                ));

                // Pack management
                self::$smarty->assign('packItems', $this->product->cache_is_pack ? Pack::getItemTable($this->product->id, (int)(self::$cookie->id_lang), true) : array());
                self::$smarty->assign('packs', Pack::getPacksTable($this->product->id, (int)(self::$cookie->id_lang), true, 1));
            }
        }
        
        if($this->is_saree || $this->is_lehenga)
        {
            if($this->is_lehenga)  
                self::$smarty->assign('is_lehenga', $this->is_lehenga);
            self::$smarty->assign('as_shown', (boolean)$this->product->as_shown);
            if($blouse_measurements = $this->getCustomerMeasurements(self::$cookie->id_customer, 1))
                self::$smarty->assign('measurement_info', $blouse_measurements);
            if($skirt_measurements = $this->getCustomerMeasurements(self::$cookie->id_customer, 2))
                self::$smarty->assign('skirt_measurement_info', $skirt_measurements);

            if( $this->is_saree ) {
                //count of all styles mapped to this product
                $res = Db::getInstance()->getRow("select count(s.id_style) as style_count from ps_styles s inner join ps_product_style ps on ps.id_style = s.id_style and ps.id_product = {$id_product} and s.style_type = 1");
                $style_count = (int)$res['style_count']; 
    
                if( $style_count === 0 ) {
                    // show the default style for sarees
                    $style  = array(
                        'id_style' => 1,
                        'style_image_small' => '1-small.png' ,
                        'style_name' => 'Round'
                    );
                } else {
                    $res = Db::getInstance()->getRow("select s.id_style, s.style_name, s.style_image_small  from ps_styles s inner join ps_product_style ps on ps.id_style = s.id_style and ps.id_product = {$id_product} and s.style_type = 1 and ps.is_default = 1");
                    if( !empty($res) ) {
                        //show the default style for this product
                        $style  = array(
                            'id_style' => $res['id_style'],
                            'style_image_small' => $res['style_image_small'],
                            'style_name' => $res['style_name']
                        );
                    }
                }
                self::$smarty->assign('blouse_style_count',$style_count);
                self::$smarty->assign('blouse_style',$style);
            }
        }
        else if($this->is_skd || $this->is_skd_rts)
        {
            self::$smarty->assign('is_anarkali', $this->is_anarkali);
            if($this->is_anarkali)
            {    echo "skd ana";
                if($kurta_measurements = $this->getCustomerMeasurements(self::$cookie->id_customer, 5))
                    self::$smarty->assign('kurta_measurement_info', $kurta_measurements);
            }
            else
            {   echo "skd non ana";
                if($kurta_measurements = $this->getCustomerMeasurements(self::$cookie->id_customer, 3))
                    self::$smarty->assign('kurta_measurement_info', $kurta_measurements);
            }

            if($salwar_measurements = $this->getCustomerMeasurements(self::$cookie->id_customer, 4))
                self::$smarty->assign('salwar_measurement_info', $salwar_measurements);

            //get default styles for this product (RTS)
            if( $this->is_skd_rts ) {
                   $res = Db::getInstance()->ExecuteS("select count(s.id_style) as style_count, s.style_type, ps.id_product from ps_styles s inner join ps_product_style ps on ps.id_style = s.id_style and ps.id_product = {$id_product} group by ps.id_product,s.style_type");
                   foreach($res as $s) {
                       $style_count = (int)$s['style_count'];
                       if( (int)$s['style_type'] === 4 ) {
                             self::$smarty->assign('kurta_style_count',$style_count);
                       } else if ( (int)$s['style_type'] === 5 ) {
                             self::$smarty->assign('salwar_style_count',$style_count);
                       }
                   } 


                   $res = Db::getInstance()->ExecuteS("select s.id_style, s.style_type, s.style_image_small, s.style_name from ps_styles s inner join ps_product_style ps on ps.id_style = s.id_style and ps.id_product = {$id_product} and ps.is_default = 1");
                   foreach($res as $s) {
                       $style  = array(
                                  'id_style' => $s['id_style'],
                                  'style_image_small' => $s['style_image_small'],
                                  'style_name' => $s['style_name']
                               );
                       if( (int)$s['style_type'] === 4 ) {
                             self::$smarty->assign('kurta_style',$style);
                       } else if ( (int)$s['style_type'] === 5 ) {
                             self::$smarty->assign('salwar_style',$style);
                       }
                   }
            } 
        }
        
        self::$smarty->assign('is_bottoms', $this->is_bottoms);
        self::$smarty->assign('is_abaya', $this->is_abaya);
        self::$smarty->assign('is_wristwear', $this->is_wristwear);
        self::$smarty->assign('is_pakistani_rts', $this->is_pakistani_rts);
       
        self::$smarty->assign(array(
            'ENT_NOQUOTES' => ENT_NOQUOTES,
            'outOfStockAllowed' => (int)(Configuration::get('PS_ORDER_OUT_OF_STOCK')),
            'errors' => $this->errors,
            'categories' => Category::getHomeCategories((int)(self::$cookie->id_lang)),
            'have_image' => Product::getCover((int)(Tools::getValue('id_product'))),
            'tax_enabled' => Configuration::get('PS_TAX'),
            'display_qties' => (int)(Configuration::get('PS_DISPLAY_QTIES')),
            'display_ht' => !Tax::excludeTaxeOption(),
            'ecotax' => (!sizeof($this->errors) AND $this->product->ecotax > 0 ? Tools::convertPrice((float)($this->product->ecotax)) : 0),
            'currencySign' => $currency->sign,
            'currencyRate' => $currency->conversion_rate,
            'currencyFormat' => $currency->format,
            'currencyBlank' => $currency->blank,
            'jqZoomEnabled' => Configuration::get('PS_DISPLAY_JQZOOM')
        ));
                
                //add this to product stats
                Tools::captureActivity(PSTAT_VIEWS,$id_product);
    }
    
    public function getRandomCatProducts()
    {
        $leafCategory =  $this->product->getLeafCategory((int)(self::$cookie->id_lang));
        $categoryProducts = $leafCategory->getProducts((int)(self::$cookie->id_lang), 0, 15, NULL, NULL, false, true, true, 15, true, false);
        return $categoryProducts;
    }
    
    public function getRandomBrandProducts()
    {
        //see if the html fragment is in memcache
        $memcache = new Memcache();
        if($memcache->connect('127.0.0.1', 11211))
        {
            $brandProducts = $memcache->get('product-brand-products-'.$this->product->id);
            if($brandProducts) return $brandProducts;
            else 
            {
                $brandProducts = Manufacturer::getProducts($this->product->id_manufacturer, (int)(self::$cookie->id_lang), 0, 15, NULL, NULL, false, true, true, 15, false);
                $memcache->set('product-brand-products-'.$this->product->id, $brandProducts, false, 172800); //cache for 2 days
                return $brandProducts;
            }
        }
        else 
        {
            return Manufacturer::getProducts($this->product->id_manufacturer, (int)(self::$cookie->id_lang), 0, 15, NULL, NULL, false, true, true, 15, false);
        }
    }

    public function displayContent()
    {
        global $isBetaUser;
        parent::displayContent();
        
        if($this->is_saree)
            self::$smarty->display(_PS_THEME_DIR_.'product.tpl');
        else if($this->is_skd)
            self::$smarty->display(_PS_THEME_DIR_.'product-skd.tpl');
                else if($this->is_skd_rts) 
                    self::$smarty->display(_PS_THEME_DIR_.'product-skd-rts.tpl');
        else if($this->is_lehenga)
            self::$smarty->display(_PS_THEME_DIR_.'product-lehenga.tpl');
        else if($this->is_cholis)
            self::$smarty->display(_PS_THEME_DIR_.'product-choli.tpl');
        else if($this->is_giftcard)
            self::$smarty->display(_PS_THEME_DIR_.'product-giftcard.tpl');
        else if($this->is_jewelry)
            self::$smarty->display(_PS_THEME_DIR_.'product-jewelry.tpl');
        else if($this->is_kids)
            self::$smarty->display(_PS_THEME_DIR_.'product-kids.tpl');
        else if($this->is_men)
            self::$smarty->display(_PS_THEME_DIR_.'product-men.tpl');
        else if($this->is_handbag)
            self::$smarty->display(_PS_THEME_DIR_.'product-handbag.tpl');
        else
            self::$smarty->display(_PS_THEME_DIR_.'product-skd.tpl');
    }

    public function pictureUpload(Product $product, Cart $cart)
    {
        if (!$fieldIds = $this->product->getCustomizationFieldIds())
            return false;
        $authorizedFileFields = array();
        foreach ($fieldIds AS $fieldId)
            if ($fieldId['type'] == _CUSTOMIZE_FILE_)
                $authorizedFileFields[(int)($fieldId['id_customization_field'])] = 'file'.(int)($fieldId['id_customization_field']);
        $indexes = array_flip($authorizedFileFields);
        foreach ($_FILES AS $fieldName => $file)
            if (in_array($fieldName, $authorizedFileFields) AND isset($file['tmp_name']) AND !empty($file['tmp_name']))
            {
                $fileName = md5(uniqid(rand(), true));
                if ($error = checkImage($file, (int)(Configuration::get('PS_PRODUCT_PICTURE_MAX_SIZE'))))
                    $this->errors[] = $error;

                if ($error OR (!$tmpName = tempnam(_PS_TMP_IMG_DIR_, 'PS') OR !move_uploaded_file($file['tmp_name'], $tmpName)))
                    return false;
                /* Original file */
                elseif (!imageResize($tmpName, _PS_UPLOAD_DIR_.$fileName))
                    $this->errors[] = Tools::displayError('An error occurred during the image upload.');
                /* A smaller one */
                elseif (!imageResize($tmpName, _PS_UPLOAD_DIR_.$fileName.'_small', (int)(Configuration::get('PS_PRODUCT_PICTURE_WIDTH')), (int)(Configuration::get('PS_PRODUCT_PICTURE_HEIGHT'))))
                    $this->errors[] = Tools::displayError('An error occurred during the image upload.');
                elseif (!chmod(_PS_UPLOAD_DIR_.$fileName, 0777) OR !chmod(_PS_UPLOAD_DIR_.$fileName.'_small', 0777))
                    $this->errors[] = Tools::displayError('An error occurred during the image upload.');
                else
                    $cart->addPictureToProduct((int)($this->product->id), $indexes[$fieldName], $fileName);
                unlink($tmpName);
            }
        return true;
    }

    public function textRecord(Product $product, Cart $cart)
    {
        if (!$fieldIds = $this->product->getCustomizationFieldIds())
            return false;
        $authorizedTextFields = array();
        foreach ($fieldIds AS $fieldId)
            if ($fieldId['type'] == _CUSTOMIZE_TEXTFIELD_)
                $authorizedTextFields[(int)($fieldId['id_customization_field'])] = 'textField'.(int)($fieldId['id_customization_field']);
        $indexes = array_flip($authorizedTextFields);
        foreach ($_POST AS $fieldName => $value)
            if (in_array($fieldName, $authorizedTextFields) AND !empty($value))
            {
                if (!Validate::isMessage($value))
                    $this->errors[] = Tools::displayError('Invalid message');
                else
                    $cart->addTextFieldToProduct((int)($this->product->id), $indexes[$fieldName], $value);
            }
            elseif (in_array($fieldName, $authorizedTextFields) AND empty($value))
                $cart->deleteTextFieldFromProduct((int)($this->product->id), $indexes[$fieldName]);
    }

    public function formTargetFormat()
    {
        $customizationFormTarget = Tools::safeOutput(urldecode($_SERVER['REQUEST_URI']));
        foreach ($_GET AS $field => $value)
            if (strncmp($field, 'group_', 6) == 0)
                $customizationFormTarget = preg_replace('/&group_([[:digit:]]+)=([[:digit:]]+)/', '', $customizationFormTarget);
        if (isset($_POST['quantityBackup']))
            self::$smarty->assign('quantityBackup', (int)($_POST['quantityBackup']));
        self::$smarty->assign('customizationFormTarget', $customizationFormTarget);
    }

    public function formatQuantityDiscounts($specificPrices, $price, $taxRate)
    {
        foreach ($specificPrices AS $key => &$row)
        {
            $row['quantity'] = &$row['from_quantity'];
            if ($row['price'] != 0) // The price may be directly set
            {
                $cur_price = (Product::$_taxCalculationMethod == PS_TAX_EXC ? $row['price'] : $row['price'] * (1 + $taxRate / 100));

                if ($row['reduction_type'] == 'amount')
                {
                    $cur_price = Product::$_taxCalculationMethod == PS_TAX_INC ? $cur_price - $row['reduction'] : $cur_price - ($row['reduction'] / (1 + $taxRate / 100));
                } else {
                    $cur_price = $cur_price * ( 1  - ($row['reduction']));
                }

                $row['real_value'] = $price - $cur_price;
            }
            else
            {
                if ($row['reduction_type'] == 'amount')
                {
                    $row['real_value'] = Product::$_taxCalculationMethod == PS_TAX_INC ? $row['reduction'] : $row['reduction'] / (1 + $taxRate / 100);
                } else {
                    $row['real_value'] = $row['reduction'] * 100;
                }
            }
            $row['nextQuantity'] = (isset($specificPrices[$key + 1]) ? (int)($specificPrices[$key + 1]['from_quantity']) : -1);
        }
        return $specificPrices;
    }

    public function displayHeader()
    {
        global $link;
        
        $images = $this->product->getImages((int)(self::$cookie->id_lang));
        foreach ($images AS $k => $image)
        {
            if ($image['cover'])
            {
                $cover = $image;
                $cover['id_image'] = (Configuration::get('PS_LEGACY_IMAGES') ? ($this->product->id.'-'.$image['id_image']) : $image['id_image']);
            }
        }
        
        $pageTitle = 'Buy ' . $this->product->name . ' (CODE:' . $this->product->reference . ') online from India - IndusDiva.com';
        $pageDescription =  'Shop for original ' .$this->product->name. ' (CODE:' . $this->product->reference . ') online. 100% authentic. Free Shipping in India and across world (over $300)';
        
        $og_description = $pageDescription;
        $og_page_url = $this->product->getLink();
        $og_image_url = $link->getImageLink($this->product->link_rewrite, $cover['id_image'], 'large');
        $og_title = $this->product->name;
            
        self::$smarty->assign(array(
            'og_meta' => 1,
            'og_description' => $og_description,
            'og_page_url' => $og_page_url,
            'canonical_url' => $og_page_url,
            'og_image_url' => $og_image_url,
            'og_title' => $og_title,
                        'og_type' => 'indusdiva:product'
        ));
        
        self::$smarty->assign('meta_title', $pageTitle);
        self::$smarty->assign('meta_description', $pageDescription);
        
        parent::displayHeader();
    }
    
    public function getCustomerMeasurements($id_customer, $type)
    {
        if(!$id_customer) $id_customer = 0;
        if($type == 1)
        $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_blouse_measurements m 
                left join ps_customer_measurements mc on mc.id_measurement = m.id_measurement and coalesce(mc.is_deleted, 0) < 1
                where m.is_std = 1 OR (mc.type_measurement = 1 AND  mc.id_customer =" . $id_customer . ") order by m.is_std asc, m.id_measurement asc");
        else if($type == 2)
        $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_skirt_measurements m
                left join ps_customer_measurements mc on mc.id_measurement = m.id_measurement and coalesce(mc.is_deleted, 0) < 1
                where m.is_std = 1 OR (mc.type_measurement = 2 AND  mc.id_customer =" . $id_customer . ") order by m.is_std asc, m.id_measurement asc");
        else if($type == 3)
            $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_kurta_measurements m
                    left join ps_customer_measurements mc on mc.id_measurement = m.id_measurement and coalesce(mc.is_deleted, 0) < 1
                    where m.id_style = 1 AND (m.is_std = 1 OR (mc.type_measurement = 3 AND  mc.id_customer =" . $id_customer . ")) GROUP BY m.id_measurement order by m.is_std asc, m.id_measurement asc");
        else if($type == 4)
            $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_salwar_measurements m
                    left join ps_customer_measurements mc on mc.id_measurement = m.id_measurement and coalesce(mc.is_deleted, 0) < 1
                    where m.is_std = 1 OR (mc.type_measurement = 4 AND  mc.id_customer =" . $id_customer . ") order by m.is_std asc, m.id_measurement asc");
        else if($type == 5)
            $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_kurta_measurements m
                    left join ps_customer_measurements mc on mc.id_measurement = m.id_measurement and coalesce(mc.is_deleted, 0) < 1
                    where m.id_style = 2 AND (m.is_std = 1 OR (mc.type_measurement = 3 AND  mc.id_customer =" . $id_customer . ")) GROUP BY m.id_measurement order by m.is_std asc, m.id_measurement asc");
        return $res;
    }
}

