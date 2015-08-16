<div class="clearfix" id="cust_height">
    <label for="cust_height_ft" style="font-size:15px;text-align:left">Select your height:</label>
    {if $as_shown|default:false eq true}
        <select id="cust_height_ft" name="cust_height_ft" class="cust_height">
    {else}
        <select id="cust_height_ft" name="cust_height_ft" disabled='disabled' class="cust_height">
    {/if}
        <option value='-1'>Feet</option>
        <option value='0'>0</option>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option>
        <option value='6'>6</option>
    </select>
    {if $as_shown|default:false eq true}
        <select id="cust_height_in" name="cust_height_in" class="cust_height">
    {else}
        <select id="cust_height_in" name="cust_height_in" disabled='disabled' class="cust_height">
    {/if}
        <option value='-1'>Inch</option>
        <option value='0'>0</option>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option>
        <option value='6'>6</option>
        <option value='7'>7</option>
        <option value='8'>8</option>
        <option value='9'>9</option>
        <option value='10'>10</option>
        <option value='11'>11</option>
    </select>
    <p>This helps us provide the perfect length to your outfit</p>
</div>
