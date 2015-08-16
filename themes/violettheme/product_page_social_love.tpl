	<div id="social-love" style="vertical-align:top;height:24px;">
                <a href="http://pinterest.com/pin/create/button/?url={$canonical_url|escape:'url'}&media={$og_image_url|escape:'url'}&description={$product->name|escape:'url'}" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
                <div style="display:inline-block;vertical-align:top">
                    <div class="g-plusone" data-annotation="none" data-callback="plusClick"></div>
                    {literal}
                        <script type="text/javascript">
                (function() {
                    var po = document.createElement('script');
                    po.type = 'text/javascript';
                    po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(po, s);
                })();
                        </script>
                    {/literal}
                </div>
                <div style="display:inline-block;vertical-align:top;padding:0px 5px;">
                    <div class="fb-like" data-send="false" data-width="300" data-show-faces="false" data-font="arial"></div>
                </div>
            </div>
