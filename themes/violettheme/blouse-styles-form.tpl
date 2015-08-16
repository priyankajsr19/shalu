<div id="style-container" rel="text-headline" style="height:920px;background:#F4F2F3;">
	<div class="panel" id="panel"  style="float:left;margin:0px;border:1px dashed #cacaca;height:840px;width:960px;">
		<div style="border-bottom:1px dashed #cacaca">
			<h1>CLICK TO SELECT A STYLE</h1>
		</div>
		<div style="position:relative">
		{foreach from=$styles item=style}
			<div class="style-select" rel="{$style.id_style}" data-image="{$img_ps_dir}styles/{$style.style_image_small}">
				<div class="style-name">{$style.style_name}</div>
				<div><img src="{$img_ps_dir}styles/{$style.style_image}" width="200" height="160"></div>
				<div style="line-height:1.2em; text-align:left;">{$style.description}</div>
			</div>
		{/foreach}
		</div>
	</div>	
</div>