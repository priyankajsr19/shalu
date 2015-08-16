<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 12:59:55
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/modules/blocklayered/blocklayered.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5572697245562cf73b6e0f2-16148786%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3662ae38e6e22efbdd7e3f35170513f43d4bd24f' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/modules/blocklayered/blocklayered.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5572697245562cf73b6e0f2-16148786',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/tools/smarty/plugins/modifier.escape.php';
?>
<!-- Block layered navigation module -->
<?php if ($_smarty_tpl->getVariable('nbr_filterBlocks')->value!=0){?>
    <div id="layered_block_left" class="block">
        <script type="text/javascript">
            var srch_query = '<?php echo $_smarty_tpl->getVariable('search_query')->value;?>
';
            var brand = '<?php echo $_smarty_tpl->getVariable('brand')->value;?>
';
            var latest = '<?php echo $_smarty_tpl->getVariable('latest')->value;?>
';
            var sale = '<?php echo $_smarty_tpl->getVariable('sale')->value;?>
';
            var express_shipping = '<?php echo $_smarty_tpl->getVariable('express_shipping')->value;?>
';
            var cat_id = '<?php echo $_smarty_tpl->getVariable('cat_id')->value;?>
';
            var nextPage = <?php echo $_smarty_tpl->getVariable('nextPage')->value;?>
;
            <?php if (isset($_smarty_tpl->getVariable('parentID',null,true,false)->value)){?>
            var parentCategory = '<?php echo $_smarty_tpl->getVariable('parentID')->value;?>
';
            <?php }?>
        </script>
        <h4><?php echo smartyTranslate(array('s'=>'Shop By','mod'=>'blocklayered'),$_smarty_tpl);?>
</h4>
        <div class="block_content">
            <form action="#" id="layered_form">
                <div>
                    <?php if (isset($_smarty_tpl->getVariable('selected_filters',null,true,false)->value)&&$_smarty_tpl->getVariable('n_filters')->value>0||isset($_smarty_tpl->getVariable('id_category_layered',null,true,false)->value)&&$_smarty_tpl->getVariable('id_category_layered')->value!=1){?>
                        <div id="enabled_filters">
                            <span class="layered_subtitle" style="float: none;"><?php echo smartyTranslate(array('s'=>'Enabled filters:','mod'=>'blocklayered'),$_smarty_tpl);?>
</span>
                            <ul>
                                <?php  $_smarty_tpl->tpl_vars['filter_values'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['filter_type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('selected_filters')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['filter_values']->key => $_smarty_tpl->tpl_vars['filter_values']->value){
 $_smarty_tpl->tpl_vars['filter_type']->value = $_smarty_tpl->tpl_vars['filter_values']->key;
?>
                                    <?php if ($_smarty_tpl->tpl_vars['filter_type']->value!='category'){?>
                                        <?php  $_smarty_tpl->tpl_vars['filter_value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['filter_values']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['filter_value']->key => $_smarty_tpl->tpl_vars['filter_value']->value){
?>
                                            <li>
                                                <a class="lnk_removefilter" href="#" rel="layered_<?php echo $_smarty_tpl->tpl_vars['filter_type']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['filter_value']->value['id'];?>
" title="<?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'blocklayered'),$_smarty_tpl);?>
">x</a>
                                                <?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['filter_value']->value['name'],'html','UTF-8');?>

                                            </li>
                                        <?php }} ?>
                                    <?php }?>
                                <?php }} ?>
                                <?php if (isset($_smarty_tpl->getVariable('id_category_layered',null,true,false)->value)&&$_smarty_tpl->getVariable('id_category_layered')->value!=1){?>
                                    <li>
                                    <?php if (isset($_smarty_tpl->getVariable('isCategoryCloseable',null,true,false)->value)&&$_smarty_tpl->getVariable('isCategoryCloseable')->value==1){?><a class="lnk_removeCategory" id="selected_category" href="#" title="<?php echo smartyTranslate(array('s'=>'Cancel','mod'=>'blocklayered'),$_smarty_tpl);?>
">x</a><?php }?>
                                    Category: <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('name_category_layered')->value,'html','UTF-8');?>

                                </li>
                            <?php }?>
                        </ul>
                    </div>

                <?php }?>

                <?php  $_smarty_tpl->tpl_vars['filter'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('filters')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['filter']->key => $_smarty_tpl->tpl_vars['filter']->value){
?>
                    <?php if (isset($_smarty_tpl->tpl_vars['filter']->value['values'])){?>
                        <div class="filter-group">
                            <span class="layered_subtitle"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['filter']->value['name'],'html','UTF-8');?>
</span>
                            <span class="layered_close"><a href="#" rel="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
">v</a></span>
                            <div class="clear"></div>
                            <ul id="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
">
                                <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['filter']->value['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['id_value']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                                    <?php if ($_smarty_tpl->tpl_vars['value']->value['nbr']){?>
                                        <li<?php if ($_smarty_tpl->getVariable('layered_use_checkboxes')->value){?> class="nomargin clickable"<?php }?>>
                                            <?php if (isset($_smarty_tpl->tpl_vars['filter']->value['is_category'])&&$_smarty_tpl->tpl_vars['filter']->value['is_category']){?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['value']->value['checked'])&&$_smarty_tpl->tpl_vars['value']->value['checked']){?><input type="hidden" name="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
" id="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
<?php if ($_smarty_tpl->tpl_vars['id_value']->value){?>_<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
<?php }?>" value="<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
" /><?php }?>
                                    <?php }else{ ?>
                                        <?php if ($_smarty_tpl->getVariable('layered_use_checkboxes')->value){?>
                                            <input type="checkbox"
                                                   class="checkbox"
                                                   name="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
"
                                                   id="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
<?php if ($_smarty_tpl->tpl_vars['id_value']->value){?>_<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
<?php }?>"
                                                   value="<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
"
                                            <?php if (isset($_smarty_tpl->tpl_vars['value']->value['checked'])){?> checked="checked"<?php }?>
                                        <?php if (!$_smarty_tpl->tpl_vars['value']->value['nbr']){?> disabled="disabled"<?php }?> />
                                <?php }?>
                            <?php }?>
                            <label for="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
"<?php if (isset($_smarty_tpl->tpl_vars['filter']->value['is_category'])&&$_smarty_tpl->tpl_vars['filter']->value['is_category']){?>
                                   name="layered_<?php echo $_smarty_tpl->tpl_vars['filter']->value['type'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
"
                                   class="category" rel="<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
"<?php }?>><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['value']->value['name'],'html','UTF-8');?>

                                <span> (<?php echo $_smarty_tpl->tpl_vars['value']->value['nbr'];?>
)</span>
                            </label>
                        </li>
                    <?php }?>
                <?php }} ?>
            </ul>
        </div>
    <?php }?>
