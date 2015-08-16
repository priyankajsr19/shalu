{$HOOK_HOME}
<div class="quick_links_tab">
	<ul class="quick_links_list" style="width: 700px;">
		<li class="quick_links"><span>QUICK LINKS</span></li>
		<li class="quick_links"><span>|</span></li>
		<li class="quick_links"><a href="{$base_dir}new-in" class="span_link" style="color: #75B1DC"><span>Whats New</span></a></li>
		<li class="quick_links"><span>|</span></li>
		<li class="quick_links"><a href="{$base_dir}products/wedding" class="span_link" style="color: #75B1DC"><span>Indian Wedding Collection</span></a></li>
		<li class="quick_links"><span>|</span></li>
		<li class="quick_links"><a href="{$base_dir}33-banarasi-sarees" class="span_link" style="color: #75B1DC"><span>Banarasi Sarees</span></a></li>
		<li class="quick_links"><span>|</span></li>
		<li class="quick_links"><a href="{$base_dir}30-kanjeevaram-sarees" class="span_link" style="color: #75B1DC"><span>Kanjeevaram Sarees</span></a></li>
	</ul>
	<span id="cod-banner" style="margin: 0px 0px; display: block; height: 36px; width: 256px; float: right; text-align: right; margin-top: 5px;">
		<a href="#shipping-charges" class="shipping_link span_link">FREE SHIPPING OVER US $100</a>
	</span>
</div>

<div style="padding: 10px 0; clear: both">
	<ul>
		<li style="display: inline-block; padding: 0 1px">
			<a href="{$base_dir}513-menswear">
				<img src="{$img_ps_dir}banners/Menswear_Bottom_20132811.jpg" alt="Indusdiva Menswear Collection">
			</a>
		</li>
		{if $cookie->isLogged()}
		<li style="display: inline-block; padding: 0 0px">
			<a href="{$base_dir}idrewards.php">
				<img src="{$img_ps_dir}banners/ClubDiva_Bottom_20132711.jpg" alt="Club Diva - IndusDiva Loyalty Program" />
			</a>
		</li>
		{else}
		<li style="display: inline-block; padding: 0 1px">
			<a class="fancybox login_link" href="#login_modal_panel">
				<img src="{$img_ps_dir}banners/SignUp_Bottom_20132811.jpg" alt="Signup and get 100USD to shop">
			</a>
		</li>
		{/if}
		<li style="display: inline-block; padding: 0 1px">
			<a href="{$base_dir}476-kidswear">
				<img src="{$img_ps_dir}banners/Kidswear_Bottom_20132711.jpg" alt="Indusdiva kidswear collection">
			</a>
		</li>
		
	</ul>
	
</div>
<div style="padding: 0; clear: both">
	<ul>
		<li style="display: inline-block; padding: 0 1px">
			<a href="{$base_dir}1190-accessories">
				<img src="{$img_ps_dir}banners/Accessories_Bottom_20132811.jpg" alt="Buy Indusdiva Accessories online">
			</a>
		</li>
        <li style="display: inline-block; padding: 0 1px">
            <a href="{$base_dir}new-in">
                <img src="{$img_ps_dir}banners/NewArrival_Bottom_20132811.jpg" alt="Buy Latest collection from Indusdiva" />
            </a>
        </li>
		<li style="display: inline-block; padding: 0 0px">
			<a href="{$base_dir}bulkenquiries.php" >
				<img src="{$img_ps_dir}banners/BulkEnquiry_Bottom_20132711.jpg">
			</a>	
		</li>
	</ul>
</div>
{if isset($recently_viewed) && $recently_viewed|@count > 0}
<script>
	// execute your scripts when the DOM is ready. this is mostly a good habit
	$(function() {
	
		// initialize scrollable
		$(".scrollable").scrollable();
		$(".scroll").scrollable({ circular: true }).click(function() {
		      $(this).data("scrollable").next();
		      });
	
	});
