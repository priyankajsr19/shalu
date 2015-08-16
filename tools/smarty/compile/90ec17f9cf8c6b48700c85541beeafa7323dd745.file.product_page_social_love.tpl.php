<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 19:49:36
         compiled from "/var/www/html/indusdiva/themes/violettheme/./product_page_social_love.tpl" */ ?>
<?php /*%%SmartyHeaderCode:106702036155b39af8f2c793-85753165%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90ec17f9cf8c6b48700c85541beeafa7323dd745' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/./product_page_social_love.tpl',
      1 => 1436950700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '106702036155b39af8f2c793-85753165',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/var/www/html/indusdiva/tools/smarty/plugins/modifier.escape.php';
?>	<div id="social-love" style="vertical-align:top;height:24px;">
                <a href="http://pinterest.com/pin/create/button/?url=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('canonical_url')->value,'url');?>
&media=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('og_image_url')->value,'url');?>
&description=<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'url');?>
" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
                <div style="display:inline-block;vertical-align:top">
                    <div class="g-plusone" data-annotation="none" data-callback="plusClick"></div>
                    
                        <script type="text/javascript">
                (function() {
                    var po = document.createElement('script');
                    po.type = 'text/javascript';
                    po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(po, s);
                })();
                        </script>
                    
                </div>
                <div style="display:inline-block;vertical-align:top;padding:0px 5px;">
                    <div class="fb-like" data-send="false" data-width="300" data-show-faces="false" data-font="arial"></div>
                </div>
            </div>