<?php }} ?>
</div>
<input id="id_category_layered" type="hidden" name="id_category_layered" value="<?php echo $_smarty_tpl->getVariable('id_category_layered')->value;?>
" />
<input id="orderby" type="hidden" name="orderby" value="new" />
<input id="orderway" type="hidden" name="orderway" value="desc" />
<?php  $_smarty_tpl->tpl_vars['filter'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('filters')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['filter']->key => $_smarty_tpl->tpl_vars['filter']->value){
?>
    <?php if ($_smarty_tpl->tpl_vars['filter']->value['type']=='id_attribute_group'&&isset($_smarty_tpl->tpl_vars['filter']->value['is_color_group'])&&$_smarty_tpl->tpl_vars['filter']->value['is_color_group']){?>
        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['id_value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['filter']->value['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['id_value']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
            <?php if (isset($_smarty_tpl->tpl_vars['value']->value['checked'])){?>
                <input type="hidden" name="layered_id_attribute_group_<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['id_value']->value;?>
" />
            <?php }?>
        <?php }} ?>
    <?php }?>
<?php }} ?>
</form>
</div>
<div id="layered_ajax_loader" style="display: none;">
    <p style="margin: 20px 0; text-align: center;"><img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
loader.gif" alt="" /><br /><?php echo smartyTranslate(array('s'=>'Loading...','mod'=>'blocklayered'),$_smarty_tpl);?>
</p>
</div>
</div>
<div id="top-marker" style="height:1px; width:100%;"></div>
<div id="go-to-top" style="color:#ffffff; background: none repeat scroll 0 0 #A41E21;">
    Go To Top
</div>
<?php }?>
<!-- /Block layered navigation module -->
