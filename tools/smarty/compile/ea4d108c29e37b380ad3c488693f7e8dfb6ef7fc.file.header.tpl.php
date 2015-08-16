<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 17:58:57
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173332965455d082095f8055-85556646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea4d108c29e37b380ad3c488693f7e8dfb6ef7fc' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/header.tpl',
      1 => 1438604165,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173332965455d082095f8055-85556646',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/tools/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $_smarty_tpl->getVariable('lang_iso')->value;?>
">
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# indusdiva: http://ogp.me/ns/fb/indusdiva#">
        <title><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_title')->value,'htmlall','UTF-8');?>
</title>
        <?php if (isset($_smarty_tpl->getVariable('meta_description',null,true,false)->value)&&$_smarty_tpl->getVariable('meta_description')->value){?>
            <meta name="description" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_description')->value,'html','UTF-8');?>
" />
        <?php }?>
        <?php if (isset($_smarty_tpl->getVariable('meta_keywords',null,true,false)->value)&&$_smarty_tpl->getVariable('meta_keywords')->value){?>
            <meta name="keywords" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_keywords')->value,'html','UTF-8');?>
" />
        <?php }?>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <?php if (isset($_smarty_tpl->getVariable('og_meta',null,true,false)->value)&&$_smarty_tpl->getVariable('og_meta')->value){?>
            <meta property="fb:app_id" content="285166361588635" /> 
            <meta property="og:title" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('og_title')->value,'htmlall','UTF-8');?>
"/>
            <meta property="og:type" content="<?php echo smarty_modifier_escape((($tmp = @$_smarty_tpl->getVariable('og_type')->value)===null||$tmp==='' ? 'product' : $tmp),'htmlall','UTF-8');?>
"/>
            <meta property="og:url" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('og_page_url')->value,'htmlall','UTF-8');?>
"/>
            <meta property="og:image" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('og_image_url')->value,'htmlall','UTF-8');?>
"/>
            <meta property="og:description" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('og_description')->value,'htmlall','UTF-8');?>
"/>
        <?php }else{ ?>
            <meta property="og:title" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_title')->value,'htmlall','UTF-8');?>
"/>
            <meta property="og:type" content="website"/>
            <meta property="og:image" content="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
img/logo.jpg"/>
            <meta property="og:description" content="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('meta_description')->value,'html','UTF-8');?>
"/>
        <?php }?>
        <?php if (isset($_smarty_tpl->getVariable('canonical_url',null,true,false)->value)){?>
            <link rel="canonical" href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('canonical_url')->value,'htmlall','UTF-8');?>
" />
        <?php }?>
        <?php if (isset($_smarty_tpl->getVariable('p',null,true,false)->value)&&$_smarty_tpl->getVariable('p')->value){?>
            <?php if ($_smarty_tpl->getVariable('pages_nb')->value>1&&$_smarty_tpl->getVariable('p')->value!=$_smarty_tpl->getVariable('pages_nb')->value){?>
                <?php $_smarty_tpl->tpl_vars['p_next'] = new Smarty_variable($_smarty_tpl->getVariable('p')->value+1, null, null);?>
                <link rel="next" href="<?php echo $_smarty_tpl->getVariable('paginationBaseUrl')->value;?>
<?php echo $_smarty_tpl->getVariable('link')->value->goPage($_smarty_tpl->getVariable('requestPage')->value,$_smarty_tpl->getVariable('p_next')->value);?>
" />
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('p')->value!=1){?>
                <?php $_smarty_tpl->tpl_vars['p_previous'] = new Smarty_variable($_smarty_tpl->getVariable('p')->value-1, null, null);?>
                <link rel="prev" href="<?php echo $_smarty_tpl->getVariable('paginationBaseUrl')->value;?>
<?php echo $_smarty_tpl->getVariable('link')->value->goPage($_smarty_tpl->getVariable('requestPage')->value,$_smarty_tpl->getVariable('p_previous')->value);?>
" />
            <?php }?>
        <?php }?>
        <meta property="og:site_name" content="indusdiva.com"/>

        <meta name="robots" content="<?php if (isset($_smarty_tpl->getVariable('nobots',null,true,false)->value)){?>no<?php }?>index,follow" />
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
favicon.ico?<?php echo $_smarty_tpl->getVariable('img_update_time')->value;?>
" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
favicon.ico?<?php echo $_smarty_tpl->getVariable('img_update_time')->value;?>
" />
        <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css' />

        <script type="text/javascript">
            var baseDir = '<?php echo $_smarty_tpl->getVariable('content_dir')->value;?>
';
            var static_token = '<?php echo $_smarty_tpl->getVariable('static_token')->value;?>
';
            var token = '<?php echo $_smarty_tpl->getVariable('token')->value;?>
';
            var priceDisplayPrecision = <?php echo $_smarty_tpl->getVariable('priceDisplayPrecision')->value*$_smarty_tpl->getVariable('currency')->value->decimals;?>
;
            var priceDisplayMethod = <?php echo $_smarty_tpl->getVariable('priceDisplay')->value;?>
;
            var roundMode = <?php echo $_smarty_tpl->getVariable('roundMode')->value;?>
;
            var requestURI = '<?php echo $_smarty_tpl->getVariable('request_uri')->value;?>
