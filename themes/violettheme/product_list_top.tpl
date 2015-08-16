<div class="search-nav-bar">
		<div class="nresults"><span class="big">{$nbProducts|intval}</span>&nbsp;{if $nbProducts == 1}{l s='result'}{else}{l s='results'}{/if}</div> 
{if isset($p) AND $p}
	<div class="nav-pagination">{include file="$tpl_dir./pagination.tpl"}</div>
{/if}
		<div class="search-sort">{if !isset($instantSearch) || (isset($instantSearch) && !$instantSearch)}{include file="$tpl_dir./product-sort.tpl"}{/if}</div>
</div>
	