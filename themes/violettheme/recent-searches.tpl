{if isset($popularcategories) && !empty($popularcategories) && $popularcategories eq "true"}
    <a href="{$base_dir}Sarees.php" title="Indusdiva Sarees">Sarees</a><br/>
    <a href="{$base_dir}Temple-Sarees.php" title="Indusdiva Sarees">Temple Sarees</a><br/>
    <a href="{$base_dir}Mysore-Silk-Sarees.php" title="Indusdiva Sarees">Mysore Silk Sarees</a><br/>
    <a href="{$base_dir}Half-And-Half-Sarees.php" title="Indusdiva Sarees">Half And Half Sarees</a><br/>
    <a href="{$base_dir}Lehenga-Sarees.php" title="Indusdiva Sarees">Lehenga Sarees</a><br/>
    <a href="{$base_dir}Kanjeevaram-Sarees.php" title="Indusdiva Sarees">Kanjeevaram Sarees</a><br/>
    <a href="{$base_dir}Chikankari-Sarees.php" title="Indusdiva Sarees">Chikankari Sarees</a><br/>
    <a href="{$base_dir}Bridal-Sarees.php" title="Indusdiva Sarees">Bridal Sarees</a><br/>
    <a href="{$base_dir}Banarasi-Sarees.php" title="Indusdiva Sarees">Banarasi Sarees</a><br/>
{else}
    <h1>{l s='Recent Searches'}</h1>
    {if isset($keywords)}
        <ul>
            {foreach from=$keywords item=keyword}
                <li class="search_keywords">
                    <a href="{$base_dir}products/{$keyword|urlencode}" title="">{$keyword|escape:'htmlall'}</a>
                </li>
            {/foreach}
        </ul>
    {else}
        {foreach from=$pages item=pageNo}
            <a href="{$base_dir}sitemaps/{$pageNo}" title="" class="search_keywords">{$pageNo}</a>
        {/foreach}
        <a href="{$base_dir}sitemaps/popular-categories" title="" class="search_keywords">popular categories</a>
    {/if}
{/if}
