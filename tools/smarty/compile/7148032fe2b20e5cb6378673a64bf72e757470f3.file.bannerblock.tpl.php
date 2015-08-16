<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:02:16
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./bannerblock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19973821985562de102dd131-82075701%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7148032fe2b20e5cb6378673a64bf72e757470f3' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./bannerblock.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19973821985562de102dd131-82075701',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('page_name')->value=='index'){?>

<script>

$(function() {
	$('.lazy2').jail({
		timeout:2000
	});
	
	window.setTimeout(function(){
	$(".rslides").responsiveSlides({
		  auto: true,             // Boolean: Animate automatically, true or false
		  speed: 500,            // Integer: Speed of the transition, in milliseconds
		  timeout: 1500,          // Integer: Time between slide transitions, in milliseconds
		  pager: false,           // Boolean: Show pager, true or false
		  nav: true,             // Boolean: Show navigation, true or false
		  random: false,          // Boolean: Randomize the order of the slides, true or false
		  pause: true,           // Boolean: Pause on hover, true or false
		  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
		  prevText: "Previous",   // String: Text for the "previous" button
		  nextText: "Next",       // String: Text for the "next" button
		  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
		  controls: "",           // Selector: Where controls should be appended to, default is after the 'ul'
		  namespace: "rslides",   // String: change the default namespace used
		  before: function(){},   // Function: Before callback
		  after: function(){}     // Function: After callback
		});}, 3000);
});
</script>



<?php $_smarty_tpl->tpl_vars['counter'] = new Smarty_variable(1, null, null);?>
<ul class="rslides">
<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['banner']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('home_banners')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['name'] = 'banner';
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['banner']['total']);
?>
        <?php if ($_smarty_tpl->getVariable('counter')->value==1){?>
                <li>
                        <a class="banner_big" href="<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['url'];?>
">
                                <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['image_path'];?>
" alt="<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['title'];?>
"  style="max-width:100%; width:100% auto;"/>
                        </a>
                </li>
        <?php }else{ ?>
                <li>
                        <a class="banner_big" href="<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['url'];?>
">
                                <img data-href="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['image_path'];?>
" alt="<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['title'];?>
" class="lazy2" style="max-width:100%; width:100% auto;"/>
                                <noscript>
                                	<img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['image_path'];?>
" alt="<?php echo $_smarty_tpl->getVariable('home_banners')->value[$_smarty_tpl->getVariable('smarty')->value['section']['banner']['index']]['title'];?>
"  style="max-width:100%; width:100% auto;"/>
                                </noscript>
                        </a>
                </li>
        <?php }?>
        <?php $_smarty_tpl->tpl_vars['counter'] = new Smarty_variable($_smarty_tpl->getVariable('counter')->value+1, null, null);?>
<?php endfor; endif; ?>
</ul>

<!-- /MODULE Block banners -->
<?php }?>
