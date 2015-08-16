{if $error|default:'' neq ''}
<div style="border-color:#F00; color:#F00; padding:5px;">
    {$error}
</div>
{/if}
<div style="background-color: #ffffff !important; margin: 0; padding: 0">
    {if $preview eq 'true'}
        {$previewMail}
    {/if}
</div>