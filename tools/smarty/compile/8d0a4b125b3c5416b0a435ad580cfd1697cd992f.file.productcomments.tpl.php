<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 17:58:05
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/productcomments//productcomments.tpl" */ ?>
<?php /*%%SmartyHeaderCode:83855422955d081d5105631-29550014%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d0a4b125b3c5416b0a435ad580cfd1697cd992f' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/modules/productcomments//productcomments.tpl',
      1 => 1437832876,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '83855422955d081d5105631-29550014',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/tools/smarty/plugins/modifier.escape.php';
?> <?php if (isset($_smarty_tpl->getVariable('submit_confirmation',null,true,false)->value)){?>
<script type="text/javascript">
		$(document).ready(function(){
			$.fancybox({
                'content' : '<?php echo $_smarty_tpl->getVariable('submit_confirmation')->value;?>
'
            });
			window.setTimeout(function(){
					$.fancybox.close();
				}, 3000);
		});
	</script>
<?php }?>

<div id="reviews_section" class="clearfix">
	<script type="text/javascript"
		src="<?php echo $_smarty_tpl->getVariable('module_dir')->value;?>
js/jquery.rating.pack.js"></script>
	<script type="text/javascript">
	$(function(){ $('input[@type=radio].star').rating(); });
	$(function(){
		$('.auto-submit-star').rating({
			callback: function(value, link){
			}
		});
	});
	
	//close  comment form
	function closeCommentForm(){
		$('#sendComment').slideUp('fast');
		$('input#addCommentButton').fadeIn('slow');
	}
	
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
	
</script>
	<h2>Reviews for <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'htmlall','UTF-8');?>
</h2>
	<div style="padding: 10px 0px; width: 100%; float: left;">
		<?php if ($_smarty_tpl->getVariable('comments')->value){?>
		<div style="width: 60%; float: left" itemprop="aggregateRating"
			itemscope itemtype="http://schema.org/AggregateRating">
			<div style="font-size: 16px; width: 120px; float: left">Overall
				Rating:</div>
			<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['average']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['loop'] = is_array($_loop=6) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['name'] = 'average';
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['average']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['average']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['average']['total']);
?> <input
				class="auto-submit-star" disabled="disabled" type="radio"
				name="average" <?php if (round($_smarty_tpl->getVariable('averageTotal')->value)!=0&&$_smarty_tpl->getVariable('smarty')->value['section']['average']['index']==round($_smarty_tpl->getVariable('averageTotal')->value)){?>checked="checked" <?php }?> /> <?php endfor; endif; ?> <span
				style="color: #939393; padding-left: 5px;">(<span
				itemprop="ratingValue"><?php echo round($_smarty_tpl->getVariable('averageTotal')->value);?>
</span>/5 based on <span
				itemprop="reviewCount"><?php echo count($_smarty_tpl->getVariable('comments')->value);?>
</span> reviews)
			</span>
		</div>
		<?php }else{ ?>
		<div style="width: 60%; float: left">No customer review for
			<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'htmlall','UTF-8');?>
</div>
		<?php }?> <?php if ($_smarty_tpl->getVariable('too_early')->value==true){?>
		<p class="align_center"></p>
		<?php }elseif($_smarty_tpl->getVariable('cookie')->value->isLogged()==true||$_smarty_tpl->getVariable('allow_guests')->value==true){?>
		<div
			style="width: 30%; float: left; padding-left: 20px; text-align: center">
			<input style="margin: auto;" class="button_large" type="button"
				id="addCommentButton"
				value="<?php echo smartyTranslate(array('s'=>'Write a review','mod'=>'productcomments'),$_smarty_tpl);?>
"
				onclick="$('#sendComment').slideDown('fast');$(this).slideUp('slow');" />
			<span style="color: #939393; font-size: 12px">+5 Diva Coins on
				approved review!</span>
				<a id="guideline_button" href="#review-guidelines" class="span_link"> <span style="color: #939393; font-size: 12px">(Review guidelines)</span></a>
		</div>
		<?php }else{ ?>
		<div
			style="width: 30%; float: left; padding-left: 20px; text-align: center">
			<a style="margin: auto;" class="button_large" type="button"
				id="addReviewButton"
				value="<?php echo smartyTranslate(array('s'=>'Write a review','mod'=>'productcomments'),$_smarty_tpl);?>
" rel="nofollow"
				href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('authentication.php?back=product.php',true);?>
?id_product=<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
">Login
				and write review</a> 
				<span style="color: #939393; font-size: 12px">+5 Diva Coins on approved review!</span>
				<a id="guideline_button" href="#review-guidelines" class="span_link"> <span style="color: #939393; font-size: 12px">(Review guidelines)</span></a>
		</div>
		<?php }?>

		<form action="<?php echo $_smarty_tpl->getVariable('action_url')->value;?>
" method="post" id="sendComment"
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

				<?php if (count($_smarty_tpl->getVariable('criterions')->value)>0){?> <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('criterions')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>

				<div style="width: 100px; float: left">
					<input type="hidden" id="star_rating"
						name="id_product_comment_criterion_<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['iteration'];?>
"
						value="<?php echo intval($_smarty_tpl->getVariable('criterions')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id_product_comment_criterion']);?>
"
						class="text required" />
					<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('criterions')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['name'],'html','UTF-8');?>
 :
				</div>
				<input class="star" type="radio"
					name="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['iteration'];?>
_grade"
					id="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['iteration'];?>
_grade" value="1" /> <input
					class="star" type="radio"
					name="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['iteration'];?>
_grade" value="2" /> <input
					class="star" type="radio"
					name="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['iteration'];?>
_grade" value="3" /> <input
					class="star" type="radio"
					name="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['iteration'];?>
_grade" value="4" /> <input
					class="star" type="radio"
					name="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['i']['iteration'];?>
_grade" value="5" /> <?php endfor; endif; ?>
				<?php }?> <?php if ($_smarty_tpl->getVariable('allow_guests')->value==true&&$_smarty_tpl->getVariable('cookie')->value->isLogged()==false){?>
				<p>
					<label for="customer_name"><?php echo smartyTranslate(array('s'=>'Your name:','mod'=>'productcomments'),$_smarty_tpl);?>
</label><input
						type="text" name="customer_name" id="customer_name" />
				</p>
				<?php }?>
				<p style="padding: 5px 0 0 0; clear: both;">
					<label for="comment_title"><?php echo smartyTranslate(array('s'=>'Title:','mod'=>'productcomments'),$_smarty_tpl);?>
</label><br />
					<input type="text" name="title" id="comment_title"
						style="width: 100%" class="text required" />
				</p>
				<p style="padding: 0px">
					<label for="content"><?php echo smartyTranslate(array('s'=>'Review:','mod'=>'productcomments'),$_smarty_tpl);?>
</label><br />
					<textarea rows="5" name="content" id="content" style="width: 100%"
						class="text required"></textarea>
				</p>
				<p class="submit" style="text-align: center">
					<input class="button" name="submitMessage"
						value="<?php echo smartyTranslate(array('s'=>'Submit','mod'=>'productcomments'),$_smarty_tpl);?>
" type="submit"
						style="margin: auto;" />
				</p>
			</fieldset>
		</form>
	</div>

	<?php if ($_smarty_tpl->getVariable('comments')->value){?>
	<div id="review-head"
		style="clear: both; padding: 5px 0px; margin-top: 10px; font-size: 13px;">
		Showing 1-<?php echo count($_smarty_tpl->getVariable('comments')->value);?>
 of <?php echo count($_smarty_tpl->getVariable('comments')->value);?>
 reviews</div>
	<div id="review-list" style="width: 100%;">
		<?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('comments')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value){
?> <?php if ($_smarty_tpl->tpl_vars['comment']->value['content']){?>
		<div
			style="padding: 15px 5px; border-bottom: 1px dashed #cacaca; float: left; width: 100%"
			itemprop="reviews" itemscope itemtype="http://schema.org/Review">
			<div style="width: 20%; float: left;">
				<div style="color: #666666">
					<span itemprop="author"><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['comment']->value['customer_name'],'html','UTF-8');?>
.</span>
				</div>
				<div style="color: #939393"><?php echo Tools::dateFormat(array('date'=>smarty_modifier_escape($_smarty_tpl->tpl_vars['comment']->value['date_add'],'html','UTF-8'),'full'=>0),$_smarty_tpl);?>
</div>
			</div>
			<div style="width: 80%; float: left;">
				<div>
					<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['loop'] = is_array($_loop=6) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['name'] = 'rating';
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['rating']['total']);
?> <input
						class="auto-submit-star" disabled="disabled" type="radio"
						name="review_rating_<?php echo $_smarty_tpl->tpl_vars['comment']->value['id_product_comment'];?>
"
						value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['rating']['index'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['comment']->value['grade'])&&round($_smarty_tpl->tpl_vars['comment']->value['grade'])!=0&&$_smarty_tpl->getVariable('smarty')->value['section']['rating']['index']==round($_smarty_tpl->tpl_vars['comment']->value['grade'])){?>checked="checked" <?php }?> /> <?php endfor; endif; ?> <strong><span
						style="padding-left: 10px; font-size: 16px"><?php echo $_smarty_tpl->tpl_vars['comment']->value['title'];?>
</span></strong>
					<h3 class="product_review">Review for:
						<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name,'htmlall','UTF-8');?>
</h3>
				</div>
				<?php if (isset($_smarty_tpl->tpl_vars['comment']->value['grade'])){?>
				<div itemprop="reviewRating" itemscope
					itemtype="http://schema.org/Rating" style="display: none">
					<span itemprop="reviewRating"><?php echo $_smarty_tpl->tpl_vars['comment']->value['grade'];?>
</span>
				</div>
				<?php }?>
				<div style="padding-top: 5px; font-size: 10pt">
					<span itemprop="reviewBody">
						<?php echo nl2br(smarty_modifier_escape($_smarty_tpl->tpl_vars['comment']->value['content'],'html','UTF-8'));?>
 </span>
				</div>
			</div>
		</div>
		<?php }?> <?php }} ?>
	</div>
	<?php }?>
	<div style="display:none">
	<div id="review-guidelines" style="width:600px;height:250px;text-align:left;padding:10px;border:1px dashed #cacaca">
    	<h2 style="text-align:center">Review Guidelines</h2>
    	<span>Review should contain at least 50 words and a maximum of 500 words, it would be apt to review a product you have personally purchased from the website.</span><br/>
    	<span>For added value, it is best to include:</span>
    	<ul style="padding:10px 0">
    		<li>1. The best aspect of the product, could be style, design or of the like?</li>
    		<li>2. Anything specific you like or dislike about the product.</li>
    		<li>3. How to use the product?</li>
    		<li>4. Anything specific you like or dislike about the product.</li>
    		<li>5.  Is it worth the money? Would you recommend it?</li>
    	</ul>
    	<span>Talk about the relevant product, direct comparison with other products is not advisable.</span><br />
    	<span>Please refrain from posting promotional content or personal info.</span><br />
    	<span>Would help to be grammatically correct.</span>
    </div>
    </div>
</div>



