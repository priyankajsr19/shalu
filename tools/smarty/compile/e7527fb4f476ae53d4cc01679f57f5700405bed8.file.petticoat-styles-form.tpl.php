<?php /* Smarty version Smarty-3.0.7, created on 2015-06-18 12:02:57
         compiled from "/var/www/html/indusdiva/themes/violettheme/petticoat-styles-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:498921669558266198b2394-02253393%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e7527fb4f476ae53d4cc01679f57f5700405bed8' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/petticoat-styles-form.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '498921669558266198b2394-02253393',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div rel="text-headline" style="background:#F4F2F3">
	<div class="panel" id="panel"  style="float:left;margin:0px 10px 0px;border:1px dashed #cacaca;width:<?php if (isset($_smarty_tpl->getVariable('default_displayed',null,true,false)->value)&&$_smarty_tpl->getVariable('default_displayed')->value){?>830<?php }else{ ?>530<?php }?>px">
		<div style="border-bottom:1px dashed #cacaca">
			<h1>CLICK TO SELECT A STYLE</h1>
		</div>
		<div style="position:relative">
		    <?php if (isset($_smarty_tpl->getVariable('default_displayed',null,true,false)->value)&&$_smarty_tpl->getVariable('default_displayed')->value){?>
		    <div class="style-select" rel="0" style="float:left;position:relative;margin:20px" data-image="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/0-small.png">
				<div class="style-name">As Shown</div>
				<div><img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/0-medium.png" width="200" height="383"></div>
				<div style="line-height:1.2em; text-align:left;">As shown in the product image</div>
			</div>
			<?php }?>
			<div class="style-select" rel="13" style="float:left;position:relative;margin:20px" data-image="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/13-small.png">
				<div class="style-name">A-Line</div>
				<div><img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/13-medium.png" width="200" height="383"></div>
				<div style="line-height:1.2em; text-align:left;">These classic skirts are comfortable to wear and carry on daily basis.</div>
			</div>
			<div class="style-select" rel="14" style="float:left;position:relative; margin:20px" data-image="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/14-small.png">
				<div class="style-name">Fish Cut</div>
				<div><img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
styles/14-medium.png" width="173" height="383"></div>
				<div style="line-height:1.2em; text-align:left;">These are body hugging skirts for evening and party wear.</div>
			</div>
		</div>
	</div>	
</div>