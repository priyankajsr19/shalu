<div style="background-color: #ffffff !important; margin: 0; padding: 0">
    <div class="block-center" id="block-wishlist_items">
        {if $campaigns && count($campaigns)}
        <table id="campaigns-list" class="table" cellspacing="0" cellpadding="0" style="width:75%">
                <thead>
                        <tr>
                                <th class="first_item" style="text-align:left;">Campaign Name</th>
                                <th class="item" style="text-align:left;">Template</th>
                                <th class="item" style="text-align:right;">Date Added</th>
                                <th class="item" style="text-align:right;">Scheduled Time</th>
                                <th class="item" style="text-align:right;">Created By</th>
                                
                                <th class="last_item" style="text-align:right;">Status</th>
                        </tr>
                </thead>
                <tbody>
                {foreach from=$campaigns item=campaign}
                        <tr>
                                <td class="" style="text-align:left;">{$campaign.campaign_name}</td>
                                <td class="" style="text-align:left;">{$campaign.template}</td>
                                <td class="" style="text-align:right;">{$campaign.date_add}</td>
                                <td class="" style="text-align:right;">{$campaign.scheduled_time}</td>
                                <td class="" style="text-align:right;">{$campaign.created_by}</td>
                                <td class="" style="text-align:right;">
                                    {if $campaign.status eq 0}
                                        Not Scheduled
                                    {elseif $campaign.status eq 1}
                                        Scheduled
                                    {elseif $campaign.status eq 99}
                                        Running
                                    {elseif $campaign.status eq 2}
                                        Completed
                                    {/if}
                                </td>
                        </tr>
                {/foreach}
                </tbody>
        </table>
        {else}
                <span>No Campaigns</span>
        {/if}
    </div>
</div>