</script>
<div id="recent_pane" class="product_group_panes" style="padding-top: 10px;">
	<div style="float: left;">
		<span id="recent_head" class="home_pane_title"></span>
		<span class="panes_bar"></span>
	</div>
	<div class="products_block_medium">
		<a class="prev browse left">Prev</a>
		<div class="scrollable">
			<div class="items">
				{foreach from=$recently_viewed item=productitem name=recentProducts} {if $smarty.foreach.recentProducts.first == true || $smarty.foreach.recentProducts.index % 5 == 0}
				<div>
					<ul>
						{/if}
						<li class="ajax_block_product" rel="{$productitem.id_product}">
							<div class="product_card">
								{if $productitem.quantity <= 0} <img alt="Out Of Stock" src="{$img_ps_dir}out_of_stock_vs.png" style="margin: 0 0; position: absolute; left: 1px; top: 0px;" /> {/if} <a href="{$productitem.product_link}"> <span class="product_image_medium" href="{$productitem.product_link}"
										title="{$productitem.name|escape:html:'UTF-8'}">
										{if isset($lazy) && $lazy == 1} <img src="{$img_ps_dir}blank.jpg" data-href="{$productitem.image_link_medium}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" class="delaylazy" />
										<noscript>
											<img src="{$productitem.image_link_medium}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" />
										</noscript>
										{else} <img src="{$productitem.image_link_medium}" height="205" width="150" alt="{$productitem.name|escape:html:'UTF-8'}" /> {/if}
									</span> <span class="product-list-name">
										<h2 class="product_card_name">{$productitem.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</h2>
									</span> <span class="product_info">
										{if $price_tax_country == 110}
										<span class="price">
											{convertAndShow price=$productitem.offer_price_in}
										</span>
										{else}
										<span class="price">
											{convertAndShow price=$productitem.offer_price}
										</span>
										{/if}
									</span>
								</a>
							</div>
						</li> {if $smarty.foreach.recentProducts.index % 5 == 4 || $smarty.foreach.recentProducts.last == true}
					</ul>
				</div>
				{/if} {/foreach}
			</div>
		</div>
		<a class="next browse right" style="display: block;">Next</a>
	</div>
</div>
{/if}
<div id="fb-root"></div>
{literal}
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId  : '285166361588635',
            xfbml  : true,
            oauth : true
          });
          FB.Event.subscribe('edge.create',function(response) {
              var datastring = 'ajax=true&fb_page_like=1';
              $.ajax({
                  type: 'POST',
                  url: baseDir + 'feedback.php',
                  data: datastring,
                  dataType: 'json',
                  success: function(result){
                      if(result.feedback_status === 'succeeded') {}
                  }
              });
          });
          FB.Event.subscribe('edge.remove',function(response) {
              var datastring = 'ajax=true&fb_page_like=2';
              $.ajax({
                  type: 'POST',
                  url: baseDir + 'feedback.php',
                  data: datastring,
                  dataType: 'json',
                  success: function(result){
                      if(result.feedback_status === 'succeeded'){}
                  }
              });
          });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=285166361588635";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
{/literal}
<div class="fb-like-box" data-href="http://www.facebook.com/indusdiva" data-width="980" data-height="180" data-show-faces="true" data-stream="false" data-header="false"></div>
<div style="clear: both; padding: 30px 0 0; border-top: 1px dotted #393939;">
	<div style="float: left; width: 700px; border-right: 1px dotted #939393">
		<h4 style="padding: 5px; font-size: 18px; font-family: Abel">About IndusDiva</h4>
		<p class="footer_about">IndusDiva.com brings to you premium Indian ethnic wear synonymous with style, class, beauty and elegance. At IndusDiva.com we believe in recreating the whole experience of buying apparel from a store, online. Right from feeling the threads of tradition and culture woven
			into the purity of fabric, we offer all this without the nuisances and hassles of physical shopping. We encourage- exploring, choosing, experiencing and buying, right from the comfort of your home in a far away land.﻿</p>
	</div>
	<div style="width: 210px; float: left; margin-left:20px" class="testimonials right">
		<h4 style="padding: 5px; font-size: 18px; font-family: Abel">Customer Speak</h4>
		<div class="scroll" style="padding-top:12px;">
    		<div class="pics">
      			<div style="color:#666666;">
      				<div>
      					<i>You are awesome, I already recommended tons of my friend and please bring more Gadual and traditional sarees. Thanks again.</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Sharmin (Wallingford, USA)
      				</div>
      			</div>
      			<div style="color:#666666;">
      				<div>
      					<i>Just love your site. :)</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Sangeetha (New York, USA)
      				</div>
      			</div>
      			<div style="color:#666666;">
      				<div>
      					<i>Indusdiva is a good site for online purchases, I'm very satisfied with the fitting of my blouse in particular for the saree, it's money's worth.I would recommend this site and will do more shopping with them.</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Vidya (Lansdale, USA)
      				</div>
      			</div>
      			<div style="color:#666666;">
      				<div>
      					<i>IndusDiva is the place I ended up for my bridal wear. Shopping for my Bridal saree made me anxious enough and doing it online was real scary but thanks to IndusDiva and its fantastic Stylist Team, I am all set to say the vows with the most beautiful bridal saree I have ever set my eye on.</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Preeti (Ontario, Canada)
      				</div>
      			</div>
      			<div style="color:#666666;">
      				<div>
      					<i>Loved what I received today, the Anarkali I picked from IndusDiva fits like a dream. And thanks to the Design Studio you guys have, I could actually ask for few extra add-ons and get it executed so well. I am going to shop again very soon. Thank you so so much for the outfit.</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Ashley (Sunnyvale, USA)
      				</div>
      			</div>
      			<div style="color:#666666;">
      				<div>
      					<i>I got my gorgeous bridesmaids' collection today and I'm more than delighted. Shopping with IndusDiva has been my best online experience so far.</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Amy (Bristol, UK)
      				</div>
      			</div>
      			<div style="color:#666666;">
      				<div>
      					<i>The South Indian Silk Collection on the website is so cool, I was spoilt for choice. Thanks for doing the fall and pico for free and also taking in special request for the blouse design, I do not think I am going back to my tailor here ever. Thanks IndusDiva</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Pranalika (Jaipur, India)
      				</div>
      			</div>
      			<div style="color:#666666;">
      				<div>
      					<i>I love your Customer Support Team, I have never worn a saree before and they gave me such fantastic suggestions that I HAD to pick up one for myself. And I love the pre stitched version I have got, this is just so easy. You have just turned my all time favorite IndusDiva.</i>
      				</div>
      				<div style="padding-top:6px;">
      					- Devyani (Kuala Lumpur)
      				</div>
      			</div>
    		</div>
  		</div>
	</div>
</div>
