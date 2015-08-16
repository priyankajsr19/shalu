{if $error|default:'' neq ''}
<div style="border-color:#F00; color:#F00; padding:5px;">
    {$error}
</div>
{/if}
<div style="background-color: #ffffff !important; margin: 0; padding: 0">
    <form enctype="multipart/form-data" action="{$currentIndex}&token={$token}" method="post" id="mailerForm" style="display:width:520px;">
        <h3> Campaign Details </h3>
        <fieldset>
            <p>
                <label>Campaign Name</label>
                <input type="text" value="{$c_name|default:''}" name="campaign_name" /> (for internal reference)
            </p>
            <p>
                <label>UTM Source</label>
                <input type="text" value="{$utm_s|default:''}" name="utm_source" />
            </p>
            <p>
                <label>UTM Medium</label>
                <input type="text" value="{$utm_m|default:''}" name="utm_medium" />
            </p>
            <p>
                <label>UTM Campaign</label>
                <input type="text" value="{$utm_c|default:''}" name="utm_campaign" />
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
                <input type="text" value="{$b_url|default:''}" name="banner_url" />
            </p>
        </fieldset>
        <h3> Product Details </h3>
        <fieldset>
            <p>
                <label> Product Id ( For Large Image) </label>
                <input type="text" value="{$pid_l|default:''}" name="pid_large" />
            </p>
            <hr/>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[0]|default: ''}" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[1]|default: ''}" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[2]|default: ''}" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[3]|default: ''}" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[4]|default: ''}" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[5]|default: ''}" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[6]|default: ''}" name="pid[]" />
            </p>
            <p>
                <label> Product Id </label>
                <input type="text" value="{$pids[7]|default: ''}" name="pid[]" />
            </p>
        </fieldset>
        <h3>Mail Information</h3>
        <fieldset>
            <p>
                <label>Mail Subject</label>
                <input type="text" value="{$subject|default:''}" name="subject" />
            </p>
            <p>
                <label>Shop Now Buton Link</label>
                <input type="text" value="{$a_link|default:''}" name="action_link" />
            </p>
            <p>
                <label>Mail Template</label>
                <select name="template">
                    {if $template eq 'elegant.tpl'}
                        <option value='elegant.tpl' selected>Elegant</option>
                    {else}
                        <option value='elegant.tpl'>Elegant</option>
                    {/if}
                    {if  $template eq 'region.tpl'}
                        <option value='region.tpl' selected>Region</option>
                    {else}
                        <option value='region.tpl'>Region</option>
                    {/if}
                      {if  $template eq 'handlom.tpl'}
                        <option value='handlom.tpl' selected>Handlom</option>
                    {else}
                        <option value='handlom.tpl'>Handlom</option>
                    {/if}
                    {if $template eq 'banner.tpl'}
                        <option value='banner.tpl' selected>Only Banner</option>
                    {else}
                        <option value='banner.tpl'>Only Banner</option>
                    {/if}
                </select>
            </p>
        </fieldset>
        <h3> Region Specific (only if template selected is REGION) </h3>
        <fieldset>
            <p>
                <label>Write Up</label>
                <textarea name="write_up" rows="4" cols="80">{$write_up|default:''}</textarea>
            </p>
            <p>
                <label>Up-next Image</label>
                <input type="file" value="" name="upnext_image" />
            </p>
        </fieldset>
        <fieldset>
            <input type="hidden" name="id_campaign" value="{$id_campaign|default: 0}" />       
            <input type="submit" name="psubmit" value="Preview" style="width: 120px;height: 40px;font-size: 16px;" />
        </fieldset>
        <fieldset>
            {if $preview eq 'true'}
                {$previewMail}
            {/if}
        </fieldset>
        {literal}
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#datepicker").datepicker();
                });
            </script>
        {/literal}
        {if $preview eq 'true'}
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
        {/if}
    </form>
</div>
