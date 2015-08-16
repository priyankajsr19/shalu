<div class="sz_popup">
    <ul class="tabs clearfix">
        <li id="lnk_this" class="active">SIZE CHART</li>
        <li id="lnk_intl" class="inactive">SIZE GUIDE</li>
    </ul>
    <div class="sz_popup_wrap" id="intl_size_chart" style="display:none">
        {include file="$tpl_dir./intl_size_map.tpl"}
    </div>
    <div class="sz_popup_wrap" id="this_size_chart" style="display:block">
        <div style="text-transform:uppercase">
            {if isset($measurement)}
                <h1>EDIT MEASUREMENT: {$measurement.name_measurement}</h1>
            {else}
                <h1>{$chart_title}</h1>
            {/if}
        </div>
        <div id="measurement_error" style="display:none">
            <span style="color:red;font-size:18px;">Something went wrong! Could not save measurement.</span>
        </div>
        <div id="measurement_errors" class="error_container">
            <ol style="list-style-type:none">
            </ol>
        </div>
        {section name=instr loop=$spl_instr}
            <p style="color:#999999">{$spl_instr[instr]}</p>
        {/section}
        
        <form action="measurement.php" method="post" id="measurement_form" style="padding:10px;">
            <table width="500px" cellspacing="0" style="float:left">
            <tbody>
                {assign var="row" value=0}
                {section name="size" loop=$size_data}
                    {if $row eq 0}
                        <tr style="background:#DFDFDF">
                            {assign var=col value=0}
                            {foreach from=$size_data[size] item=sz}
                                {if $col eq 0}
                                    <td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_left">{$sz}</td>
                                    {assign var=col value=$col+1}
                                {elseif $col eq 1}
                                    <td width="30%" align="right" style="border-top: 1px solid #505050;" class="measurement_middle">{$sz}</td>
                                    {assign var=col value=$col+1}
                                {else}
                                    <td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
                                        <br>
                                        <input type="radio" value="{$col-1}" name="mntSize" rel="{$base_measurement}: {$sz}" {if isset($measurement)}disabled{/if}><br><b>{$sz}</b>
                                    </td>
                                    {assign var=col value=$col+1}
                                {/if}
                            {/foreach}
                            {if $cookie->isLogged()}
                                <td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
                                    <br><input type="radio" checked="" value="Custom" name="mntSize"><br><b>Customized</b>
                                </td>
                            {/if}                
                        </tr>
                        {assign var=row value=$row+1}
                    {else}
                        <tr>
                            {assign var=col value=0}
                            {assign var=series value=''}
                            {foreach from=$size_data[size] item=sz}
                                {if $col eq 0}
                                    <td width="10%" align="center" class="measurement_left"><b>{$sz}</b></td>
                                    {assign var=col value=$col+1}
                                    {assign var=series value=$sz}
                                {elseif $col eq 1}
                                    <td width="30%" align="left" class="measurement_middle">{$sz}</td>
                                    {assign var=col value=$col+1}
                                {else}
                                    <td width="10%" align="left" class="measurement_middle">{$sz}</td>
                                    {assign var=col value=$col+1}
                                {/if}
                            {/foreach}
                            {if $cookie->isLogged()}
                                <td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
                                <input type="text" size="5" name="{$series}" id="{$series}" value="{if isset($measurement)}{$measurement.$series}{/if}" class="custom_fields">
                                </td>
                            {/if}
                        </tr>
                    {/if}
                {/section}
                {if isset($measurement)}
                {else}
                    {if $cookie->isLogged()}
                        <tr id="measurement-alias">
                            <td align="left" class="measurement_left" colspan="8">
                                Please select a name to save this measurement. For example Me, Mom, Aditi
                            </td>
                            <td align="center" class="measurement_middle">
                                <input id="name_measuremnet" name="name_measurement" class="text required" value="" size="5" style="font-size:15px;height:15px;line-height:18px;"/>
                            </td>
                        </tr>
                    {/if}
                {/if}
                {section name=instr loop=$spl_instr_post}
                    <tr>
                        <td colspan="9" style="text-align:left">{$spl_instr_post[instr]}</td>
                    </tr>
                {/section}
            </tbody>
            </table>
            <div style="width:440px;padding:0px;float:left">
                <img src="{$img_ps_dir}{$size_image}" alt="measurement info"/>
            </div>
            <p class="submit" style="clear:both;text-align:center">
                <input type="hidden" name="type_measurement" value="{$type_measurement}"/>
                <input type="button" id="SubmitMeasurement" name="SubmitMeasurement" class="button_large" value="{l s='Save'}" style="display:inline-block"/>
                {if isset($measurement)}
                    <input type="hidden" name="id_measurement" value="{$measurement.id_measurement}"/>
                {/if}
            </p>
        </form>
        <span id="measurement_done" style="display:none; font-size:18px; color:green">Measurement saved.</span>
    </div>
</div>

<script type="text/javascript">
{if isset($measurement)}
var edit = true;
{else}
var edit = false;
{/if}
// <![CDATA[
{literal}
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
                measurements: "name_measurement {/literal}{$measurement_indeces}{literal}"
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
                measurements: "name_measurement {/literal}{$measurement_indeces}{literal}"
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
                                $('#{/literal}{$uid_measurement}{literal}').append('<option value='+result.id_measurement+'>'+result.name+'</option>');
                                $('#{/literal}{$uid_measurement}{literal}').val(result.id_measurement);
                                $('#{/literal}{$uid_measurement}{literal}').show();
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
        $('#{/literal}{$uid_measurement}{literal}').val($('input:radio[name=mntSize]:checked').val());
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
{/literal}
</script>
