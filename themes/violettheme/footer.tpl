        {if !$content_only}
                </div>

<!-- Right -->
                <div id="right_column" class="column">
                    {$HOOK_RIGHT_COLUMN}
                </div>
            </div>

<!-- Footer -->
            <div id="footer">{$HOOK_FOOTER}</div>
        </div>
    {/if}
    {*
    <div style="display:none">
                <div id="feedback-panel" style="text-align:left;border:1px dashed #cacaca;width:500px;">
                    <form id="feedback-form" action="{$base_dir}feedback.php?submitfeedback=1">
                        <input type="hidden" name="ajax" value="true"/>
                        <div id="error_container" class="error_container">
                            <h4>There are errors:</h4>
                            <ol>
                                <li><label for="fb_name" class="error">Please enter your name</label></li>
                                <li><label for="fb_email" class="error">Please enter your email address</label></li>
                                <li><label for="fb_content" class="error">Non empty feedback please</label></li>
                                <li class="recaptcha_error"><label class="error recaptcha_error">Please type in the correct text from image.</label></li>
                            </ol>
                        </div>
                        <h2>Please let us know what you think about our service.</h2>
                        <p style="padding:0px 0.5em;">Give us inputs, criticize us, comment, anything.</p>
                        <div style="padding:10px 20px;">
                            <p class="text" style="padding:5px 0px;">
                                <label for="fb_email">{l s='E-mail'}</label>
                                <br />
                                <span><input type="text" id="fb_email" name="fb_email" value="" class="text" style="font-size:15px;width:200px"/></span>
                            </p>
                            <p class="required text" style="padding:5px 0px;">
                                <label for="lastname">{l s='Name'}</label>
                                <br />
                                <input class="text" type="text" id="fb_name" name="fb_name" value="" style="font-size:15px;width:200px"/>
                            </p>
                            <p class="required text" style="padding:5px 0px;">
                                <label for="fb_content">{l s='Feedback'}</label>
                                <br />
                                <textarea class="text required" type="text" id="fb_content" name="fb_content" value="" style="width:440px;height:150px;font-size:15px"></textarea>
                            </p>
                            <p>
                                <label>{l s='Please type the text from image below:'}</label>
                                <br />
                                {$recaptchaHTML}
                            </p>
                            <input id="submit_feedback" type="submit" value="Send" class="button exclusive_large" style="margin:auto; margin-top:10px;" />
                        </div>
                    </form>
                    <div id="fb_thanks" style="display:none;padding:30px;font-size:15px;">
                        <p>Thanks for your feedback.</p>
                    </div>
                </div>
            </div>
            *}
    {include file="$tpl_dir./shipping-modal.tpl"}
    {if !$cookie->isLogged()}
        {include file="$tpl_dir./login_modal.tpl"}
        <script type="text/javascript">
         /*$(document).ready(function() {
             var isOldVisitor = $.cookie('old-visitor');
             if(!isOldVisitor){
                 $('#login_link').trigger('click');
                 $.cookie('old-visitor', '1', { expires: 1 });
             }
         });*/
        </script>
    {else}
        <script type="text/javascript">
            $.cookie('old-visitor', '1', { expires: 1 });
        </script>
    {/if}
        <script type="text/javascript">
            $(document).ready(function() {
                $("img,a.newzoom").live("contextmenu",function(){
                    return false;
                });
            });     
        </script>
    
         {literal}
        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='//cdn.zopim.com/?8MOFK3CnQYH1ytv1x1OJ3PRl5oYTminW';z.t=+new Date;$.
        type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
        </script>
        <!--End of Zopim Live Chat Script-->
        {/literal}
        
        {if $cookie->isLogged()}
                <script type="text/javascript">
                $zopim(function() {
                    $zopim.livechat.set( {
                      name: "{$cookie->customer_firstname|escape:'htmlall':'UTF-8'} {$cookie->customer_lastname|escape:'htmlall':'UTF-8'}",
                      email: "{$cookie->email}"
                    } );
                  } );
                                    
                </script>
        {/if}
       
        {literal}
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
        {/literal}
        {literal}
                <script type="text/javascript"> 
                        (function() {
                                var a = document.createElement('script');a.type = 'text/javascript'; a.async = true; 
                                a.src=('https:'==document.location.protocol?'https://':'http://cdn.')+'chuknu.sokrati.com/249/tracker.js';
                                var s = document.getElementsByTagName('script')[0];
                                s.parentNode.insertBefore(a, s);
                        })();
                </script>
        {/literal}

    {literal}
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
    {/literal}

        {if isset($new_customer_regd) && $new_customer_regd eq true}
            {literal}
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
            {/literal}
        {/if}
        <!-- Google Code for Remarketing tag -->
        <script type="text/javascript">
        /* <![CDATA[ */
        var google_tag_params = {literal}{{/literal}
            {if $page_name eq 'product'}
                ecomm_pagetype: '{$page_name}',
                ecomm_prodid:'{$product->id}',
                {if !$priceDisplay || $priceDisplay == 2}
                    ecomm_totalvalue:'{$product->getPrice(true, $smarty.const.NULL, 2)}'
                {elseif $priceDisplay == 1}
                    ecomm_totalvalue:'{$product->getPrice(false, $smarty.const.NULL, 2)}'
                {/if}
            {else if $page_name eq 'category' OR $page_name eq 'index'}
                ecomm_pagetype: '{$page_name}'
            {/if}
        {literal}};{/literal}
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
