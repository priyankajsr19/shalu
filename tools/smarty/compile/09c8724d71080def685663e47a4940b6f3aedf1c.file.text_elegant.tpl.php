<?php /* Smarty version Smarty-3.0.7, created on 2015-08-12 19:33:09
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/text_elegant.tpl" */ ?>
<?php /*%%SmartyHeaderCode:72262377855cb521d4a1d24-17958196%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09c8724d71080def685663e47a4940b6f3aedf1c' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/text_elegant.tpl',
      1 => 1437833295,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72262377855cb521d4a1d24-17958196',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
-- This mail is best viewed HTML client--
<?php echo $_smarty_tpl->getVariable('subject')->value;?>

<?php echo $_smarty_tpl->getVariable('lp_name')->value;?>
 - US $<?php echo $_smarty_tpl->getVariable('lp_price')->value;?>

<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(-1, null, null);?>
<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['name'] = 'sloop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['loop'] = is_array($_loop=8) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sloop']['total']);
?>
<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
<?php echo $_smarty_tpl->getVariable('otherp_info')->value[$_smarty_tpl->getVariable('i')->value]['name'];?>
 - US $<?php echo $_smarty_tpl->getVariable('otherp_info')->value[$_smarty_tpl->getVariable('i')->value]['price'];?>

<?php endfor; endif; ?>
Click here (<?php echo $_smarty_tpl->getVariable('a_utm_link')->value;?>
} to Shop Now
Unsubscribe link : www.indusdiva.com/newsletter.php?unsub_key=<?php echo $_smarty_tpl->getVariable('unsub_key')->value;?>

-- This mail is best viewed HTML client--
