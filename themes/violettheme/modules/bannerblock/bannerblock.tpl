{if false}
{literal}
<script>
$(function() {
	$(".slidetabs").tabs(".images > div", {
		effect: 'fade',
		fadeOutSpeed: "slow",
		rotate: true,
		autoplay: true
	}).slideshow();

	window.setTimeout(function(){$(".slidetabs").data("slideshow").play()}, 3000);
});
</script>
{/literal}
<!-- MODULE Block banners -->
<div id="bannerblock">
{*	<div style="width:230px; padding: 0;float:left;margin-left:7px;">
		<a href="/products/lakme+makeup+kit" title=""><img width="230" src="{$img_ps_dir}banners/lakme-makeup-kit.png" alt="lakme makeup kits" style="display:block"/></a>
		<a href="/content/10-free-gift-on-your-order" title=""><img width="230" src="{$img_ps_dir}banners/free-gift-on-purchase.png" alt="free gift" style="display:block"/></a>
		<a href="/shipping-policy.php" title="">
		<img width="230" src="{$img_ps_dir}banners/free-shipping-over-250.png" alt="free shipping with cash on delivery" style="display:block"/>
		<img width="230" src="{$img_ps_dir}banners/cash-on-delivery-cod.png" alt="free shipping with cash on delivery" style="display:block"/>
		</a>
	</div>
*}
<div class="images">
	<div>
		<a class="banner_big" href="{$base_dir}/5-skin-care"><img height="325" width="740" src="{$img_ps_dir}banners/test.jpg" alt="shop skincare products" /></a>
	</div>
	<div>
		<a class="banner_big" href="{$base_dir}/9-makeup"><img height="325" width="740" src="{$img_ps_dir}banners/test.jpg" alt="shop cosmetics products" /></a>
	</div>
	<div>
		<a class="banner_big" href="{$base_dir}/2-perfumes-deos"><img height="325" width="740" src="{$img_ps_dir}banners/test.jpg" alt="shop perfumes deos" /></a>
	</div>
	<div>
		<a class="banner_big" href="{$base_dir}/8-accessories"><img height="325" width="740" src="{$img_ps_dir}banners/test.jpg" alt="shop accessories" /></a>
	</div>
</div>
<!-- the tabs -->
<div class="slidetabs" style="position:relative;top:-30px;left:250px;float:left;">
    <a href="#">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
</div>
</div>
<!-- /MODULE Block banners -->
{/if}
