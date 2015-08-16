<?php /* Smarty version Smarty-3.0.7, created on 2015-07-21 12:49:36
         compiled from "/var/www/html/indusdiva/themes/violettheme/./order-steps.tpl" */ ?>
<?php /*%%SmartyHeaderCode:207561653455adf288566bb8-07020339%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4fa0013330d0a2fb45712d37293b330518d5468d' => 
    array (
      0 => '/var/www/html/indusdiva/themes/violettheme/./order-steps.tpl',
      1 => 1436950699,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '207561653455adf288566bb8-07020339',
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