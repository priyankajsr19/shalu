 {if isset($submit_confirmation)}
<script type="text/javascript">
		$(document).ready(function(){literal}{{/literal}
			$.fancybox({
                'content' : '{$submit_confirmation}'
            });
			window.setTimeout(function(){
					$.fancybox.close();
				}, 3000);
		{literal}}{/literal});
	</script>
{/if}

<div id="reviews_section">
	<script type="text/javascript"
		src="{$module_dir}js/jquery.rating.pack.js"></script>
	<script type="text/javascript">
	$(function(){literal}{{/literal} $('input[@type=radio].star').rating(); {literal}}{/literal});
	$(function(){literal}{{/literal}
		$('.auto-submit-star').rating({literal}{{/literal}
			callback: function(value, link){literal}{{/literal}
			{literal}}{/literal}
		{literal}}{/literal});
	{literal}}{/literal});
	
	//close  comment form
	function closeCommentForm(){ldelim}
		$('#sendComment').slideUp('fast');
		$('input#addCommentButton').fadeIn('slow');
	{rdelim}
	{literal}
		$(document).ready(function(){
			$('#sendComment').submit(function(e){
				
				if($('input[name="1_grade"]').attr('value') == '')
				{
					$('#rw_error_container li').hide();
					$('.ratingError').fadeIn();
					$('#rw_error_container').fadeIn();
					e.preventDefault();
					return;
				}
				
				var container = $('#rw_error_container');
				// validate the form when it is submitted
				var validator = $("#sendComment").validate({
					errorContainer: container,
					errorLabelContainer: $("ol", container),
					wrapper: 'li',
					meta: "validate"
				});
				if(!validator.form())
					e.preventDefault();
			});

			$('#status_button').fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	true,
				'height'		:	100,
				'width'			:   100,
        		'hideOnContentClick':false
			});

			$('a#guideline_button').fancybox({
				'hideOnContentClick':false,
				'autoDimensions' : true
			});
		});
	{/literal}
