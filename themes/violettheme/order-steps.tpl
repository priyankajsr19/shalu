{* Assign a value to 'current_step' to display current style *}
{if !$opc}
<!-- Steps -->
<ul class="step" id="order_step">
	{*<li class="{if $current_step=='summary'}step_current{else}{if $current_step=='payment' || $current_step=='shipping' || $current_step=='address' || $current_step=='login'}step_done{else}step_todo{/if}{/if}">
		<div class="step_arrow"></div>
		{if $current_step=='payment' || $current_step=='shipping' || $current_step=='address' || $current_step=='login'}
		<a href="{$link->getPageLink('order.php', true)}{if isset($back) && $back}?back={$back}{/if}">
			<span class="step-no">0</span><span>{l s='Summary'}</span>
		</a>
		{else}
		<span class="step-no">0<span>{l s='Summary'}</span>
		{/if}
		
		
	</li>*}
	{*<li class="{if $current_step=='login'}step_current{else}{if $current_step=='payment' || $current_step=='shipping' || $current_step=='address'}step_done{else}step_todo{/if}{/if}">
		{if $current_step=='payment' || $current_step=='shipping' || $current_step=='address'}
			<a href="{$link->getPageLink('order.php', true)}?step=1{if isset($back) && $back}&amp;back={$back}{/if}">
				<span class="step-no">1</span><span style="width:50px;">{l s='Login'}</span>
			</a>
		{else}
		<span class="step-no">1</span>
		<span style="width:50px;">{l s='Login'}</span>
		{/if}
		
	</li>*}
	<li class="{if $current_step=='address'}step_current{else}{if $current_step=='billing' || $current_step=='payment' || $current_step=='shipping'}step_done{else}step_todo{/if}{/if}">
		{*<div class="{if $current_step=='login'}step_arrow_selected{else}step_arrow{/if}"></div>*}
		{if $current_step=='payment' || $current_step=='billing'}
			<a href="{$link->getPageLink('order.php', true)}?step=1{if isset($back) && $back}&amp;back={$back}{/if}">
				<span class="step-no">1</span><span>{l s='Shipping Address'}</span>
			</a>
		{else}
		<span class="step-no">1</span>
		<span>{l s='Shipping Address'}</span>
		{/if}
	</li>
	<li class="{if $current_step=='billing'}step_current{else}{if $current_step=='payment'}step_done{else}step_todo{/if}{/if}">
		<div class="{if $current_step=='address'}step_arrow_selected{else}step_arrow{/if}"></div>
		{if $current_step=='payment'}
			<a href="{$link->getPageLink('order.php', true)}?step=2{if isset($back) && $back}&amp;back={$back}{/if}">
				<span class="step-no">2</span><span>{l s='Billing Address'}</span>
			</a>
		{else}
		<span class="step-no">2</span>
		<span>{l s='Billing Address'}</span>
		{/if}
	</li>
	<li class="{if $current_step=='payment'}step_current{else}step_todo{/if}">
		<div class="{if $current_step=='billing'}step_arrow_selected{else}step_arrow{/if}"></div>
		<span class="step-no">3</span><span>{l s='Payment'}</span>
	</li>
	<li id="step_end" class="{if $current_step=='done'}step_current{else}step_todo{/if}">
		<div class="{if $current_step=='payment'}step_arrow_selected{else}step_arrow{/if}"></div>
		<span class="step-no">4</span><span>{l s='Done'}</span>
	</li>
</ul>
<!-- /Steps -->
{/if}