<div id="curr_menu">
    <div class="curr_msg">Please choose your Currency.</div>
    <ul class="clearfix">
        {section name=currency loop=$currencies}
            {if $currencies[currency].id_currency eq $cookie->id_currency} 
                <li class="selected">
            {else}
                <li>
            {/if}
                    <a class="clearfix" title="{$currencies[currency].name}" href="javascript:setCurrency({$currencies[currency].id_currency});">
                        <span class="currimg curr_{$currencies[currency].iso_code}"></span>
                        <span class="currsign">{$currencies[currency].sign}</span>
                        {if $currencies[currency].sign neq $currencies[currency].iso_code}
                            <span class="currtext">{$currencies[currency].iso_code}</span>
                        {/if}
                    </a>
                </li>
        {/section}
    </ul>
    {*<div class="curr_disclaimer"> * Please note that we do not accept payments in MYR and AED.However you can browse with these currencies but the equivalent USD value is processed at the time of placing the order. </div>*}
</div>
<div id="currencies_block_top" style="display:none">
    <form id="setCurrency" action="{$request_uri}" method="post">
        <input type="hidden" name="id_currency" id="id_currency" value="" />
        <input type="hidden" name="SubmitCurrency" value="" />
    </form>
</div>
