-- This mail is best viewed HTML client--
{$subject}
{$write_up}
{$lp_name} - US ${$lp_price}
{assign var=i value=-1}
{section name='sloop' start=0 loop=3 step=1}
{assign var=i value=$i+1}
{$otherp_info[$i].name} - US ${$otherp_info[$i].price}
{/section}
Click here ({$a_utm_link}} to Shop Now
Unsubscribe link : www.indusdiva.com/newsletter.php?unsub_key={$unsub_key}
-- This mail is best viewed HTML client--
