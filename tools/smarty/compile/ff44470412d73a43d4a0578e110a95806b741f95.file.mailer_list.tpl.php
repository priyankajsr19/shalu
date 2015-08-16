<?php /* Smarty version Smarty-3.0.7, created on 2015-08-07 14:16:32
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/admin/mailer_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25230979655c470684c1a52-83217587%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff44470412d73a43d4a0578e110a95806b741f95' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/admin/mailer_list.tpl',
      1 => 1437833335,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25230979655c470684c1a52-83217587',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div style="background-color: #ffffff !important; margin: 0; padding: 0">
    <div class="block-center" id="block-wishlist_items">
        <?php if ($_smarty_tpl->getVariable('campaigns')->value&&count($_smarty_tpl->getVariable('campaigns')->value)){?>
        <table id="campaigns-list" class="table" cellspacing="0" cellpadding="0" style="width:75%">
                <thead>
                        <tr>
                                <th class="first_item" style="text-align:left;">Campaign Name</th>
                                <th class="item" style="text-align:left;">Template</th>
                                <th class="item" style="text-align:right;">Date Added</th>
                                <th class="item" style="text-align:right;">Scheduled Time</th>
                                <th class="item" style="text-align:right;">Created By</th>
                                
                                <th class="last_item" style="text-align:right;">Status</th>
                        </tr>
                </thead>
                <tbody>
                <?php  $_smarty_tpl->tpl_vars['campaign'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('campaigns')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['campaign']->key => $_smarty_tpl->tpl_vars['campaign']->value){
?>
                        <tr>
                                <td class="" style="text-align:left;"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['campaign_name'];?>
</td>
                                <td class="" style="text-align:left;"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['template'];?>
</td>
                                <td class="" style="text-align:right;"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['date_add'];?>
</td>
                                <td class="" style="text-align:right;"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['scheduled_time'];?>
</td>
                                <td class="" style="text-align:right;"><?php echo $_smarty_tpl->tpl_vars['campaign']->value['created_by'];?>
</td>
                                <td class="" style="text-align:right;">
                                    <?php if ($_smarty_tpl->tpl_vars['campaign']->value['status']==0){?>
                                        Not Scheduled
                                    <?php }elseif($_smarty_tpl->tpl_vars['campaign']->value['status']==1){?>
                                        Scheduled
                                    <?php }elseif($_smarty_tpl->tpl_vars['campaign']->value['status']==99){?>
                                        Running
                                    <?php }elseif($_smarty_tpl->tpl_vars['campaign']->value['status']==2){?>
                                        Completed
                                    <?php }?>
                                </td>
                        </tr>
                <?php }} ?>
                </tbody>
        </table>
        <?php }else{ ?>
                <span>No Campaigns</span>
        <?php }?>
    </div>
</div>