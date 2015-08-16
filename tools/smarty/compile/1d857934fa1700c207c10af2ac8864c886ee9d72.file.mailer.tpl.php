<?php /* Smarty version Smarty-3.0.7, created on 2015-05-17 10:46:01
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/admin/mailer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2783129555582411cf7902-81438343%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d857934fa1700c207c10af2ac8864c886ee9d72' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/admin/mailer.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2783129555582411cf7902-81438343',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ((($tmp = @$_smarty_tpl->getVariable('error')->value)===null||$tmp==='' ? '' : $tmp)!=''){?>
<div style="border-color:#F00; color:#F00; padding:5px;">
    <?php echo $_smarty_tpl->getVariable('error')->value;?>

</div>
<?php }?>
<div style="background-color: #ffffff !important; margin: 0; padding: 0">
    <form enctype="multipart/form-data" action="<?php echo $_smarty_tpl->getVariable('currentIndex')->value;?>
&token=<?php echo $_smarty_tpl->getVariable('token')->value;?>
" method="post" id="mailerForm" style="display:width:520px;">
        <h3> Campaign Details </h3>
        <fieldset>
            <p>
                <label>Campaign Name</label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('c_name')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="campaign_name" /> (for internal reference)
            </p>
            <p>
                <label>UTM Source</label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('utm_s')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="utm_source" />
            </p>
            <p>
                <label>UTM Medium</label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('utm_m')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="utm_medium" />
            </p>
            <p>
                <label>UTM Campaign</label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('utm_c')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="utm_campaign" />
            </p>
        </fieldset>
        <h3> Banner Image </h3>
        <fieldset>
            <p>
                <label>Banner Image</label>
                <input type="file" value="" name="banner_image" /> ( Height : 337px , Width : 630px )
            </p>
            <p>
                <label>Banner URL</label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('b_url')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="banner_url" />
            </p>
        </fieldset>
        <h3> Product Details </h3>
        <fieldset>
            <p>
                <label> Product Id ( For Large Image) </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pid_l')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="pid_large" />
            </p>
            <hr/>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[0])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[1])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[2])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[3])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[4])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[5])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[6])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('pids')->value[7])===null||$tmp==='' ? '' : $tmp);?>
" name="pid[]" />
            </p>
        </fieldset>
        <h3>Mail Information</h3>
        <fieldset>
            <p>
                <label>Mail Subject</label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('subject')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="subject" />
            </p>
            <p>
                <label>Shop Now Buton Link</label>
                <input type="text" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('a_link')->value)===null||$tmp==='' ? '' : $tmp);?>
" name="action_link" />
            </p>
            <p>
                <label>Mail Template</label>
                <select name="template">
                    <?php if ($_smarty_tpl->getVariable('template')->value=='elegant.tpl'){?>
                        <option value='elegant.tpl' selected>Elegant</option>
                    <?php }else{ ?>
                        <option value='elegant.tpl'>Elegant</option>
                    <?php }?>
                    <?php if ($_smarty_tpl->getVariable('template')->value=='region.tpl'){?>
                        <option value='region.tpl' selected>Region</option>
                    <?php }else{ ?>
                        <option value='region.tpl'>Region</option>
                    <?php }?>
                    <?php if ($_smarty_tpl->getVariable('template')->value=='banner.tpl'){?>
                        <option value='banner.tpl' selected>Only Banner</option>
                    <?php }else{ ?>
                        <option value='banner.tpl'>Only Banner</option>
                    <?php }?>
                </select>
            </p>
        </fieldset>
        <h3> Region Specific (only if template selected is REGION) </h3>
        <fieldset>
            <p>
                <label>Write Up</label>
                <textarea name="write_up" rows="4" cols="80"><?php echo (($tmp = @$_smarty_tpl->getVariable('write_up')->value)===null||$tmp==='' ? '' : $tmp);?>
</textarea>
            </p>
            <p>
                <label>Up-next Image</label>
                <input type="file" value="" name="upnext_image" />
            </p>
        </fieldset>
        <fieldset>
            <input type="hidden" name="id_campaign" value="<?php echo (($tmp = @$_smarty_tpl->getVariable('id_campaign')->value)===null||$tmp==='' ? 0 : $tmp);?>
" />       
            <input type="submit" name="psubmit" value="Preview" style="width: 120px;height: 40px;font-size: 16px;" />
        </fieldset>
        <fieldset>
            <?php if ($_smarty_tpl->getVariable('preview')->value=='true'){?>
                <?php echo $_smarty_tpl->getVariable('previewMail')->value;?>

            <?php }?>
        </fieldset>
        
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#datepicker").datepicker();
                });
            </script>
        
        <?php if ($_smarty_tpl->getVariable('preview')->value=='true'){?>
        <fieldset>
            <p>
                <label>Enter test email</label>
                <input type="text" name="testmail" value="" />
                <input type="submit" name="tmsubmit" value="Test Mail" />
            </p>
            <p>
                <label>Schedule Mailer At:</label>
                <input type="text" id="datepicker" name="scheduled_at" /> ( YYYY-MM-DD HH:MM:SS )
                <input type="submit" name="ssubmit" value="Submit" />
            </p>
        </fieldset>    
        <?php }?>
    </form>
</div>
