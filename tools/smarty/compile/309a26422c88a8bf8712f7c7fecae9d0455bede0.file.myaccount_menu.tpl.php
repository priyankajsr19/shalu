<?php /* Smarty version Smarty-3.0.7, created on 2015-05-21 18:45:27
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./myaccount_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1682190052555dda6f86c1f8-21364946%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '309a26422c88a8bf8712f7c7fecae9d0455bede0' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/./myaccount_menu.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1682190052555dda6f86c1f8-21364946',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="vtab-bar">
    <ul id="my_account_links">
        
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='identity'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
identity.php" title="<?php echo smartyTranslate(array('s'=>'Information'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Personal Info'),$_smarty_tpl);?>
</a></div>
            </li>
            
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='history'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
history.php" title="<?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
</a>
            </li>
            
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='addresses'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
addresses.php" title="<?php echo smartyTranslate(array('s'=>'My Address Book'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My Address Book'),$_smarty_tpl);?>
</a></div>
            </li>
            
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='measurements'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
measurements.php" title="<?php echo smartyTranslate(array('s'=>'My Measurements'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My Measurements'),$_smarty_tpl);?>
</a></div>
            </li>
            
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='wishlist'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
wishlist.php" title="<?php echo smartyTranslate(array('s'=>'My Wishlist'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My Wishlist'),$_smarty_tpl);?>
</a></div>
            </li>
            
            
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='vouchers'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
discount.php" title="<?php echo smartyTranslate(array('s'=>'Vouchers'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'My Vouchers'),$_smarty_tpl);?>
</a></div>
            </li>
            
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='points'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
idpoints.php" title="<?php echo smartyTranslate(array('s'=>'Indus Diva Coins'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Indusdiva Coins'),$_smarty_tpl);?>
</a></div>
            </li>
            
            <?php if ($_smarty_tpl->getVariable('selitem')->value=='referral'){?>
                <li class='selected'>
            <?php }else{ ?>
                <li>
            <?php }?>
                <div class="vtab-bar-link"><a href="<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
referral.php" title="<?php echo smartyTranslate(array('s'=>'Referrals'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Referrals'),$_smarty_tpl);?>
</a></div>
            </li>
    </ul>
</div>