</script>
	<h2>Reviews for {$product->name|escape:'htmlall':'UTF-8'}</h2>
	<div style="padding: 10px 0px; width: 100%; float: left;">
		{if $comments}
		<div style="width: 60%; float: left" itemprop="aggregateRating"
			itemscope itemtype="http://schema.org/AggregateRating">
			<div style="font-size: 16px; width: 120px; float: left">Overall
				Rating:</div>
			{section loop=6 step=1 start=1 name=average} <input
				class="auto-submit-star" disabled="disabled" type="radio"
				name="average" {if $averageTotal|round
				neq 0 and $smarty.section.average.index
				eq $averageTotal|round}checked="checked" {/if} /> {/section} <span
				style="color: #939393; padding-left: 5px;">(<span
				itemprop="ratingValue">{round($averageTotal)}</span>/5 based on <span
				itemprop="reviewCount">{$comments|@count}</span> reviews)
			</span>
		</div>
		{else}
		<div style="width: 60%; float: left">No customer review for
			{$product->name|escape:'htmlall':'UTF-8'}</div>
		{/if} {if $too_early == true}
		<p class="align_center"></p>
		{elseif $cookie->isLogged() == true || $allow_guests == true}
		<div
			style="width: 30%; float: left; padding-left: 20px; text-align: center">
			<input style="margin: auto;" class="button_large" type="button"
				id="addCommentButton"
				value="{l s='Write a review' mod='productcomments'}"
				onclick="$('#sendComment').slideDown('fast');$(this).slideUp('slow');" />
			<span style="color: #939393; font-size: 12px">+ 25 Violet Coins on
				approved review!</span>
				<a id="guideline_button" href="#review-guidelines" class="span_link"> <span style="color: #939393; font-size: 12px">(Review guidelines)</span></a>
		</div>
		{else}
		<div
			style="width: 30%; float: left; padding-left: 20px; text-align: center">
			<a style="margin: auto;" class="button_large" type="button"
				id="addReviewButton"
				value="{l s='Write a review' mod='productcomments'}" rel="nofollow"
				href="{$link->getPageLink('authentication.php?back=product.php', true)}?id_product={$product->id}">Login
				and write review</a> 
				<span style="color: #939393; font-size: 12px">+25 Violet Coins on approved review!</span>
				<a id="guideline_button" href="#review-guidelines" class="span_link"> <span style="color: #939393; font-size: 12px">(Review guidelines)</span></a>
		</div>
		{/if}

		<form action="{$action_url}" method="post" id="sendComment"
			style="display: none; padding: 15px; border: 1px dashed #cacaca; float: left; width: 675px; margin-top: 10px;">
			<p class="align_right" style="margin: 0px;">
				<a href="javascript:closeCommentForm()">X</a>
			</p>
			<div id="rw_error_container" class="error_container">
				<h4>There are errors:</h4>
				<ol>
					<li><label for="comment_title" class="error">Please enter a title</label></li>
					<li><label for="content" class="error">Please enter a feedback</label></li>
					<li class="ratingError"><label for="1_grade" class="error">Please
							select a rating</label></li>
				</ol>
			</div>
			<fieldset>

				{if $criterions|@count > 0} {section loop=$criterions name=i start=0
				step=1}

				<div style="width: 100px; float: left">
					<input type="hidden" id="star_rating"
						name="id_product_comment_criterion_{$smarty.section.i.iteration}"
						value="{$criterions[i].id_product_comment_criterion|intval}"
						class="text required" />
					{$criterions[i].name|escape:'html':'UTF-8'} :
				</div>
				<input class="star" type="radio"
					name="{$smarty.section.i.iteration}_grade"
					id="{$smarty.section.i.iteration}_grade" value="1" /> <input
					class="star" type="radio"
					name="{$smarty.section.i.iteration}_grade" value="2" /> <input
					class="star" type="radio"
					name="{$smarty.section.i.iteration}_grade" value="3" /> <input
					class="star" type="radio"
					name="{$smarty.section.i.iteration}_grade" value="4" /> <input
					class="star" type="radio"
					name="{$smarty.section.i.iteration}_grade" value="5" /> {/section}
				{/if} {if $allow_guests == true && $cookie->isLogged() == false}
				<p>
					<label for="customer_name">{l s='Your name:' mod='productcomments'}</label><input
						type="text" name="customer_name" id="customer_name" />
				</p>
				{/if}
				<p style="padding: 5px 0 0 0; clear: both;">
					<label for="comment_title">{l s='Title:' mod='productcomments'}</label><br />
					<input type="text" name="title" id="comment_title"
						style="width: 100%" class="text required" />
				</p>
				<p style="padding: 0px">
					<label for="content">{l s='Review:' mod='productcomments'}</label><br />
					<textarea rows="5" name="content" id="content" style="width: 100%"
						class="text required"></textarea>
				</p>
				<p class="submit" style="text-align: center">
					<input class="button" name="submitMessage"
						value="{l s='Submit' mod='productcomments'}" type="submit"
						style="margin: auto;" />
				</p>
			</fieldset>
		</form>
	</div>

	{if $comments}
	<div id="review-head"
		style="clear: both; border-top: 1px dashed #cacaca; padding: 5px 0px; margin-top: 10px; font-size: 13px;">
		Showing 1-{$comments|@count} of {$comments|@count} reviews</div>
	<div id="review-list" style="width: 100%;">
		{foreach from=$comments item=comment} {if $comment.content}
		<div
			style="padding: 15px 5px; border-bottom: 1px dashed #cacaca; float: left; width: 100%"
			itemprop="reviews" itemscope itemtype="http://schema.org/Review">
			<div style="width: 20%; float: left;">
				<div style="color: #666666">
					<span itemprop="author">{$comment.customer_name|escape:'html':'UTF-8'}.</span>
				</div>
				<div style="color: #939393">{dateFormat
					date=$comment.date_add|escape:'html':'UTF-8' full=0}</div>
			</div>
			<div style="width: 80%; float: left;">
				<div>
					{section loop=6 step=1 start=1 name=rating} <input
						class="auto-submit-star" disabled="disabled" type="radio"
						name="review_rating_{$comment.id_product_comment}"
						value="{$smarty.section.rating.index}" {if
						isset($comment.grade) AND $comment.grade|round
						neq 0 AND $smarty.section.rating.index
						eq $comment.grade|round}checked="checked" {/if} /> {/section} <strong><span
						style="padding-left: 10px; font-size: 16px">{$comment.title}</span></strong>
					<h3 class="product_review">Review for:
						{$product->name|escape:'htmlall':'UTF-8'}</h3>
				</div>
				{if isset($comment.grade)}
				<div itemprop="reviewRating" itemscope
					itemtype="http://schema.org/Rating" style="display: none">
					<span itemprop="reviewRating">{$comment.grade}</span>
				</div>
				{/if}
				<div style="padding-top: 5px; font-size: 10pt">
					<span itemprop="reviewBody">
						{$comment.content|escape:'html':'UTF-8'|nl2br} </span>
				</div>
			</div>
		</div>
		{/if} {/foreach}
	</div>
	{/if}
	<div style="display:none">
	<div id="review-guidelines" style="width:600px;height:250px;text-align:left;padding:10px;border:1px dashed #cacaca">
    	<h2 style="text-align:center">Review Guidelines</h2>
    	<span>Review should contain at least 50 words and a maximum of 500 words, it would be apt to review a product you have personally experienced.</span><br/>
    	<span>For added value, it is best to include:</span>
    	<ul style="padding:10px 0">
    		<li>1. What does the product do?</li>
    		<li>2. Is it any good?</li>
    		<li>3. How to use the product?</li>
    		<li>4. Anything specific you like or dislike about the product.</li>
    		<li>5. Is it worth the money?</li>
    	</ul>
    	<span>Talk about the relevant product, direct comparison with other products is not advisable.</span><br />
    	<span>Please refrain from posting promotional content or personal info.</span><br />
    	<span>Would help to be grammatically correct.</span>
    </div>
    </div>
</div>



