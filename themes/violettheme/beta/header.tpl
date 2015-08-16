<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
	<head>
		<title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
{if isset($meta_description) AND $meta_description}
		<meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
{/if}
{if isset($meta_keywords) AND $meta_keywords}
		<meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
{/if}
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
{if isset($og_meta) AND $og_meta}
		<meta property="og:title" content="{$og_title|escape:'htmlall':'UTF-8'}"/>
		<meta property="og:type" content="product"/>
		<meta property="og:url" content="{$og_page_url|escape:'htmlall':'UTF-8'}"/>
		<meta property="og:image" content="{$og_image_url|escape:'htmlall':'UTF-8'}"/>
		<meta property="og:description" content="{$og_description|escape:'htmlall':'UTF-8'}"/>
{else}
		<meta property="og:title" content="{$meta_title|escape:'htmlall':'UTF-8'}"/>
		<meta property="og:type" content="website"/>
		<meta property="og:image" content="{$base_dir}img/violetbag.jpg"/>
		<meta property="og:description" content="{$meta_description|escape:html:'UTF-8'}"/>
{/if}
{if isset($canonical_url)}
		<link rel="canonical" href="{$canonical_url|escape:'htmlall':'UTF-8'}" />
{/if}
{if isset($p) AND $p}
	{if $pages_nb > 1 AND $p != $pages_nb}
		{assign var='p_next' value=$p+1}
		<link rel="next" href="{$paginationBaseUrl}{$link->goPage($requestPage, $p_next)}" />
	{/if}
	{if $p != 1}
		{assign var='p_previous' value=$p-1}
		<link rel="prev" href="{$paginationBaseUrl}{$link->goPage($requestPage, $p_previous)}" />
	{/if}
{/if}
		<meta property="og:site_name" content="VioletBag.com"/>
		<meta property="fb:app_id" content="277196482292288"/>
		
		<meta name="robots" content="{if isset($nobots)}no{/if}index,follow" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$img_ps_dir}favicon.ico?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$img_ps_dir}favicon.ico?{$img_update_time}" />
		{*<link href="{$base_dir}modules/categoriesbar/chromestyle.css" rel="stylesheet" type="text/css" media="all" />
		<script type="text/javascript" src="{$base_dir}modules/categoriesbar/chrome.js"></script>*}
		<script type="text/javascript">
			var baseDir = '{$content_dir}';
			var static_token = '{$static_token}';
			var token = '{$token}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var priceDisplayMethod = {$priceDisplay};
			var roundMode = {$roundMode};

			
		</script>
{if isset($css_files)}
	{foreach from=$css_files key=css_uri item=media}
	<link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />
	{/foreach}
{/if}
{if isset($js_files)}
	{foreach from=$js_files item=js_uri}
	<script type="text/javascript" src="{$js_uri}"></script>
	{/foreach}
{/if}
		{$HOOK_HEADER}
		<script type="text/javascript">
			{literal}
				$(document).ready(function() {
					$('#feedback-form').submit(function(e){
						var container = $('#error_container');
						// validate the form when it is submitted
						var validator = $("#feedback-form").validate({
							errorContainer: container,
							errorLabelContainer: $("ol", container),
							wrapper: 'li',
							meta: "validate"
						});
						if(!validator.form())
							e.preventDefault();
						else
						{
							e.preventDefault();
							var dataString = $('#feedback-form').serialize();
							$.ajax(
									{
										type: 'POST',
										url: baseDir + 'feedback.php',
										data: dataString,
										dataType: 'json',
										success: function(result){
											if(result.feedback_status == 'succeeded')
											{
												$('#feedback-form').fadeOut();
												$('#fb_thanks').fadeIn();
												Recaptcha.reload();
												window.setTimeout(function(){
													$.fancybox.close();
													$('#feedback-form').fadeIn();
													$(':input','#feedback-form').not(':button, :submit, :hidden').val('');
													$('#fb_thanks').fadeOut();
												}, 3000);
											}
											else if(result.feedback_status == 'invalid_recaptcha')
											{
												$('.recaptcha_error').fadeIn();
												$('#error_container ol').fadeIn();
												$('#error_container').fadeIn();
											}
										}
									});
						}
					});
		
					$('#feedback_button').fancybox({
							'transitionIn'	:	'elastic',
							'transitionOut'	:	'elastic',
							'speedIn'		:	600, 
							'speedOut'		:	200, 
							'overlayShow'	:	true,
							'height'		:	500,
							'width'			:   700,
			        		'hideOnContentClick':false
					});

				});
			{/literal}

			$(function(){
		    	$('img.lazy').asynchImageLoader({
		            timeout: 500,
		            effect: 'fadeIn',
		            speed: 1000,
		            event:'load'
		        });
		    });

			var RecaptchaOptions = {
				    theme : 'clean'
			};
		</script>
		
	</head>
	
	<body {if $page_name}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if}>
	{if !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
		<div id="restricted-country">
			<p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
		</div>
		{/if}
		<div id="violet-bar">
    		<div style="width:980px;margin:auto;">
    			<div id="header_user_info" style="position:absolute;margin:0">
    			    <div style="position:relative; display: block; text-align: left; width: 500px;color:white;float:left">care@violetbag.com | +91-80-65655500 (10 AM to 7 PM (IST), Mon to Sat)</div>
    				{if $cookie->isLogged()}
    					<a rel="nofollow" href="{$link->getPageLink('vcoins.php', true)}" title="{l s='Your Account' mod='blockuserinfo'}">{l s='My Account' mod='blockuserinfo'}</a> 
    					| <span>{$cookie->customer_firstname|escape:'htmlall':'UTF-8'} {$cookie->customer_lastname|escape:'htmlall':'UTF-8'}</span>
    					(<a rel="nofollow" href="{$link->getPageLink('index.php')}?mylogout" title="{l s='Log me out' mod='blockuserinfo'}">{l s='Log out' mod='blockuserinfo'}</a>)
    					
    				{else}
    					<a rel="nofollow" href="{$link->getPageLink('authentication.php?back=index.php', true)}">{l s='Log in | Signup' mod='blockuserinfo'}</a>
    				{/if}
    			</div>
    		</div>
			
			<div id="feedback-button-panel" style="position:fixed;right:0px; top:250px;">
				<a rel="nofollow" id="feedback_button" href="#feedback-panel" style="cursor: pointer"><img src="{$img_ps_dir}feedback.png" alt="feedback" /></a>
			</div>
		</div>
		<div id="page">

			<!-- Header -->
			<div id="header">
				<div id="header_right">
					<div id="header_logo">
						<a  href="{$base_dir}" title="{$shop_name|escape:'htmlall':'UTF-8'}">
							<img class="logo" src="{$img_ps_dir}logo.png?{$img_update_time}" alt="{$shop_name|escape:'htmlall':'UTF-8'}" />
						</a>
					</div>
					{$HOOK_TOP}
				</div>
			</div>

			<div id="columns">
			{if isset($bannername)}
				<a href="{$link->getmanufacturerLink($manufacturer->id, $manufacturer->link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$manufacturer->name|escape:'htmlall':'UTF-8'} products">
					<img src="{$img_ps_dir}brands/{$bannername}.jpg" width="980"  height="169" alt="{$manufacturer->name|escape:'htmlall':'UTF-8'}" />
				</a>
			{/if}
				<!-- Left -->
				<div id="left_column" class="column">
					{$HOOK_LEFT_COLUMN}
				</div>

				<!-- Center -->
				<div id="center_column">
	{/if}
