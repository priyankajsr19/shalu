<?php /* Smarty version Smarty-3.0.7, created on 2015-05-17 19:13:01
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/admin/featured.tpl" */ ?>
<?php /*%%SmartyHeaderCode:167801362155589ae5c71644-97442060%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43aacda7a493ab0834d8d951dbcbdea04365d993' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/admin/featured.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '167801362155589ae5c71644-97442060',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<fieldset style="margin-bottom:10px;">
	<legend><img src="../img/admin/tab-tools.gif" />Curated Products</legend>
	<form action="" method="POST" style="margin-bottom:15px;">
		Product IDs:
		<textarea name="product_ids" rows="4" cols="80"><?php echo $_smarty_tpl->getVariable('curated_product_ids')->value;?>
</textarea>
		<input type="hidden" name="group_id" value="1" />
		<input type="submit" value="Update" />
	</form>
	
	<div class="block-center" id="block-vbpoints">
		<?php if ($_smarty_tpl->getVariable('curated_products')->value){?>
		<table id="order-list" class="table" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="first_item" style="text-align:left;">Product ID</th>
					<th class="item" style="text-align:left;">Product</th>
					<th class="item" style="text-align:left;">Price</th>
				</tr>
			</thead>
			<tbody>
			<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('curated_products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
				<tr>
					<td class="history_date bold"><?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
</td>
					<td class="" style="text-align:left;">
                        <a href="?tab=AdminCatalog&id_product=<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
&updateproduct&token=<?php echo $_smarty_tpl->getVariable('productToken')->value;?>
">
                            <?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>

                        </a>
                    </td>
                    <td class="history_date bold"><?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>
</td>
				</tr>
			<?php }} ?>
			</tbody>
		</table>
		<?php }?>
	</div>
</fieldset>
