
<div>
	<div style="float:left;margin:10px;border:1px dashed #cacaca;width:720px;">
		<div style="border-bottom:1px dashed #cacaca; text-transform:uppercase">
			{if isset($measurement)}
					<h1>EDIT MEASUREMENT: {$measurement.name_measurement}</h1>
			{else}
			<h1>NEW MEASUREMENT</h1>
			{/if}
		</div>
		<div id="measurement_error" style="display:none">
			<span style="color:red;font-size:18px;">Something went wrong! Could not save measurement.</span>
		</div>
		<div id="measurement_errors" class="error_container">
			<ol style="list-style-type:none">
			</ol>
		</div>
		<p style="color:#999999">Please select a standard measurement by waist size or select "Customized" and enter your body measurement.</p>
		<form action="measurement.php" method="post" id="measurement_form" style="padding:10px;">
			<table width="500px" cellspacing="0" style="float:left; margin-top:40px;">
			<tbody>
			<tr style="background:#DFDFDF">				
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_left">&nbsp;</td>
				<td width="30%" align="right" style="border-top: 1px solid #505050;" class="measurement_middle">WAIST SIZE (inches): </td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="1" name="mntSize" rel="Waist: 28" {if isset($measurement)}disabled{/if}><br>
				<b>28</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="2" name="mntSize" rel="Waist: 29" {if isset($measurement)}disabled{/if}><br>
				<b>29</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="3" name="mntSize" rel="Waist: 30" {if isset($measurement)}disabled{/if}><br>
				<b>30</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="4" name="mntSize" rel="Waist: 32" {if isset($measurement)}disabled{/if}><br>
				<b>32</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="5" name="mntSize" rel="Waist: 34" {if isset($measurement)}disabled{/if}><br>
				<b>34</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="6" name="mntSize" rel="Waist: 36" {if isset($measurement)}disabled{/if}><br>
				<b>36</b>
				</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" checked="" value="Custom" name="mntSize"><br>
				<b>Customized</b>
				</td>{/if}				
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>A</b></td>
				<td width="30%" align="left" class="measurement_middle">Length</td>
				<td width="10%" align="center" class="measurement_middle">39</td>
				<td width="10%" align="center" class="measurement_middle">39.5</td>
				<td width="10%" align="center" class="measurement_middle">40</td>
				<td width="10%" align="center" class="measurement_middle">40.5</td>
				<td width="10%" align="center" class="measurement_middle">41</td>
				<td width="10%" align="center" class="measurement_middle">42</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="A" id="A" value="{if isset($measurement)}{$measurement.A}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
		
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>B</b></td>
				<td width="20%" align="left" class="measurement_middle">Waist</td>
				<td width="10%" align="center" class="measurement_middle">28</td>
				<td width="10%" align="center" class="measurement_middle">29.5</td>
				<td width="10%" align="center" class="measurement_middle">30</td>
				<td width="10%" align="center" class="measurement_middle">32</td>
				<td width="10%" align="center" class="measurement_middle">34</td>
				<td width="10%" align="center" class="measurement_middle">36.5</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="B" id="B" value="{if isset($measurement)}{$measurement.B}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>C</b></td>
				<td width="20%" align="left" class="measurement_middle">Hips</td>
				<td width="10%" align="center" class="measurement_middle">34.5</td>
				<td width="10%" align="center" class="measurement_middle">36</td>
				<td width="10%" align="center" class="measurement_middle">38.5</td>
				<td width="10%" align="center" class="measurement_middle">40.5</td>
				<td width="10%" align="center" class="measurement_middle">44.5</td>
				<td width="10%" align="center" class="measurement_middle">48.5</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="C" id="C" value="{if isset($measurement)}{$measurement.C}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>
		<td colspan="7" style="text-align:left">*All Measurements in Inches</td>
		</tr>
		</tbody>
		</table>
			<div style="width:200px;padding:0px;float:left">
				<img src="{$img_ps_dir}styles/skirt-measurement.jpg" alt="measurement info" height="250"/>
			</div>
			<div id="measurement-alias" style="padding:0 10px;text-align:left;float:left">
				{if isset($measurement)}
					<span>Measurement Name: {$measurement.name_measurement}</span>
				{else}
					{if $cookie->isLogged()}<span style="color:#999999">Please select a name to save this measurement. For example Me, Mom, Aditi</span>
					<br/>
					<span>Measurement For:</span>
					<input id="name_measuremnet" name="name_measurement" class="text required" value="" size="20" style="font-size:15px;height:15px;line-height:18px;height:18px;"/>{/if}
				{/if}
			</div>
			<p class="submit" style="clear:both;text-align:center; padding:10px 0">
				<input type="hidden" name="type_measurement" value="2"/>
				<input type="button" id="SubmitMeasurement" name="SubmitMeasurement" class="button_large" value="{l s='Save'}" style="display:inline-block"/>
				{if isset($measurement)}
					<input type="hidden" name="id_measurement" value="{$measurement.id_measurement}"/>
				{/if}
			</p>
		</form>
		<span id="measurement_done" style="display:none; font-size:18px; color:green">Measurement saved.</span>
	</div>
