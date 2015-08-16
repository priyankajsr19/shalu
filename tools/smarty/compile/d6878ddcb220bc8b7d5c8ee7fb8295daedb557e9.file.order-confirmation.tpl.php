<?php /* Smarty version Smarty-3.0.7, created on 2015-05-25 14:02:16
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10285480015562de10bf8c65-67850092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6878ddcb220bc8b7d5c8ee7fb8295daedb557e9' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva/themes/violettheme/order-confirmation.tpl',
      1 => 1431660623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10285480015562de10bf8c65-67850092',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript">
//<![CDATA[
	var baseDir = '<?php echo $_smarty_tpl->getVariable('base_dir_ssl')->value;?>
';
//]]>
</script>
<div id="fb-root"></div>
<script>

  window.fbAsyncInit = function() {
    FB.init({
      appId  : '285166361588635',
      status : false, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true,  // parse XFBML
      oauth : true //enables OAuth 2.0
    });
    
    $('#fbshare').click( function(){
        //FB.ui(obj, shareCallBack);
        FB.login(function (response) {
                if (response.authResponse) {
                    FB.api(
                            '/me/indusdiva:buy', 
                            'post', 
                            { product : '<?php echo $_smarty_tpl->getVariable('fbShareProductObject')->value;?>
' },
                            function(response){
                                $("#fbsharemsg").fadeIn().html("Thanks for sharing this awesome product");
                                $.ajax({
                                    type: 'GET',
                                    url: baseDir + 'feedback.php',
                                    data: 'fb_order_share=1&oid='+parseInt(<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
)+'&pid='+parseInt(<?php echo $_smarty_tpl->getVariable('fbShareProductObjectId')->value;?>
),
                                    success: function(msg)
                                    {
                                        
                                    }
                                });
                                setTimeout( function(){ $("#fbsharemsg").fadeOut() } , 4000);
                            });
                } else {
                    $("#fbsharemsg").fadeIn().html("Unable to share.Please try again");
                    setTimeout( function(){ $("#fbsharemsg").fadeOut() } , 4000);
                }
            }, {
                scope: 'publish_actions'
            }
        );
    });
  };

  (function(d){
    var js, id = 'facebook-jssdk'; 
    if (d.getElementById(id)) {
      return; // already loaded, no need to load again
    }
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
  }(document));
  
</script>
<div id="co_content">
	<div id="co_left_column" style="width:980px;">
	
		<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('done', null, null);?>
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./order-steps.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		
		<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./errors.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		<div style="width:750px; border:1px solid black; float:left;margin:20px 120px;border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;padding:10px">
		<h1 style="border-bottom:1px dashed #cacaca;padding:10px;text-align:center">Order Confirmed</h1>
		<div id="order-confirm" style="width:600px; margin:10px;">
                        <div class="clearfix">
                            <div style="float:left;font-size:21px; color:#a46bcf;font-style:bold;">Thank you for shopping with us!</div>
                            <div style="float:right; width:270px">
                                <img id="fbshare" src="../themes/violettheme/img/facebook_button.png" width="76px" height="28px"> 
                                <p class="warning" id="fbsharemsg" style="display: none"></p>
                            </div>
                        </div>
			<br /><br />
			<span style="font-size:12px; font-style:bold;">Your order #<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
 is confirmed. The expected date of shipping for your order is <b><?php echo $_smarty_tpl->getVariable('shipping_date')->value;?>
</b>. Here are the order details: </span>
			<?php if (isset($_smarty_tpl->getVariable('paymentMethod',null,true,false)->value)&&$_smarty_tpl->getVariable('paymentMethod')->value=='COD'){?>
			<br><span>Someone from our customer care team will call you within 2 business hours to verify the order. Once the verification is complete, the order will be delivered to you within 3-5 business days. </span>
			<br>
			<span>Please keep an amount of Rs. <?php echo $_smarty_tpl->getVariable('order_total')->value;?>
 ready at the time of delivery. </span>
			<?php }?>
			<?php if ($_smarty_tpl->getVariable('is_guest')->value){?>
				
				<a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('guest-tracking.php',true);?>
?id_order=<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Follow my order'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->getVariable('img_dir')->value;?>
icon/order.gif" alt="<?php echo smartyTranslate(array('s'=>'Follow my order'),$_smarty_tpl);?>
" class="icon" /></a>
				<a href="<?php echo $_smarty_tpl->getVariable('link')->value->getPageLink('guest-tracking.php',true);?>
?id_order=<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Follow my order'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Follow my order'),$_smarty_tpl);?>
</a>
			<?php }else{ ?>
			
			<?php }?>
		</div>
		<div id="block_payment_module">
			<?php echo $_smarty_tpl->getVariable('HOOK_ORDER_CONFIRMATION')->value;?>

			<?php echo $_smarty_tpl->getVariable('HOOK_PAYMENT_RETURN')->value;?>

		</div>
		
		<div id="block-order-detail" style="padding:10px;width:720px">
			<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./order-detail.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
		</div>
		</div>
	</div>
</div>
<!-- Google Code for Sale Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1011353032;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "JgbSCIiBjgMQyIug4gM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1011353032/?value=0&amp;label=JgbSCIiBjgMQyIug4gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?php if ($_smarty_tpl->getVariable('order')->value->payment!='Bank Wire'){?>
	<?php if ($_smarty_tpl->getVariable('cookie')->value->last_source=='inuxu'){?>
		<iframe src="http://inuxu.biz/Tracker/CoT?p1=1026&p2=99&p3=<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
&p4=<?php echo $_smarty_tpl->getVariable('order_total_usd')->value;?>
&p5=<?php echo $_smarty_tpl->getVariable('orderProducts')->value;?>
&p6="/>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('cookie')->value->last_source=='ibibo'){?>
		<iframe id='m3_tracker_567' name='m3_tracker_567' src='http://ads.ibibo.com/ad/www/delivery/tifr.php?trackerid=567&amp;Transaction_ID=<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
&amp;Sale_Amount=<?php echo $_smarty_tpl->getVariable('order_total_usd')->value;?>
&amp;Item_Number=<?php echo $_smarty_tpl->getVariable('totalQuantity')->value;?>
&amp;cb=%%RANDOM_NUMBER%%' frameborder='no' scrolling='no' width='0' height='0'></iframe>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('cookie')->value->last_source=='adroll'){?>
		<script type="text/javascript">
			
			adroll_adv_id = "ECTRVXZTQ5B3VDC3WZRYQM";
			adroll_pix_id = "IB2H4VTPCRBV3LQCOMMGKQ";
			adroll_conversion_value_in_dollars = "<?php echo $_smarty_tpl->getVariable('order_total_usd')->value;?>
";
			adroll_custom_data = {"ORDER_ID": "<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
"};
			(function () {
				var oldonload = window.onload;
				window.onload = function(){
					__adroll_loaded=true;
					var scr = document.createElement("script");
					var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
					scr.setAttribute('async', 'true');
					scr.type = "text/javascript";
					scr.src = host + "/j/roundtrip.js";
					((document.getElementsByTagName('head') || [null])[0] ||document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
					if(oldonload) {
						oldonload()
					}
				};
			}());
			
		</script>
	<?php }?>
<?php }?>
<script type="text/javascript">
    <!--
        _sokClient = '249';
    //-->
</script>
<script type="text/javascript">
    var sokhost = ("https:" == document.location.protocol) ? "https://tracking.sokrati.com" : "http://cdn.sokrati.com";
    var sokratiJS = sokhost + '/javascripts/tracker.js';
    document.write(unescape("%3Cscript src='" + sokratiJS + "' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var paramList = { };
paramList['lead_step'] = 'Placeordernow';
</script>
<script type="text/javascript">
    try { sokrati.trackSaleParams("0", "<?php echo $_smarty_tpl->getVariable('id_order')->value;?>
", "<?php echo $_smarty_tpl->getVariable('order_total_usd')->value;?>
", "<?php echo $_smarty_tpl->getVariable('totalQuantity')->value;?>
",paramList); }
    catch(err) { }
</script>
