<?php /* Smarty version Smarty-3.0.7, created on 2015-07-25 01:40:21
         compiled from "/var/www/html/indusdiva/themes/violettheme/404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:88473520955b29bad91f7d0-39960100%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be403c3ceb3624f6006e10668886ca6741c6b9d0' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/404.tpl',
      1 => 1436950698,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88473520955b29bad91f7d0-39960100',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<h1><?php echo smartyTranslate(array('s'=>'Page not available'),$_smarty_tpl);?>
</h1>

<p class="error">
	<img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/error.gif" alt="<?php echo smartyTranslate(array('s'=>'Error'),$_smarty_tpl);?>
" class="middle" />
	<?php echo smartyTranslate(array('s'=>'We\'re sorry, but the Web address you entered is no longer available'),$_smarty_tpl);?>

</p>

<h3><?php echo smartyTranslate(array('s'=>'To find a product, please type its name in the field below'),$_smarty_tpl);?>
</h3>

<form action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('search.php');?>
" method="post" class="std">
	<fieldset>
		<p>
			<label for="search"><?php echo smartyTranslate(array('s'=>'Search our product catalog:'),$_smarty_tpl);?>
</label>
			<input id="search_query" name="search_query" type="text" />
			<input type="submit" name="Submit" value="OK" class="button_small" />
		</p>
	</fieldset>
</form>

<p><a href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/home.gif" alt="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
" class="icon" /></a><a href="<?php echo $_smarty_tpl->getVariable('base_dir')->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
</a></p>
