<div class="sz_popup">
    <ul class="tabs clearfix">
        <li id="lnk_this" class="active">SIZE CHART</li>
        <li id="lnk_intl" class="inactive">SIZE GUIDE</li>
    </ul>
    <div class="sz_popup_wrap" id="intl_size_chart" style="display:none; width:auto">
        {include file="$tpl_dir./intl_size_map.tpl"}
    </div>
    <div class="sz_popup_wrap" id="this_size_chart" style="display:block: width:auto">
        <div style="margin:0px auto" class="sizechart_data">
            <div style="border-bottom:1px dashed #cacaca">
                <h1>SIZE CHART</h1>
            </div>
	    {$sizechart_data}
        </div>
    </div>
</div>

{literal}
<script type="text/javascript">
$("#lnk_this").click(function(){
    $("#intl_size_chart").hide();
    $("#this_size_chart").show();
    $(this).removeClass("inactive").addClass("active");
    $("#lnk_intl").removeClass("active").addClass("inactive");
});
$("#lnk_intl").click(function(){
    $("#intl_size_chart").show();
    $("#this_size_chart").hide();
    $(this).removeClass("inactive").addClass("active");
    $("#lnk_this").removeClass("active").addClass("inactive");
});
</script>
{/literal}
