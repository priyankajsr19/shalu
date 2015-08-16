{literal}
<script type="text/javascript">
//<![CDATA[

	$(document).ready(function() {
		$('.measure_link').fancybox({
			fitToView : true,
			margin:0,
			padding:0
		});

	    $('.delete_measurement').click(function(e){
			if(!confirm('Delete this measurement?'))
				e.preventDefault();
		});
	});

//]]>
</script>
{/literal}

<div style="width:970px;">
        {assign var='selitem' value='measurements'}
	{include file="$tpl_dir./myaccount_menu.tpl"}
	<div class="vtab-content">
		<h1 style="padding:10px 0;text-align:center;border-bottom:1px dashed #cacaca">Measurements</h1>
		{if isset($blouse_measurements)}
		<div style="border-bottom:1px dashed #cacaca;float:left; clear:both; width:100%;margin:10px;padding:10px 0">
		    <h2>BLOUSE MEASUREMENTS</h2>
		    <div style="width:440px;padding:0px;float:right">
		        <img src="{$img_ps_dir}styles/blouse-measurement-choli.jpeg" alt="measurement info"/>
			</div>
		    {foreach from=$blouse_measurements item=measurement name=blouse_measurements}
		        <ul class="measurement-list">
		            <li style="padding:5px 0;text-align:center;border-bottom:1px dashed #cacaca;text-transform:capitalize;font-size:14px;">{$measurement.name_measurement}</li>
		            <li><span class="measurement-label">A. Front Length: </span>{$measurement.A}</li>
		            <li class="even"><span class="measurement-label">B. Back Length: </span>{$measurement.B}</li>
		            <li><span class="measurement-label">C. Neck Deep: </span>{$measurement.C}</li>
		            <li class="even"><span class="measurement-label">D. Front Shape: </span>{$measurement.D}</li>
		            <li><span class="measurement-label">E. Bust: </span>{$measurement.E}</li>
		            <li class="even"><span class="measurement-label">F. Upper Waist: </span>{$measurement.F}</li>
		            <li><span class="measurement-label">G. Arm Hole: </span>{$measurement.G}</li>
		            <li class="even"><span class="measurement-label">H. Sleeve Length: </span>{$measurement.H}</li>
		            <li><span class="measurement-label">I. Sleeve Loose: </span>{$measurement.I}</li>
		            <li class="even"><span class="measurement-label">J. Back Deep: </span>{$measurement.J}</li>
		            <li><span class="measurement-label">K. Shoulder: </span>{$measurement.K}</li>
		            <li class="even"><span class="measurement-label">L. Long Choli Front Length: </span>{$measurement.L}</li>
		            <li style="padding:10px;margin-top:10px;border-top:1px dashed #cacaca;">
		                <a class="span_link measure_link fancybox.ajax" style="display:inline-block; float:left" href="{$base_dir}measurement.php?&modal=1&m=1&type=1&id_measurement={$measurement.id_measurement}"><span>Update</span></a>
		                <a class="span_link delete_measurement" style="display:inline-block; float:right" href="{$base_dir}measurement.php?delete=1&id={$measurement.customer_measurement_id}"><span style="color:red">Delete</span></a>
		            </li>
		        </ul>
		        {if $smarty.foreach.blouse_measurements.first == true}
		        	<div style="clear:both;width:100%"></div>
		        {/if}
		    {/foreach}
		    
		</div>
		
		{/if}
		
		{if isset($skirt_measurements)}
		<div style="border-bottom:1px dashed #cacaca;float:left; clear:both;width:100%">
			<div style="width:520px;float:left">
			    <h2>INSKIRT/LEHENGA MEASUREMENTS</h2>
			    {foreach from=$skirt_measurements item=measurement}
			        <ul class="measurement-list">
			            <li style="padding:5px 0;text-align:center;border-bottom:1px dashed #cacaca;text-transform:capitalize;font-size:14px;">{$measurement.name_measurement}</li>
			            <li><span class="measurement-label">A. Length: </span>{$measurement.A}</li>
			            <li class="even"><span class="measurement-label">B. Waist: </span>{$measurement.B}</li>
			            <li><span class="measurement-label">C. Hips: </span>{$measurement.C}</li>
			            <li style="padding:10px;margin-top:10px;border-top:1px dashed #cacaca;">
			                <a class="span_link measure_link fancybox.ajax" style="display:inline-block; float:left" href="{$base_dir}measurement.php?&modal=1&m=1&type=2&id_measurement={$measurement.id_measurement}"><span>Update</span></a>
			                <a class="span_link delete_measurement" style="display:inline-block; float:right" href="{$base_dir}measurement.php?delete=1&id={$measurement.customer_measurement_id}"><span style="color:red">Delete</span></a>
			            </li>
			        </ul>
			    {/foreach}
			</div>
			<div style="width:240px;padding:0px;float:right">
				<img src="{$img_ps_dir}styles/skirt-measurement.jpg" alt="measurement info"/>
			</div>
		</div>
		{/if}
		
		{if isset($kurta_measurements)}
		<div style="border-bottom:1px dashed #cacaca;float:left; clear:both; width:100%">
		    <h2>KURTA MEASUREMENTS</h2>
		    <div style="width:220px;padding:0px;float:right">
		        <img src="{$img_ps_dir}styles/kurta2.png" alt="measurement info" width="100%"/>
			</div>
		    {foreach from=$kurta_measurements item=measurement}
		        <ul class="measurement-list">
		            <li style="padding:5px 0;text-align:center;border-bottom:1px dashed #cacaca;text-transform:capitalize;font-size:14px;">{$measurement.name_measurement}</li>
		            <li><span class="measurement-label">A. Top Length: </span>{$measurement.A}</li>
		            <li class="even"><span class="measurement-label">B. Body Length: </span>{$measurement.B}</li>
		            <li><span class="measurement-label">C. Shoulder: </span>{$measurement.C}</li>
		            <li class="even"><span class="measurement-label">D. Arm Hole: </span>{$measurement.D}</li>
		            <li><span class="measurement-label">E. Sleeve Length: </span>{$measurement.E}</li>
		            <li class="even"><span class="measurement-label">F. Sleeve Loose: </span>{$measurement.F}</li>
		            <li><span class="measurement-label">G. Neck Deep: </span>{$measurement.G}</li>
		            <li class="even"><span class="measurement-label">H. Front Shape: </span>{$measurement.H}</li>
		            <li><span class="measurement-label">I. Chest: </span>{$measurement.I}</li>
		            <li class="even"><span class="measurement-label">J. Waist: </span>{$measurement.J}</li>
		            <li><span class="measurement-label">K. Hips: </span>{$measurement.K}</li>
		            <li style="padding:10px;margin-top:10px;border-top:1px dashed #cacaca;">
		                <a class="span_link measure_link fancybox.ajax" style="display:inline-block; float:left" href="{$base_dir}measurement.php?&modal=1&m=1&type=3&id_measurement={$measurement.id_measurement}"><span>Update</span></a>
		                <a class="span_link delete_measurement" style="display:inline-block; float:right" href="{$base_dir}measurement.php?delete=1&id={$measurement.customer_measurement_id}"><span style="color:red">Delete</span></a>
		            </li>
		        </ul>
		    {/foreach}
		</div>
		{/if}
		
		{if isset($anarkali_measurements)}
		<div style="border-bottom:1px dashed #cacaca;float:left; clear:both; width:100%">
		    <h2>ANARKALI KURTA MEASUREMENTS</h2>
		    <div style="width:220px;padding:0px;float:right">
		        <img src="{$img_ps_dir}styles/anarkali-2.png" alt="measurement info" width="100%"/>
			</div>
		    {foreach from=$anarkali_measurements item=measurement}
		        <ul class="measurement-list">
		            <li style="padding:5px 0;text-align:center;border-bottom:1px dashed #cacaca;text-transform:capitalize;font-size:14px;">{$measurement.name_measurement}</li>
		            <li><span class="measurement-label">A. Top Length: </span>{$measurement.A}</li>
		            <li class="even"><span class="measurement-label">B. Body Length: </span>{$measurement.B}</li>
		            <li><span class="measurement-label">C. Shoulder: </span>{$measurement.C}</li>
		            <li class="even"><span class="measurement-label">D. Arm Hole: </span>{$measurement.D}</li>
		            <li><span class="measurement-label">E. Sleeve Length: </span>{$measurement.E}</li>
		            <li class="even"><span class="measurement-label">F. Sleeve Loose: </span>{$measurement.F}</li>
		            <li><span class="measurement-label">G. Neck Deep: </span>{$measurement.G}</li>
		            <li class="even"><span class="measurement-label">H. Front Shape: </span>{$measurement.H}</li>
		            <li><span class="measurement-label">I. Chest: </span>{$measurement.I}</li>
		            <li class="even"><span class="measurement-label">J. Waist: </span>{$measurement.J}</li>
		            <li><span class="measurement-label">K. Hips: </span>{$measurement.K}</li>
		            <li style="padding:10px;margin-top:10px;border-top:1px dashed #cacaca;">
		                <a class="span_link measure_link fancybox.ajax" style="display:inline-block; float:left" href="{$base_dir}measurement.php?&modal=1&m=1&type=5&id_measurement={$measurement.id_measurement}"><span>Update</span></a>
		                <a class="span_link delete_measurement" style="display:inline-block; float:right" href="{$base_dir}measurement.php?delete=1&id={$measurement.customer_measurement_id}"><span style="color:red">Delete</span></a>
		            </li>
		        </ul>
		    {/foreach}
		</div>
		{/if}
		
		{if isset($salwar_measurements)}
		<div style="width:100%;border-bottom:1px dashed #cacaca;float:left; clear:both;">
			<div style="width:520px;float:left">
			    <h2>SALWAR MEASUREMENTS</h2>
			    {foreach from=$salwar_measurements item=measurement}
			        <ul class="measurement-list">
			            <li style="padding:5px 0;text-align:center;border-bottom:1px dashed #cacaca;text-transform:capitalize;font-size:14px;">{$measurement.name_measurement}</li>
			            <li><span class="measurement-label">A. Waist: </span>{$measurement.A}</li>
			            <li class="even"><span class="measurement-label">B. Length: </span>{$measurement.B}</li>
			            <li><span class="measurement-label">C. Knee Length: </span>{$measurement.C}</li>
			            <li class="even"><span class="measurement-label">D. Knee Loose: </span>{$measurement.D}</li>
			            <li><span class="measurement-label">E. Thigh: </span>{$measurement.E}</li>
			            <li class="even"><span class="measurement-label">F. Ankle Loose: </span>{$measurement.F}</li>
			            <li style="padding:10px;margin-top:10px;border-top:1px dashed #cacaca;">
			                <a class="span_link measure_link fancybox.ajax" style="display:inline-block; float:left" href="{$base_dir}measurement.php?&modal=1&m=1&type=4&id_measurement={$measurement.id_measurement}"><span>Update</span></a>
			                <a class="span_link delete_measurement" style="display:inline-block; float:right" href="{$base_dir}measurement.php?delete=1&id={$measurement.customer_measurement_id}"><span style="color:red">Delete</span></a>
			            </li>
			        </ul>
			    {/foreach}
			</div>
			<div style="width:240px;padding:0px;float:right">
				<img src="{$img_ps_dir}styles/salwar-measurement.jpg" alt="measurement info"/>
			</div>
		</div>
		{/if}
		
		
		{if !isset($blouse_measurements) && !isset($salwar_measurements) && !isset($anarkali_measurements) && !isset($kurta_measurements) && !isset($skirt_measurements)}
		    <p style="font-size:18px;text-align:center;color:#cacaca">No saved Measurements</p>
		{/if}
	</div>
</div>
