<div class="vtab-bar">
    <ul id="my_account_links">
        
            {if $selitem eq 'identity'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}identity.php" title="{l s='Information'}">{l s='Personal Info'}</a></div>
            </li>
            
            {if $selitem eq 'history'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}history.php" title="{l s='Orders'}">{l s='Orders'}</a>
            </li>
            
            {if $selitem eq 'addresses'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}addresses.php" title="{l s='My Address Book'}">{l s='My Address Book'}</a></div>
            </li>
            
            {if $selitem eq 'measurements'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}measurements.php" title="{l s='My Measurements'}">{l s='My Measurements'}</a></div>
            </li>
            
            {if $selitem eq 'wishlist'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}wishlist.php" title="{l s='My Wishlist'}">{l s='My Wishlist'}</a></div>
            </li>
            
            
            {if $selitem eq 'vouchers'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}discount.php" title="{l s='Vouchers'}">{l s='My Vouchers'}</a></div>
            </li>
            
            {if $selitem eq 'points'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}idpoints.php" title="{l s='Indus Diva Coins'}">{l s='Indusdiva Coins'}</a></div>
            </li>
            
            {if $selitem eq 'referral'}
                <li class='selected'>
            {else}
                <li>
            {/if}
                <div class="vtab-bar-link"><a href="{$base_dir_ssl}referral.php" title="{l s='Referrals'}">{l s='Referrals'}</a></div>
            </li>
    </ul>
</div>