<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:02:15
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/modules/blocksearch/blocksearch-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9390893165562de0f122e53-00444768%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b3a14afe7e544073ad45b781823cc2b02e3eb4a' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/modules/blocksearch/blocksearch-top.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9390893165562de0f122e53-00444768',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$_smarty_tpl->getVariable('hide_header')->value){?>
<!-- Block search module TOP -->
<div id="search_block_top" style="padding:25px 0 0 30px;">
	<form method="get" action="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('search.php');?>
" id="searchbox">
		<div style=" position:relative;z-index:1;">	
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<?php if (!isset($_GET['search_query'])){?>
			    <label id="search_label" for="search_query_top" class="" style="position:absolute; line-height:28px;text-align:left;left:15px;top:4px;overflow:hidden; height:28px;width:200px; z-index:2;color:#939393">Search indusdiva.com</label>
			<?php }?>
			<input class="search_query" type="text" id="search_query_top" style="border:1px solid #939393; line-height:28px;text-align:left;border-right:none; font-size:14px;padding-left:5px;color:#939393;z-index:1;" name="search_query" value="<?php if (isset($_GET['search_query'])){?><?php echo stripslashes(htmlentities($_GET['search_query'],$_smarty_tpl->getVariable('ENT_QUOTES')->value,'utf-8'));?>
<?php }else{ ?><?php }?>" 
				onfocus="focustText(this);" 
				onblur="blurText(this);" />
			<input type="submit" name="submit_search" value="<?php echo smartyTranslate(array('s'=>'','mod'=>'blocksearch'),$_smarty_tpl);?>
" class="search_button_top" style="border:1px solid #939393; border-left:none;"/>
		</div>	
	</form>
</div>

<?php if ($_smarty_tpl->getVariable('instantsearch')->value){?>
	<script type="text/javascript">
	// <![CDATA[
		
		
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
				url: '<?php if ($_smarty_tpl->getVariable('search_ssl')->value==1){?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('search.php',true);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('search.php');?>
<?php }?>',
				data: 'instantSearch=1&id_lang=<?php echo $_smarty_tpl->getVariable('cookie')->value->id_lang;?>
&q='+$(this).val(),
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
	
	</script>
<?php }?>

<?php if ($_smarty_tpl->getVariable('ajaxsearch')->value){?>
	<script type="text/javascript">
	// <![CDATA[
	
		$('document').ready( function() {
			$("#search_query_top")
				.autocomplete(
					'<?php if ($_smarty_tpl->getVariable('search_ssl')->value==1){?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('search.php',true);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('search.php');?>
<?php }?>', {
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
							id_lang: <?php echo $_smarty_tpl->getVariable('cookie')->value->id_lang;?>

						}
					}
				)
				.result(function(event, data, formatted) {
					$('#search_query_top').val(data.pname);
					document.location.href = data.product_link;
				})
		});
	
	// ]]>
	</script>
<?php }?>
<!-- /Block search module TOP -->
<?php }?>