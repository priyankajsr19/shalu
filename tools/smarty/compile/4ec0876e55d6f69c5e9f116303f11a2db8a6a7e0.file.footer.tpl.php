<?php /* Smarty version Smarty-3.0.7, created on 2015-08-16 17:58:58
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150611155555d0820a1f85c8-23788039%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ec0876e55d6f69c5e9f116303f11a2db8a6a7e0' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/themes/violettheme/footer.tpl',
      1 => 1437833296,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150611155555d0820a1f85c8-23788039',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Applications/XAMPP/xamppfiles/htdocs/indusdiva2/tools/smarty/plugins/modifier.escape.php';
?>        <?php if (!$_smarty_tpl->getVariable('content_only')->value){?>
                </div>

<!-- Right -->
                <div id="right_column" class="column">
                    <?php echo $_smarty_tpl->getVariable('HOOK_RIGHT_COLUMN')->value;?>

                </div>
            </div>

<!-- Footer -->
            <div id="footer"><?php echo $_smarty_tpl->getVariable('HOOK_FOOTER')->value;?>
</div>
        </div>
    <?php }?>
    <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./shipping-modal.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    <?php if (!$_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
        <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('tpl_dir')->value)."./login_modal.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
        <script type="text/javascript">
         /*$(document).ready(function() {
             var isOldVisitor = $.cookie('old-visitor');
             if(!isOldVisitor){
                 $('#login_link').trigger('click');
                 $.cookie('old-visitor', '1', { expires: 1 });
             }
         });*/
        </script>
    <?php }else{ ?>
        <script type="text/javascript">
            $.cookie('old-visitor', '1', { expires: 1 });
        </script>
    <?php }?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("img,a.newzoom").live("contextmenu",function(){
                    return false;
                });
            });     
        </script>
    
         
        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='//cdn.zopim.com/?8MOFK3CnQYH1ytv1x1OJ3PRl5oYTminW';z.t=+new Date;$.
        type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
        </script>
        <!--End of Zopim Live Chat Script-->
        
        
        <?php if ($_smarty_tpl->getVariable('cookie')->value->isLogged()){?>
                <script type="text/javascript">
                $zopim(function() {
                    $zopim.livechat.set( {
                      name: "<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('cookie')->value->customer_firstname,'htmlall','UTF-8');?>
 <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('cookie')->value->customer_lastname,'htmlall','UTF-8');?>
",
                      email: "<?php echo $_smarty_tpl->getVariable('cookie')->value->email;?>
"
                    } );
                  } );
                                    
                </script>
        <?php }?>
       
        
        <script type="text/javascript">
            var _ss_track = {};
          
            /* your customization options */
            _ss_track.options = {'chat_show':false};
        
            /* Donot edit below this line */
            _ss_track.id = "f2f39117-bb31-490e-90d9-6e003779f669";
            _ss_track.events = []; _ss_track.handlers = []; _ss_track.alarms = [];
            (function() {
                var ss = document.createElement('script'); ss.type = 'text/javascript'; ss.async = true; ss.id = "__ss";
                ss.src = '//d1011upzeqfr3c.cloudfront.net/static/ssclient.min.js';
                var fs = document.getElementsByTagName('script')[0]; fs.parentNode.insertBefore(ss, fs);
            })();
        </script>
        
        
                <script type="text/javascript"> 
                        (function() {
                                var a = document.createElement('script');a.type = 'text/javascript'; a.async = true; 
                                a.src=('https:'==document.location.protocol?'https://':'http://cdn.')+'chuknu.sokrati.com/249/tracker.js';
                                var s = document.getElementsByTagName('script')[0];
                                s.parentNode.insertBefore(a, s);
                        })();
                </script>
        

    
        <script type="text/javascript">
            adroll_adv_id = "ECTRVXZTQ5B3VDC3WZRYQM";
            adroll_pix_id = "IB2H4VTPCRBV3LQCOMMGKQ";
            (function () {
                var oldonload = window.onload;
                window.onload = function() {
                    __adroll_loaded=true;
                    var scr = document.createElement("script");
                    var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
                    scr.setAttribute('async', 'true');
                    scr.type = "text/javascript";
                    scr.src = host + "/j/roundtrip.js";
                    ((document.getElementsByTagName('head') || [null])[0] || document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
                    if(oldonload) {
                        oldonload()
                    }
                };
            }());
        </script>
    

        <?php if (isset($_smarty_tpl->getVariable('new_customer_regd',null,true,false)->value)&&$_smarty_tpl->getVariable('new_customer_regd')->value==true){?>
            
                <script type="text/javascript">
            function addRegPixel() {
                            try {
                    _sok_reg_pixel();
                    console.log("Added Reg to Sokrati"); 
                            } catch(err) {
                    window.setTimeout(addRegPixel,1000);
                    console.log("Exception Adding Reg to Sokrati"); 
                            }
            }
            window.setTimeout(addRegPixel,1000);
                </script>
            
        <?php }?>
        <!-- Google Code for Remarketing tag -->
        <script type="text/javascript">
        /* <![CDATA[ */
        var google_tag_params = {
            <?php if ($_smarty_tpl->getVariable('page_name')->value=='product'){?>
                ecomm_pagetype: '<?php echo $_smarty_tpl->getVariable('page_name')->value;?>
',
                ecomm_prodid:'<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
',
                <?php if (!$_smarty_tpl->getVariable('priceDisplay')->value||$_smarty_tpl->getVariable('priceDisplay')->value==2){?>
                    ecomm_totalvalue:'<?php echo $_smarty_tpl->getVariable('product')->value->getPrice(true,@NULL,2);?>
'
                <?php }elseif($_smarty_tpl->getVariable('priceDisplay')->value==1){?>
                    ecomm_totalvalue:'<?php echo $_smarty_tpl->getVariable('product')->value->getPrice(false,@NULL,2);?>
'
                <?php }?>
            <?php }elseif($_smarty_tpl->getVariable('page_name')->value=='category'||$_smarty_tpl->getVariable('page_name')->value=='index'){?>
                ecomm_pagetype: '<?php echo $_smarty_tpl->getVariable('page_name')->value;?>
'
            <?php }?>
        };
        var google_conversion_id = 1011353032;
        var google_conversion_label = "oW6RCPiLmgMQyIug4gM";
        var google_custom_params = window.google_tag_params;
        var google_remarketing_only = true;
        /* ]]> */
        </script>
        <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
        </script>
        <noscript>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1011353032/?value=0&amp;label=oW6RCPiLmgMQyIug4gM&amp;guid=ON&amp;script=0"/>
        </div>
        </noscript>

	<script type="text/javascript">
		(function() {
			window._pa = window._pa || {};
			// _pa.orderId = "myOrderId"; // OPTIONAL: attach unique conversion identifier to conversions
			// _pa.revenue = "19.99"; // OPTIONAL: attach dynamic purchase values to conversions
			// _pa.productId = "myProductId"; // OPTIONAL: Include product ID for use with dynamic ads
			var pa = document.createElement('script'); pa.type = 'text/javascript'; pa.async = true;
			pa.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + "//tag.perfectaudience.com/serve/54f594239b0e4ceadd0000e4.js";
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(pa, s);
		})();
	</script>
    </body>
</html>
