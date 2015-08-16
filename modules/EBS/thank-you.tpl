<div id="co_content">
	<div id="co_left_column">
	{assign var='current_step' value='payment'}
		{include file="$tpl_dir./order-steps.tpl"}
	<h2>{l s='Thank You for Your Order.'}</h2>
	<h3>{$responseMsg}</h3>
	<p>If you would like to view your order history please <a href="../../history.php" title="{l s='History of Orders' mod='EBS'}">click here!</a></p>
	
	</div>
		<div id="co_rht_col">
		</div>
</div>