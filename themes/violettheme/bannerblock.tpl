{if $page_name=='index'}
{literal}
<script>

$(function() {
	$('.lazy2').jail({
		timeout:2000
	});
	
	window.setTimeout(function(){
	$(".rslides").responsiveSlides({
		  auto: true,             // Boolean: Animate automatically, true or false
		  speed: 500,            // Integer: Speed of the transition, in milliseconds
		  timeout: 1500,          // Integer: Time between slide transitions, in milliseconds
		  pager: false,           // Boolean: Show pager, true or false
		  nav: true,             // Boolean: Show navigation, true or false
		  random: false,          // Boolean: Randomize the order of the slides, true or false
		  pause: true,           // Boolean: Pause on hover, true or false
		  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
		  prevText: "Previous",   // String: Text for the "previous" button
		  nextText: "Next",       // String: Text for the "next" button
		  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
		  controls: "",           // Selector: Where controls should be appended to, default is after the 'ul'
		  namespace: "rslides",   // String: change the default namespace used
		  before: function(){},   // Function: Before callback
		  after: function(){}     // Function: After callback
		});}, 3000);
});
</script>
{/literal}


{assign var=counter value=1}
<ul class="rslides">
{section loop=$home_banners name=banner}
        {if $counter eq 1}
                <li>
                        <a class="banner_big" href="{$home_banners[banner].url}">
                                <img src="{$img_ps_dir}{$home_banners[banner].image_path}" alt="{$home_banners[banner].title}"  style="max-width:100%; width:100% auto;"/>
                        </a>
                </li>
        {else}
                <li>
                        <a class="banner_big" href="{$home_banners[banner].url}">
                                <img data-href="{$img_ps_dir}{$home_banners[banner].image_path}" alt="{$home_banners[banner].title}" class="lazy2" style="max-width:100%; width:100% auto;"/>
                                <noscript>
                                	<img src="{$img_ps_dir}{$home_banners[banner].image_path}" alt="{$home_banners[banner].title}"  style="max-width:100%; width:100% auto;"/>
                                </noscript>
                        </a>
                </li>
        {/if}
        {assign var=counter value=$counter+1}
{/section}
</ul>

<!-- /MODULE Block banners -->
{/if}
