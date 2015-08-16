<table border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff" width="650px">
  <tbody>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td style="width:30px"> </td>
              <td style="width:590px">
                <a href="http://www.indusdiva.com/?{$utm_url}" target="_blank"><img alt="INDUSDIVA" border="0" height="36" src="http://www.indusdiva.com/img/logo.jpg" width="238" /></a>
              </td>
              <td style="width:30px"> </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td align="left" style="height: 45px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td style="width:30px"> </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111; font-weight:bold">
                <a href="http://www.indusdiva.com/2-sarees?{$utm_url}" style="color: #000; text-decoration: none" target="_blank">SAREES</a>
              </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111; font-weight:bold">
                <a href="http://www.indusdiva.com/3-salwar-kameez?{$utm_url}" style="color: #000; text-decoration: none; margin-left:15px;" target="_blank">SALWAR KAMEEZ</a>
              </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111; font-weight:bold">
                <a href="http://www.indusdiva.com/4-kurtis-tunics?{$utm_url}" style="color: #000; text-decoration: none; margin-left:15px;" target="_blank">KURTIS &amp; TUNICS</a>
              </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111; font-weight:bold">
                <a href="http://www.indusdiva.com/5-lehengas?{$utm_url}" style="color: #000; text-decoration: none; margin-left:15px;" target="_blank">LEHENGAS</a>
              </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111; font-weight:bold">
                <a href="http://www.indusdiva.com/454-jewelry?{$utm_url}" style="color: #000; text-decoration: none; margin-left:15px;" target="_blank">JEWELRY</a>
              </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111; font-weight:bold">
                <a href="http://www.indusdiva.com/1175-handbags?{$utm_url}" style="color: #000; text-decoration: none; margin-left:15px;" target="_blank">HANDBAGS</a>
              </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111;  font-weight:bold">
                <a href="http://www.indusdiva.com/476-kids-wear?{$utm_url}" style="color: #000; text-decoration: none; margin-left:15px;" target="_blank">KIDS</a>
              </td>
              <td style="font-family: Tahoma, sans-serif; font-size: 11px; color:#111111;  font-weight:bold">
                <a href="http://www.indusdiva.com/513-menswear?{$utm_url}" style="color: #000; text-decoration: none; margin-left:15px;" target="_blank">MEN</a>
              </td>
              <td style="width:30px"> </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td align="center" colspan="3" style="padding-bottom: 10px">
                <a href="{$b_utm_url}" target="blank"><img alt="{$c_name}" src="{$b_image}" style="height: 337px; width: 630px;" /></a>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td align="center" height="40px">
                <img src="http://cdn.indusdiva.com/img/wrap_writeup.png" width="59px" height="16px"/>
              </td>
            </tr>
            <tr>
              <td align="center" >
                <span style="font-style:12px; font-weight:bold; color:#111111; font-family: Tahoma, sans-serif">{$write_up}</span>
              </td>
            </tr>
            <tr>
              <td align="center" height="40px">
                <img src="http://cdn.indusdiva.com/img/wrap_writeup.png" width="59px" height="16px"/>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td width="60%" align="center" style="vertical-align:middle">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td align="center" height="50px">
                      <a href="{$lp_url}" target="_blank" style="text-decoration:none"><span style="color:#111111; font-family: tahoma, geneva, sans-serif; font-size:14px; font-weight:bold">{$lp_name}</span></a>
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      {if isset($lp_sprice) && !empty($lp_sprice) && $lp_price neq $lp_sprice}
                        <span style="font-family: tahoma, geneva, sans-serif;text-decoration:line-through; color:#666">US$ {$lp_price}</span>&nbsp;<span style="font-family: tahoma, geneva, sans-serif;">US$ {$lp_sprice}</span>
                      {else}
                        <span style="font-family: tahoma, geneva, sans-serif; font-size:14px; font-weight:normal">US$ {$lp_sprice}</span>
                      {/if}
                    </td>
                  </tr>
                  <tr>
                    <td height="20px"></td>
                  </tr>
                  <tr>
                    <td align="center"><span style="font-family: tahoma, geneva, sans-serif; font-size:11px">{$lp_desc|truncate:300}</span></td>
                  </tr>
                </table>
              </td>
              <td width="40%" align="center">
                <span style="font-size:12px;">
                  <span style="font-family: tahoma, geneva, sans-serif;">
                    <a href="{$lp_url}" target="_blank"> <img alt="{$lp_name}" src="{$lp_image}" style="border-width: 0px; border-style: solid; width: 260px; height: 350px;" /></a>
                  </span>
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td height="20px"></td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              {assign var=i value=-1}
              {section name='sloop' start=0 loop=3 step=1}
              {assign var=i value=$i+1}
              <td align="center" width="33%">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td align="center">
                        <a href="{$otherp_info[$i].url}" style="" target="_blank"><img alt="{$otherp_info[$i].name}" src="{$otherp_info[$i].image}" style="border-width: 0px; border-style: solid; width: 180px; height: 246px;" /></a>
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                        {if isset($otherp_info[$i].sprice) && !empty($otherp_info[$i].sprice) && $otherp_info[$i].sprice neq $otherp_info[$i].price}
                          <span style="font-family: tahoma, geneva, sans-serif;text-decoration:line-through;color:#666">US$ {$otherp_info[$i].price}</span>&nbsp;<span style="font-family: tahoma, geneva, sans-serif;">US$ {$otherp_info[$i].sprice}</span>
                        {else}
                          <span style="font-family: tahoma, geneva, sans-serif;">US$ {$otherp_info[$i].price}</span>
                        {/if}
                      </td>
                    </tr>
                    <tr>
                      <td align="center">
                          <span style="font-size:12px;font-family: tahoma, geneva, sans-serif;">
                            <a href="{$otherp_info[$i].url}" style="color:#111111; text-decoration: none; padding: 10px 0 0 0;" target="_blank">{$otherp_info[$i].name}</a>
                          </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
              {/section}
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="60px">
          <tbody>
            <tr>
              <td align="center">
                <p style="text-align:center;margin:0;padding:10px;clear:both;">
                  <a href="{$a_utm_link}" style="background:#ee8c3b;width:180px;color:white!important;padding:5px 20px;border-radius:3px;font:bold 13px 'Arial'!important;min-height:26px!important;text-align:center;text-decoration:none" target="_blank" title="shop now">SHOP NOW</a>
                </p>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="60px">
          <tbody>
            <tr>
              <td align="center">
                <img src="{$u_image|default:''}" alt="up-next" height="60px" width="600px"/>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="60px">
          <tbody>
            <tr>
              <td align="center">
                <img alt="Its safe shopping with us. Accepting PayPal, Visa, MasterCard and American Express. 128 bit SSL secured" src="http://www.elabs11.com/content/2011000046/Mailer-Footer.jpg" />
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td align="center" height="40px">
                <span style="font-size:10px;font-family: tahoma, geneva, sans-serif;">care@indusdiva.com |  +91-80-67309079 (24x7) | Connect with us</span>
                &nbsp;
                <a href="https://www.facebook.com/IndusDiva"> <img alt="IndusDiva on Facebook" src="http://www.elabs11.com/content/2011000046/facebook.png" style="width: 21px; height: 21px;" /></a>
                &nbsp;
                <a href="http://twitter.com/IndusDiva"><img alt="IndusDIva on Twitter" src="http://www.elabs11.com/content/2011000046/twitter.png" style="width: 21px; height: 21px;" /></a>
                &nbsp;
                <a href="http://pinterest.com/indusdiva/"><img alt="IndusDiva on Pintrest" src="http://www.elabs11.com/content/2011000046/pintrest.png" style="width: 21px; height: 21px;" /></a>
                &nbsp;
                &nbsp;
                &nbsp;
                <a href="http://www.indusdiva.com?{$utm_url}" style="text-decoration:none;color:#111"><span style="font-size:10px;font-family: tahoma, geneva, sans-serif;">www.indusdiva.com</span></a>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td align="center">
                <span style="font-family: Tahoma, sans-serif; font-size: 10px; line-height: 12px; color: #3b3434; text-align: center;">
                    You opted in to this receive this newsletter from IndusDiva. 
                    Click <a style="text-decoration:underline" href="http://www.indusdiva.com/newsletter.php?unsub_key={$unsub_key}">here</a> to unsubscribe
                </span>`
                <span style="font-size:12px;font-family: tahoma, geneva, sans-serif;">&copy;2012 indusdiva.com</span>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
