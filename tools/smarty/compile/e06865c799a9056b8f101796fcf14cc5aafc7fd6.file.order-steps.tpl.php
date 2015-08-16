<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 15:44:34
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./order-steps.tpl" */ ?>
<?php /*%%SmartyHeaderCode:72228481955d0628aed3ce8-69508665%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e06865c799a9056b8f101796fcf14cc5aafc7fd6' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/./order-steps.tpl',
      1 => 1437833306,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72228481955d0628aed3ce8-69508665',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<?php if (!$_smarty_tpl->getVariable('opc')->value){?>
<!-- Steps -->
<ul class="step" id="order_step">
	<li class="<?php if ($_smarty_tpl->getVariable('current_step')->value=='address'){?>step_current<?php }else{ ?><?php if ($_smarty_tpl->getVariable('current_step')->value=='billing'||$_smarty_tpl->getVariable('current_step')->value=='payment'||$_smarty_tpl->getVariable('current_step')->value=='shipping'){?>step_done<?php }else{ ?>step_todo<?php }?><?php }?>">
		<?php if ($_smarty_tpl->getVariable('current_step')->value=='payment'||$_smarty_tpl->getVariable('current_step')->value=='billing'){?>
			<a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=1<?php if (isset($_smarty_tpl->getVariable('back',null,true,false)->value)&&$_smarty_tpl->getVariable('back')->value){?>&amp;back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
<?php }?>">
				<span class="step-no">1</span><span><?php echo smartyTranslate(array('s'=>'Shipping Address'),$_smarty_tpl);?>
</span>
			</a>
		<?php }else{ ?>
		<span class="step-no">1</span>
		<span><?php echo smartyTranslate(array('s'=>'Shipping Address'),$_smarty_tpl);?>
</span>
		<?php }?>
	</li>
	<li class="<?php if ($_smarty_tpl->getVariable('current_step')->value=='billing'){?>step_current<?php }else{ ?><?php if ($_smarty_tpl->getVariable('current_step')->value=='payment'){?>step_done<?php }else{ ?>step_todo<?php }?><?php }?>">
		<div class="<?php if ($_smarty_tpl->getVariable('current_step')->value=='address'){?>step_arrow_selected<?php }else{ ?>step_arrow<?php }?>"></div>
		<?php if ($_smarty_tpl->getVariable('current_step')->value=='payment'){?>
			<a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('order.php',true);?>
?step=2<?php if (isset($_smarty_tpl->getVariable('back',null,true,false)->value)&&$_smarty_tpl->getVariable('back')->value){?>&amp;back=<?php echo $_smarty_tpl->getVariable('back')->value;?>
<?php }?>">
				<span class="step-no">2</span><span><?php echo smartyTranslate(array('s'=>'Billing Address'),$_smarty_tpl);?>
</span>
			</a>
		<?php }else{ ?>
		<span class="step-no">2</span>
		<span><?php echo smartyTranslate(array('s'=>'Billing Address'),$_smarty_tpl);?>
</span>
		<?php }?>
	</li>
	<li class="<?php if ($_smarty_tpl->getVariable('current_step')->value=='payment'){?>step_current<?php }else{ ?>step_todo<?php }?>">
		<div class="<?php if ($_smarty_tpl->getVariable('current_step')->value=='billing'){?>step_arrow_selected<?php }else{ ?>step_arrow<?php }?>"></div>
		<span class="step-no">3</span><span><?php echo smartyTranslate(array('s'=>'Payment'),$_smarty_tpl);?>
</span>
	</li>
	<li id="step_end" class="<?php if ($_smarty_tpl->getVariable('current_step')->value=='done'){?>step_current<?php }else{ ?>step_todo<?php }?>">
		<div class="<?php if ($_smarty_tpl->getVariable('current_step')->value=='payment'){?>step_arrow_selected<?php }else{ ?>step_arrow<?php }?>"></div>
		<span class="step-no">4</span><span><?php echo smartyTranslate(array('s'=>'Done'),$_smarty_tpl);?>
</span>
	</li>
</ul>
<!-- /Steps -->
<?php }?>