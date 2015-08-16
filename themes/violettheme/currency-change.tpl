<div style="float:left">
    {section name=currency loop=$currencies}
        {if $currencies[currency].id_currency eq $cookie->id_currency}
            <span id="currhead">My currency :</span>
            <span id="currimg">{$currencies[currency].sign}</span>
            <span id="currtext">{$currencies[currency].iso_code}</span>
            <span> | </span>
            <a id='change_curr' href="#">change</a>
        {/if}
    {/section}
</div>
{literal}
    <script type="text/javascript" >
        $(document).ready(function() {
            $("#change_curr").click(function(){
                if( $("#curr_menu").css("display") == 'none' ) {
                    $("#curr_menu").slideDown();
                } else {
                    $("#curr_menu").slideUp();
                }
            });
        });
    </script>
{/literal}