</div>

<script type="text/javascript">
{if isset($measurement)}
var edit = true;
{else}
var edit = false;
{/if}
// <![CDATA[
{literal}
var containerCreate = $('#measurement_errors');
$('input:radio[name=mntSize]').click(function(){
	if($('input:radio[name=mntSize]:checked').val() == 'Custom') {
		$('.custom_fields').addClass('required number');
		$('#measurement-alias').addClass('required');
		$('#measurement-alias').show();
	}
	else
	{
		$('.custom_fields').removeClass('required').removeClass('number');
		$('#measurement-alias').removeClass('required');
		$('#measurement-alias').hide();
		$("#measurement_form").validate({
			errorContainer: containerCreate,
			errorLabelContainer: $("ol", containerCreate),
			wrapper: 'li',
			meta: "validate",
			groups: {
			    measurements: "name_measurement A B C"
			  },
			  errorPlacement: function(error, element) {
			       error.insertAfter(containerCreate);
			   }
		});
		$("label.error").hide();
		$(".error").removeClass("error");
		$('#measurement_errors').hide();
	}
});

$('#SubmitMeasurement').click(function(e){
	e.preventDefault();
	var containerCreate = $('#measurement_errors');
	// validate the form when it is submitted
	if($('input:radio[name=mntSize]:checked').val() == 'Custom') {
		$('.custom_fields').addClass('required number');
		var validator = $("#measurement_form").validate({
			errorContainer: containerCreate,
			errorLabelContainer: $("ol", containerCreate),
			wrapper: 'li',
			meta: "validate",
			groups: {
			    measurements: "name_measurement A B C"
			  },
			  errorPlacement: function(error, element) {
			       error.insertAfter(containerCreate);
			   }
		});
		if(!validator.form())
		{
			return;
		}

		var dataString = $('#measurement_form').serialize();
		dataString = dataString + "&ajax=1&SubmitMeasurement=1";
		$.ajax(
				{
					type: 'POST',
					url: baseDir + 'measurement.php',
					data: dataString,
					dataType: 'json',
					success: function(result){
						if(result.status == 'succeeded')
						{
							$('#measurement_form').fadeOut();
							$('#measurement_done').fadeIn();
							if(!edit)
							{
    							$('#skirt_measurement_id').append('<option value='+result.id_measurement+'>'+result.name+'</option>');
    							$('#skirt_measurement_id').val(result.id_measurement);
    							$('#skirt_measurement_id').show();

    							window.setTimeout(function(){
								$.fancybox.close();
							    }, 2000);
							}
							else
						    {
						    	window.setTimeout(function(){
									location.reload(); 
								}, 1000);
						    }
						}
						else if(result.status == 'error')
						{
							$('#measurement_error').fadeIn();
						}
					}
		});
	}
	else
	{
		$('#measurement_form').fadeOut();
		$('#skirt_measurement_id').val($('input:radio[name=mntSize]:checked').val());
		$.fancybox.close();
	}
});
{/literal}
</script>