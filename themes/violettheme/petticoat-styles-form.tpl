<div rel="text-headline" style="background:#F4F2F3">
	<div class="panel" id="panel"  style="float:left;margin:0px 10px 0px;border:1px dashed #cacaca;width:{if isset($default_displayed) && $default_displayed}830{else}530{/if}px">
		<div style="border-bottom:1px dashed #cacaca">
			<h1>CLICK TO SELECT A STYLE</h1>
		</div>
		<div style="position:relative">
		    {if isset($default_displayed) && $default_displayed}
		    <div class="style-select" rel="0" style="float:left;position:relative;margin:20px" data-image="{$img_ps_dir}styles/0-small.png">
				<div class="style-name">As Shown</div>
				<div><img src="{$img_ps_dir}styles/0-medium.png" width="200" height="383"></div>
				<div style="line-height:1.2em; text-align:left;">As shown in the product image</div>
			</div>
			{/if}
			<div class="style-select" rel="13" style="float:left;position:relative;margin:20px" data-image="{$img_ps_dir}styles/13-small.png">
				<div class="style-name">A-Line</div>
				<div><img src="{$img_ps_dir}styles/13-medium.png" width="200" height="383"></div>
				<div style="line-height:1.2em; text-align:left;">These classic skirts are comfortable to wear and carry on daily basis.</div>
			</div>
			<div class="style-select" rel="14" style="float:left;position:relative; margin:20px" data-image="{$img_ps_dir}styles/14-small.png">
				<div class="style-name">Fish Cut</div>
				<div><img src="{$img_ps_dir}styles/14-medium.png" width="173" height="383"></div>
				<div style="line-height:1.2em; text-align:left;">These are body hugging skirts for evening and party wear.</div>
			</div>
		</div>
	</div>	
</div>