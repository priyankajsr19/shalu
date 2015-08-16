<?php /* Smarty version Smarty-3.0.7, created on 2015-08-06 16:11:52
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/common-measurement-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:98958960455c339f05bad36-46641347%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '652b16e4d7f16b2db648deceaabf9793abfe9997' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/common-measurement-form.tpl',
      1 => 1437833301,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98958960455c339f05bad36-46641347',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="sz_popup">
    <ul class="tabs clearfix">
        <li id="lnk_this" class="active">SIZE CHART</li>
        <li id="lnk_intl" class="inactive">SIZE GUIDE</li>
    </ul>
    <div class="sz_popup_wrap" id="intl_size_chart" style="display:none">
        <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./intl_size_map.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    </div>
    <div class="sz_popup_wrap" id="this_size_chart" style="display:block">
        <div style="text-transform:uppercase">
            <?php if (isset($_smarty_tpl->getVariable('measurement',null,true,false)->value)){?>
                <h1>EDIT MEASUREMENT: <?php echo $_smarty_tpl->getVariable('measurement')->value['name_measurement'];?>
</h1>
            <?php }else{ ?>
                <h1><?php echo $_smarty_tpl->getVariable('chart_title')->value;?>
</h1>
            <?php }?>
        </div>
        <div id="measurement_error" style="display:none">
            <span style="color:red;font-size:18px;">Something went wrong! Could not save measurement.</span>
        </div>
        <div id="measurement_errors" class="error_container">
            <ol style="list-style-type:none">
            </ol>
        </div>
        <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['name'] = 'instr';
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('spl_instr')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total']);
?>
            <p style="color:#999999"><?php echo $_smarty_tpl->getVariable('spl_instr')->value[$_smarty_tpl->getVariable('smarty')->value['section']['instr']['index']];?>
</p>
        <?php endfor; endif; ?>
        
        <form action="measurement.php" method="post" id="measurement_form" style="padding:10px;">
            <table width="500px" cellspacing="0" style="float:left">
            <tbody>
                <?php $_smarty_tpl->tpl_vars["row"] = new Smarty_variable(0, null, null);?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']["size"]);
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['name'] = "size";
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['loop'] = is_array($_loop=$_smarty_tpl->getVariable('size_data')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']["size"]['total']);
?>
                    <?php if ($_smarty_tpl->getVariable('row')->value==0){?>
                        <tr style="background:#DFDFDF">
                            <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable(0, null, null);?>
                            <?php  $_smarty_tpl->tpl_vars['sz'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('size_data')->value[$_smarty_tpl->getVariable('smarty')->value['section']['size']['index']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sz']->key => $_smarty_tpl->tpl_vars['sz']->value){
?>
                                <?php if ($_smarty_tpl->getVariable('col')->value==0){?>
                                    <td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_left"><?php echo $_smarty_tpl->tpl_vars['sz']->value;?>
</td>
                                    <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable($_smarty_tpl->getVariable('col')->value+1, null, null);?>
                                <?php }elseif($_smarty_tpl->getVariable('col')->value==1){?>
                                    <td width="30%" align="right" style="border-top: 1px solid #505050;" class="measurement_middle"><?php echo $_smarty_tpl->tpl_vars['sz']->value;?>
</td>
                                    <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable($_smarty_tpl->getVariable('col')->value+1, null, null);?>
                                <?php }else{ ?>
                                    <td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
                                        <br>
                                        <input type="radio" value="<?php echo $_smarty_tpl->getVariable('col')->value-1;?>
" name="mntSize" rel="<?php echo $_smarty_tpl->getVariable('base_measurement')->value;?>
: <?php echo $_smarty_tpl->tpl_vars['sz']->value;?>
" <?php if (isset($_smarty_tpl->getVariable('measurement',null,true,false)->value)){?>disabled<?php }?>><br><b><?php echo $_smarty_tpl->tpl_vars['sz']->value;?>
</b>
                                    </td>
                                    <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable($_smarty_tpl->getVariable('col')->value+1, null, null);?>
                                <?php }?>
                            <?php }} ?>
                            <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                                <td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
                                    <br><input type="radio" checked="" value="Custom" name="mntSize"><br><b>Customized</b>
                                </td>
                            <?php }?>                
                        </tr>
                        <?php $_smarty_tpl->tpl_vars['row'] = new Smarty_variable($_smarty_tpl->getVariable('row')->value+1, null, null);?>
                    <?php }else{ ?>
                        <tr>
                            <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable(0, null, null);?>
                            <?php $_smarty_tpl->tpl_vars['series'] = new Smarty_variable('', null, null);?>
                            <?php  $_smarty_tpl->tpl_vars['sz'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('size_data')->value[$_smarty_tpl->getVariable('smarty')->value['section']['size']['index']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['sz']->key => $_smarty_tpl->tpl_vars['sz']->value){
?>
                                <?php if ($_smarty_tpl->getVariable('col')->value==0){?>
                                    <td width="10%" align="center" class="measurement_left"><b><?php echo $_smarty_tpl->tpl_vars['sz']->value;?>
</b></td>
                                    <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable($_smarty_tpl->getVariable('col')->value+1, null, null);?>
                                    <?php $_smarty_tpl->tpl_vars['series'] = new Smarty_variable($_smarty_tpl->tpl_vars['sz']->value, null, null);?>
                                <?php }elseif($_smarty_tpl->getVariable('col')->value==1){?>
                                    <td width="30%" align="left" class="measurement_middle"><?php echo $_smarty_tpl->tpl_vars['sz']->value;?>
</td>
                                    <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable($_smarty_tpl->getVariable('col')->value+1, null, null);?>
                                <?php }else{ ?>
                                    <td width="10%" align="left" class="measurement_middle"><?php echo $_smarty_tpl->tpl_vars['sz']->value;?>
</td>
                                    <?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable($_smarty_tpl->getVariable('col')->value+1, null, null);?>
                                <?php }?>
                            <?php }} ?>
                            <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                                <td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
                                <input type="text" size="5" name="<?php echo $_smarty_tpl->getVariable('series')->value;?>
" id="<?php echo $_smarty_tpl->getVariable('series')->value;?>
" value="<?php if (isset($_smarty_tpl->getVariable('measurement',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('measurement')->value[$_smarty_tpl->getVariable('series')->value];?>
<?php }?>" class="custom_fields">
                                </td>
                            <?php }?>
                        </tr>
                    <?php }?>
                <?php endfor; endif; ?>
                <?php if (isset($_smarty_tpl->getVariable('measurement',null,true,false)->value)){?>
                <?php }else{ ?>
                    <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                        <tr id="measurement-alias">
                            <td align="left" class="measurement_left" colspan="8">
                                Please select a name to save this measurement. For example Me, Mom, Aditi
                            </td>
                            <td align="center" class="measurement_middle">
                                <input id="name_measuremnet" name="name_measurement" class="text required" value="" size="5" style="font-size:15px;height:15px;line-height:18px;"/>
                            </td>
                        </tr>
                    <?php }?>
                <?php }?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['name'] = 'instr';
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('spl_instr_post')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['instr']['total']);
?>
                    <tr>
                        <td colspan="9" style="text-align:left"><?php echo $_smarty_tpl->getVariable('spl_instr_post')->value[$_smarty_tpl->getVariable('smarty')->value['section']['instr']['index']];?>
</td>
                    </tr>
                <?php endfor; endif; ?>
            </tbody>
            </table>
            <div style="width:440px;padding:0px;float:left">
                <img src="<?php echo $_smarty_tpl->getVariable('img_ps_dir')->value;?>
<?php echo $_smarty_tpl->getVariable('size_image')->value;?>
" alt="measurement info"/>
            </div>
            <p class="submit" style="clear:both;text-align:center">
                <input type="hidden" name="type_measurement" value="<?php echo $_smarty_tpl->getVariable('type_measurement')->value;?>
"/>
                <input type="button" id="SubmitMeasurement" name="SubmitMeasurement" class="button_large" value="<?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
" style="display:inline-block"/>
                <?php if (isset($_smarty_tpl->getVariable('measurement',null,true,false)->value)){?>
                    <input type="hidden" name="id_measurement" value="<?php echo $_smarty_tpl->getVariable('measurement')->value['id_measurement'];?>
"/>
                <?php }?>
            </p>
        </form>
        <span id="measurement_done" style="display:none; font-size:18px; color:green">Measurement saved.</span>
    </div>
</div>

<script type="text/javascript">
<?php if (isset($_smarty_tpl->getVariable('measurement',null,true,false)->value)){?>
var edit = true;
<?php }else{ ?>
var edit = false;
<?php }?>
// <![CDATA[

var containerCreate = $('#measurement_errors');
$('input:radio[name=mntSize]').click(function(){
    if($('input:radio[name=mntSize]:checked').val() == 'Custom') {
        $('.custom_fields').addClass('required number');
        $('#measurement-alias').addClass('required');
        $('#measurement-alias').fadeIn();
    }
    else
    {
        $('.custom_fields').removeClass('required').removeClass('number');
        $('#measurement-alias').removeClass('required');
        $('#measurement-alias').fadeOut();
        $("#measurement_form").validate({
            errorContainer: containerCreate,
            errorLabelContainer: $("ol", containerCreate),
            wrapper: 'li',
            meta: "validate",
            groups: {
                measurements: "name_measurement <?php echo $_smarty_tpl->getVariable('measurement_indeces')->value;?>
"
              },
              errorPlacement: function(error, element) {
                   error.insertAfter(containerCreate);
               }
        });
        $("label.error").hide();
        $(".error").removeClass("error");
        $('#measurement_errors').hide();
    }
});

$('#SubmitMeasurement').click(function(e){
    e.preventDefault();
    var containerCreate = $('#measurement_errors');
    // validate the form when it is submitted
    if($('input:radio[name=mntSize]:checked').val() == 'Custom') {
        $('.custom_fields').addClass('required number');
        var validator = $("#measurement_form").validate({
            errorContainer: containerCreate,
            errorLabelContainer: $("ol", containerCreate),
            wrapper: 'li',
            meta: "validate",
            groups: {
                measurements: "name_measurement <?php echo $_smarty_tpl->getVariable('measurement_indeces')->value;?>
"
              },
              errorPlacement: function(error, element) {
                   error.insertAfter(containerCreate);
               }
        });
        if(!validator.form())
        {
            return;
        }

        var dataString = $('#measurement_form').serialize();
        dataString = dataString + "&ajax=1&SubmitMeasurement=1";
        $.ajax(
                {
                    type: 'POST',
                    url: baseDir + 'measurement.php',
                    data: dataString,
                    dataType: 'json',
                    success: function(result){
                        if(result.status == 'succeeded')
                        {
                            $('#measurement_form').fadeOut();
                            $('#measurement_done').fadeIn();
                            if(!edit)
                            {
                                $('#<?php echo $_smarty_tpl->getVariable('uid_measurement')->value;?>
').append('<option value='+result.id_measurement+'>'+result.name+'</option>');
                                $('#<?php echo $_smarty_tpl->getVariable('uid_measurement')->value;?>
').val(result.id_measurement);
                                $('#<?php echo $_smarty_tpl->getVariable('uid_measurement')->value;?>
').show();
                                window.setTimeout(function(){
                                    $.fancybox.close();
                                    }, 2000);
                            }
                            else
                            {
                                window.setTimeout(function(){
                                    location.reload(); 
                                }, 1000);
                            }
                        }
                        else if(result.status == 'error')
                        {
                            $('#measurement_error').fadeIn();
                        }
                    }
        });
    }
    else
    {
        $('#measurement_form').fadeOut();
        $('#<?php echo $_smarty_tpl->getVariable('uid_measurement')->value;?>
').val($('input:radio[name=mntSize]:checked').val());
        $.fancybox.close();
    }
});
$("#lnk_this").click(function(){
    $("#intl_size_chart").hide();
    $("#this_size_chart").show();
    $(this).removeClass("inactive").addClass("active");
    $("#lnk_intl").removeClass("active").addClass("inactive");
});
$("#lnk_intl").click(function(){
    $("#intl_size_chart").show();
    $("#this_size_chart").hide();
    $(this).removeClass("inactive").addClass("active");
    $("#lnk_this").removeClass("active").addClass("inactive");
});

</script>
