<?php
class ModalControllerCore extends FrontController
{
    public function __construct()
    {
        $this->auth = false;
        $this->php_self = 'modals.php';
        $this->ssl = true;
    
        parent::__construct();
    }
    
    public function preProcess()
    {
        if(Tools::getValue('modal'))
        {
            if(Tools::getValue('bs'))
                $this->getBlouseStylesModal();
            else if(Tools::getValue('iss'))
                $this->getInskirtStylesModal();
            else if(Tools::getValue('sts'))
                $this->getSKDTopStylesModal();
            else if(Tools::getValue('sbs'))
                $this->getSKDBottomStylesModal();
        }
    }
    
    private function getBlouseStylesModal(){
        if(Tools::getValue('lehenga'))
            $res = Db::getInstance()->ExecuteS("SELECT * FROM ps_styles WHERE style_type = 3 and id_style != 23");
        else {
            $id_product = Tools::getValue('id');
            $res = Db::getInstance()->Executes("SELECT s.* from ps_styles s join ps_product_style ps on s.id_style = ps.id_style and s.style_type = 1 and ps.id_product = $id_product");
            if( empty($res) )
                $res = Db::getInstance()->ExecuteS("SELECT * FROM ps_styles WHERE style_type = 1 and id_style != 68");
        }
        self::$smarty->assign("styles", $res);
        die(self::$smarty->display(_PS_THEME_DIR_.'blouse-styles-form.tpl'));
    }

    
    private function getInskirtStylesModal(){
        if(Tools::getValue('lehenga'))
            self::$smarty->assign('default_displayed', true);
        die(self::$smarty->display(_PS_THEME_DIR_.'petticoat-styles-form.tpl'));
    }
    
    private function getSKDTopStylesModal() {
        $id_product = Tools::getValue('id');
        $res = Db::getInstance()->ExecuteS("select s.id_style, s.style_type, s.style_name, s.style_image, s.description, s.style_image_small from ps_styles s inner join ps_product_style ps on ps.id_style = s.id_style where ps.id_product = $id_product and s.style_type = 4");
        self::$smarty->assign("styles",$res);
        die(self::$smarty->display(_PS_THEME_DIR_.'skd-styles-form.tpl'));  
    }

    private function getSKDBottomStylesModal() {
        $id_product = Tools::getValue('id');
        $res = Db::getInstance()->ExecuteS("select s.id_style, s.style_type, s.style_name, s.style_image, s.description, s.style_image_small from ps_styles s inner join ps_product_style ps on ps.id_style = s.id_style where ps.id_product = $id_product and s.style_type = 5");
        self::$smarty->assign("styles",$res);
        die(self::$smarty->display(_PS_THEME_DIR_.'skd-styles-form.tpl'));  
    }
}

