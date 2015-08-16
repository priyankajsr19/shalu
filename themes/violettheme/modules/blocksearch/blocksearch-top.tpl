{if !$hide_header}
<!-- Block search module TOP -->
<div id="search_block_top" style="padding:25px 0 0 30px;">
	<form method="get" action="{$link->getPageLink('search.php')}" id="searchbox">
		<div style=" position:relative;z-index:1;">	
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			{if !isset($smarty.get.search_query)}
			    <label id="search_label" for="search_query_top" class="" style="position:absolute; line-height:28px;text-align:left;left:15px;top:4px;overflow:hidden; height:28px;width:200px; z-index:2;color:#939393">Search indusdiva.com</label>
			{/if}
			<input class="search_query" type="text" id="search_query_top" style="border:1px solid #939393; line-height:28px;text-align:left;border-right:none; font-size:14px;padding-left:5px;color:#939393;z-index:1;" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{else}{/if}" 
				onfocus="focustText(this);" 
				onblur="blurText(this);" />
			<input type="submit" name="submit_search" value="{l s='' mod='blocksearch'}" class="search_button_top" style="border:1px solid #939393; border-left:none;"/>
		</div>	
	</form>
</div>

{if $instantsearch}
	<script type="text/javascript">
	// <![CDATA[
		{literal}
		
		function tryToCloseInstantSearch() {
			if ($('#old_center_column').length > 0)
			{
				$('#center_column').remove();
				$('#old_center_column').attr('id', 'center_column');
				$('#center_column').show();
				return false;
			}
		}
		
		instantSearchQueries = new Array();
		function stopInstantSearchQueries(){
			for(i=0;i<instantSearchQueries.length;i++) {
				instantSearchQueries[i].abort();
			}
			instantSearchQueries = new Array();
		}
		
		$("#search_query_top").keyup(function(){
			if($(this).val().length > 0){
				stopInstantSearchQueries();
				instantSearchQuery = $.ajax({
				url: '{/literal}{if $search_ssl == 1}{$link->getPageLink('search.php', true)}{else}{$link->getPageLink('search.php')}{/if}{literal}',
				data: 'instantSearch=1&id_lang={/literal}{$cookie->id_lang}{literal}&q='+$(this).val(),
				dataType: 'html',
				success: function(data){
					if($("#search_query_top").val().length > 0)
					{
						tryToCloseInstantSearch();
						$('#center_column').attr('id', 'old_center_column');
						$('#old_center_column').after('<div id="center_column">'+data+'</div>');
						$('#old_center_column').hide();
						$("#instant_search_results a.close").click(function() {
							$("#search_query_top").val('');
							return tryToCloseInstantSearch();
						});
						return false;
					}
					else
						tryToCloseInstantSearch();
					}
				});
				instantSearchQueries.push(instantSearchQuery);
			}
			else
				tryToCloseInstantSearch();
		});
	// ]]>
	{/literal}
	</script>
{/if}

{if $ajaxsearch}
	<script type="text/javascript">
	// <![CDATA[
	{literal}
		$('document').ready( function() {
			$("#search_query_top")
				.autocomplete(
					'{/literal}{if $search_ssl == 1}{$link->getPageLink('search.php', true)}{else}{$link->getPageLink('search.php')}{/if}{literal}', {
						minChars: 3,
						max: 10,
						width: 500,
						selectFirst: false,
						scroll: false,
						dataType: "json",
						formatItem: function(data, i, max, value, term) {
							return value;
						},
						parse: function(data) {
							var mytab = new Array();
							for (var i = 0; i < data.length; i++)
								mytab[mytab.length] = { data: data[i], value: data[i].cname + ' > ' + data[i].pname };
							return mytab;
						},
						extraParams: {
							ajaxSearch: 1,
							id_lang: {/literal}{$cookie->id_lang}{literal}
						}
					}
				)
				.result(function(event, data, formatted) {
					$('#search_query_top').val(data.pname);
					document.location.href = data.product_link;
				})
		});
	{/literal}
	// ]]>
	</script>
{/if}
<!-- /Block search module TOP -->
{/if}