{assign var='color1' value='#FCF6CF'}   {* Even *} 
{assign var='color2' value='#FEFEF2'}   {* Odd *}
{assign var='i' value=1}

<table border="1" style="border-color: #CCC; text-align: left; background-color:#FEFEF2;border-collapse:collapse; margin:10px 0 10px 0">
    <thead>
        <tr>
            {section name=head loop=$headers}
                {if $i++ is odd by 1}
                    {assign var='cellbg' value=$color1}
                {else}  
                    {assign var='cellbg' value=$color2}
                {/if}   
                <th width="{$headers[head][1]}" style="background-color:{$cellbg}">{$headers[head][0]}</th>
            {/section}
        </tr>   
    <thead> 
    <tbody>
        {section name=row loop=$result}
            <tr>
                {foreach from=$result[row] item=v key=k}
                    {if $i++ is odd by 1}
                        {assign var='cellbg' value=$color1}
                    {else} 
                        {assign var='cellbg' value=$color2}
                    {/if}     
                    <td style="background-color:{$cellbg}">{$v}</td>
                {/foreach}
            </tr>
        {/section} 
    </tbody>
</table>