';
        </script>
        <?php if (isset($_smarty_tpl->getVariable('css_files',null,true,false)->value)){?>
            <?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['css_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('css_files')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value){
 $_smarty_tpl->tpl_vars['css_uri']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
                <link href="<?php echo $_smarty_tpl->tpl_vars['css_uri']->value;?>
" rel="stylesheet" type="text/css" media="<?php echo $_smarty_tpl->tpl_vars['media']->value;?>
" />
            <?php }} ?>
        <?php }?>
        <?php if (isset($_smarty_tpl->getVariable('js_files',null,true,false)->value)){?>
            <?php  $_smarty_tpl->tpl_vars['js_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('js_files')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->key => $_smarty_tpl->tpl_vars['js_uri']->value){
?>
                <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_uri']->value;?>
"></script>
            <?php }} ?>
        <?php }?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.login_link').fancybox({
                    autoSize: true
                });
                $('.shipping_link').fancybox({
                    autoSize: true
                });
            });
            $(document).ajaxSend(function(event, xhr, settings) {
                settings.xhrFields = {
                    withCredentials: true
                };
            });
        </script>
        <?php echo $_smarty_tpl->getVariable('HOOK_HEADER')->value;?>

    </head>
    <?php if ($_smarty_tpl->getVariable('page_name')->value=='helpanorphan'){?>
       <body id="helpanorphan" style="background:url('http://cdn.indusdiva.com/img/dec25bg.png') repeat scroll left top">
    <?php }else{ ?>
        <body <?php if ($_smarty_tpl->getVariable('page_name')->value){?>id="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('page_name')->value,'htmlall','UTF-8');?>
"<?php }?>>
    <?php }?>
        <?php if (!$_smarty_tpl->getVariable('content_only')->value){?>
            <?php if (isset($_smarty_tpl->getVariable('restricted_country_mode',null,true,false)->value)&&$_smarty_tpl->getVariable('restricted_country_mode')->value){?>
                <div id="restricted-country">
                    <p><?php echo smartyTranslate(array('s'=>'You cannot place a new order from your country.'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->getVariable('geolocation_country')->value;?>
</span></p>
                </div>
            <?php }?>
            <div id="header" style="width:100%;">
                <div style="background:#ededed; border-bottom:1px solid #c9c9c9;height:25px;">
                    <div id="header_user_info" class="clearfix" style="width:980px; margin:auto;color:#000000;">
                        <div style="position:relative; display: block; text-align: left; width: 300px;float:left">care@indusdiva.com | +91-80-67309079 (24x7)</div>
                        <div style="position:relative; display: block; text-align: right; width: 660px; float:right">
                            <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./currency-change.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>    
                            <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                                <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('idpoints.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'My ClubDiva Coins'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->getVariable('balance_points')->value;?>
 Coins</a> 
                                |
                                <a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('history.php',true);?>
" title="<?php echo smartyTranslate(array('s'=>'Your Account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My Account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</a> 
                                | 
                                <span><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('cookie')->value->customer_firstname,'htmlall','UTF-8');?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('cookie')->value->customer_lastname,'htmlall','UTF-8');?>
</span>
                                (<a rel="nofollow" href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('index.php');?>
?mylogout" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Log out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</a>)

                            <?php }else{ ?>
                                <?php if ($_smarty_tpl->getVariable('page_name')->value!='authentication'){?>
                                    <a rel="nofollow" id="login_link" class="fancybox login_link" href="#login_modal_panel"><?php echo smartyTranslate(array('s'=>'Log in | Signup','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</a>
                                <?php }?>
                            <?php }?>
                        </div>
                    </div>
                </div>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./currency-menu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>    
                <div style="width:980px;margin:auto;" class="clearfix">
                    <div id="header_right" class="clearfix">
                        <div id="header_logo" style="padding-top:20px;">
                            <a  href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('shop_name')->value,'htmlall','UTF-8');?>
" id="logo_link" style="background: url(http://cdn.indusdiva.com/img/divalogo.png) 0px 0px no-repeat scroll transparent;">
                            </a>
                        </div>
                        <?php echo $_smarty_tpl->getVariable('HOOK_TOP')->value;?>

                    </div>
                </div>
                <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./categoriesbar.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
                <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./bannerblock.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
            </div>
            <div id="page" style="clear:both;padding-top:10px;" clear="clearfix">

                <!-- Header -->


                <div id="columns">
                    <?php if (isset($_smarty_tpl->getVariable('bannername',null,true,false)->value)){?>
                        <a href="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('link')->value->getmanufacturerLink($_smarty_tpl->getVariable('manufacturer')->value->id,$_smarty_tpl->getVariable('manufacturer')->value->link_rewrite),'htmlall','UTF-8');?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('manufacturer')->value->name,'htmlall','UTF-8');?>
 products">
                            <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
brands/<?php echo $_smarty_tpl->getVariable('bannername')->value;?>
" width="980"  height="169" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('manufacturer')->value->name,'htmlall','UTF-8');?>
" />
                        </a>
                    <?php }?>
                    <!-- Left -->
                    <div id="left_column" class="column">
                        <?php echo $_smarty_tpl->getVariable('HOOK_LEFT_COLUMN')->value;?>

                    </div>

                    <!-- Center -->
                    <div id="center_column">
                    <?php }?>
