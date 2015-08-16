<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 17:58:07
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_page_social_love.tpl" */ ?>
<?php /*%%SmartyHeaderCode:132119368055d081d75a4a47-88338604%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1fcec71e4ef3c4af20d53f8c5e4192835934352' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./product_page_social_love.tpl',
      1 => 1437833292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '132119368055d081d75a4a47-88338604',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/tools/smarty/plugins/modifier.escape.php';
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
