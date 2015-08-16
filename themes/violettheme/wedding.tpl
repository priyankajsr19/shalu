{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            $("body").css("background","url('http://cdn.indusdiva.com/img/wedding/new_wed_bg.jpg') repeat-x");
            $("#logo_link").css("background","url('http://cdn.indusdiva.com/img/divalogo.png') no-repeat scroll 0 0 transparent");

            $("a.subbanner").mouseover(function(){
                var subtext = $(this).find(".subtext");
                $(subtext).css("background-color","#a32413");
                $(subtext).find(".subhead").css("color","#FFF");
                $(subtext).find(".subtext_t").css("color","#F99");
                $(this).find(".subline").css("background-color","#a32413");
            }).mouseout(function(){
                var subtext = $(this).find(".subtext");
                $(subtext).css("background-color","#eee");
                $(subtext).find(".subhead").css("color","#000");
                $(subtext).find(".subtext_t").css("color","#333");
                $(this).find(".subline").css("background-color","#eee");
            });

            $('#enquiry_form').submit(function(e) {

                var container = $('#enquiry_error_container');
                // validate the form when it is submitted
                var validator = $("#enquiry_form").validate( {
                    errorContainer: container,
                    errorLabelContainer: $("ol", container),
                    wrapper: 'li',
                    meta: "validate"
                } );            
                if(validator.form()) {
                    $("#submitEnquiry").hide();

                    var data = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: baseDir + "designenquiries.php",
                        data: data,
                        success: function() {
                            $('#enquiry_form').fadeOut();
                            $("#contact_response").fadeIn();
                        }
                    });
                }
                e.preventDefault();
                return false;
            });    

        });
    </script>
{/literal}

<div class="wedding_closet clearfix">
    <div class="main_image" style="position:relative">
        <img src="{$img_ps_dir}{$main_banner[0]}" class="zoom" style="position:absolute">
        <div class="maintext {$page}">{$main_banner[1]}</div>
    </div>
    {if $page neq "happybeginnings"}
        <ul class="cat">
            {foreach from=$other_banners key=k item=v}
            <li>
                <a href="{$v[2]}" class="subbanner">
                    <div class="sub_image">
                        <img src="{$img_ps_dir}{$v[0]}" class="zoom">
                    </div>
                    <div class="subtext">
                        <span class="subhead">{$k}</span>
                        <span class="subtext_t">{$v[1]}</span>
                    </div>
                    <div class="subline"></div>
                    <div class="shopnow"></div>
                    <div class="separator"></div>
                </a>
            </li>
            {/foreach} 
        </ul>
    {else}
        <ul class="testimonials">
            {section name=testimonial loop=$testimonials}
                <li>
                    <blockquote class="standard">
                        {$testimonials[testimonial][0]}
                        <cite class="standard">{$testimonials[testimonial][1]}</cite>
                    </blockquote>
                </li>
            {/section}
        </ul>
        <div class="contact">
            <p class="t1">So are you set for a happy beginning in your life? Let us help you design your dream outfit.</p>
            <p class="t2">We understand that on this special day of your life you need that unique attire which is synonymous to who you are. To make it all easier, we provide you the choice to make any outfit in our wedding closet customized to your color, fabric, size and pattern choice. After all you are the queen and the queen deserves the best.</p>
            <form id="enquiry_form"  style="margin:auto;padding:10px">
                <div id="enquiry_error_container" class="error_container">
                    <h4>There are errors:</h4>
                    <ol>
                        <li><label for="name" class="error">Please enter your name</label></li>
                        <li><label for="email" class="error">Please enter your email</label></li>
                        <li><label for="phone" class="error">Please enter your phone number</label></li>
                        <li><label for="country" class="error">Please enter country</label></li>
                        <li><label for="enquiry" class="error">Non empty enquiry please</label></li>
                    </ol>
                </div>
                <fieldset>
                    <h1 style="padding:10px 0; border-bottom:1px dashed #cacaca;text-align:center">CONTACT US</h1>
                    <p>
                        <span style="width:100px;display:inline-block"><label>Name:</label></span><br>
                        <input type="text" name="name" id="name" class="required text">
                    </p>
                    <p>
                        <span style="width:100px;display:inline-block"><label>Email:</label></span><br>
                        <input type="text" name="email" id="email" class="required email">
                    </p>
                    <p>
                        <span style="width:100px;display:inline-block"><label>Phone:</label></span><br>
                        <input type="text" name="phone" id="phone" class="required text">
                    </p>
                    <p>
                        <span style="width:100px;display:inline-block"><label>Your Country:</label></span><br>
                        <input type="text" name="country" id="country" class="required text">
                    </p>
                    <p>
                        <label>Your enquiry:</label> <br>
                        <textarea value="" name="enquiry" id="enquiry" type="text" rows="4" class="text required" style="height:180px;"></textarea>
                    </p>
                </fieldset>
                <p class="submit2" style="padding:0">
                    <input type="submit" name="submitEnquiry" id="submitEnquiry" value="Send Enquiry" class="button" style="margin:auto;width:150px;">
                </p>
            </form>
            <div id="contact_response" style="display:none; margin-top:50px; border:1px dashed #cacaca">
                <h1 style="padding:10px 0; border-bottom:1px dashed #cacaca;text-align:center">ENQUIRY SENT</h1>
                <div>
                    <h2 style="text-align:center;padding:20px;font-size:18px;color:#A41E21">Thank you for writing to us!</h2>
                    <p>Thanks for your interest with us, we will contact you shortly with regards to your enquiry.</p>
                </div>
            </div>
        </div>
    {/if}
</div>
