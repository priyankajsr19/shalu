
<!-- Block layered navigation module -->
{if $nbr_filterBlocks != 0}
    <div id="layered_block_left" class="block">
        <script type="text/javascript">
            var srch_query = '{$search_query}';
            var brand = '{$brand}';
            var latest = '{$latest}';
            var sale = '{$sale}';
            var express_shipping = '{$express_shipping}';
            var cat_id = '{$cat_id}';
            var nextPage = {$nextPage};
            {if isset($parentID)}
            var parentCategory = '{$parentID}';
            {/if}
        </script>
        <h4>{l s='Shop By' mod='blocklayered'}</h4>
        <div class="block_content">
            <form action="#" id="layered_form">
                <div>
                    {if isset($selected_filters) && $n_filters > 0 || isset($id_category_layered) && $id_category_layered != 1}
                        <div id="enabled_filters">
                            <span class="layered_subtitle" style="float: none;">{l s='Enabled filters:' mod='blocklayered'}</span>
                            <ul>
                                {foreach from=$selected_filters key=filter_type item=filter_values}
                                    {if $filter_type != 'category'}
                                        {foreach from=$filter_values item=filter_value name=f_values}
                                            <li>
                                                <a class="lnk_removefilter" href="#" rel="layered_{$filter_type}_{$filter_value.id}" title="{l s='Cancel' mod='blocklayered'}">x</a>
                                                {$filter_value.name|escape:html:'UTF-8'}
                                            </li>
                                        {/foreach}
                                    {/if}
                                {/foreach}
                                {if isset($id_category_layered) && $id_category_layered != 1}
                                    <li>
                                    {if isset($isCategoryCloseable) && $isCategoryCloseable == 1}<a class="lnk_removeCategory" id="selected_category" href="#" title="{l s='Cancel' mod='blocklayered'}">x</a>{/if}
                                    Category: {$name_category_layered|escape:html:'UTF-8'}
                                </li>
                            {/if}
                        </ul>
                    </div>

                {/if}

                {foreach from=$filters item=filter}
                    {if isset($filter.values)}
                        <div class="filter-group">
                            <span class="layered_subtitle">{$filter.name|escape:html:'UTF-8'}</span>
                            <span class="layered_close"><a href="#" rel="layered_{$filter.type}">v</a></span>
                            <div class="clear"></div>
                            <ul id="layered_{$filter.type}">
                                {foreach from=$filter.values key=id_value item=value}
                                    {if $value.nbr}
                                        <li{if $layered_use_checkboxes} class="nomargin clickable"{/if}>
                                            {if isset($filter.is_category) && $filter.is_category}
                                        {if isset($value.checked) && $value.checked}<input type="hidden" name="layered_{$filter.type}_{$id_value}" id="layered_{$filter.type}{if $id_value}_{$id_value}{/if}" value="{$id_value}" />{/if}
                                    {else}
                                        {if $layered_use_checkboxes}
                                            <input type="checkbox"
                                                   class="checkbox"
                                                   name="layered_{$filter.type}_{$id_value}"
                                                   id="layered_{$filter.type}{if $id_value}_{$id_value}{/if}"
                                                   value="{$id_value}"
                                            {if isset($value.checked)} checked="checked"{/if}
                                        {if !$value.nbr} disabled="disabled"{/if} />
                                {/if}
                            {/if}
                            <label for="layered_{$filter.type}_{$id_value}"{if isset($filter.is_category) && $filter.is_category}
                                   name="layered_{$filter.type}_{$id_value}"
                                   class="category" rel="{$id_value}"{/if}>{$value.name|escape:html:'UTF-8'}
                                <span> ({$value.nbr})</span>
                            </label>
                        </li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    {/if}
{/foreach}
</div>
<input id="id_category_layered" type="hidden" name="id_category_layered" value="{$id_category_layered}" />
<input id="orderby" type="hidden" name="orderby" value="new" />
<input id="orderway" type="hidden" name="orderway" value="desc" />
{foreach from=$filters item=filter}
    {if $filter.type == 'id_attribute_group' && isset($filter.is_color_group) && $filter.is_color_group}
        {foreach from=$filter.values key=id_value item=value}
            {if isset($value.checked)}
                <input type="hidden" name="layered_id_attribute_group_{$id_value}" value="{$id_value}" />
            {/if}
        {/foreach}
    {/if}
{/foreach}
</form>
</div>
<div id="layered_ajax_loader" style="display: none;">
    <p style="margin: 20px 0; text-align: center;"><img src="{$img_ps_dir}loader.gif" alt="" /><br />{l s='Loading...' mod='blocklayered'}</p>
</div>
</div>
<div id="top-marker" style="height:1px; width:100%;"></div>
<div id="go-to-top" style="color:#ffffff; background: none repeat scroll 0 0 #A41E21;">
    Go To Top
</div>
{/if}
<!-- /Block layered navigation module -->
