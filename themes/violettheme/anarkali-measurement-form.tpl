
<div>
	<div style="float:left;margin:10px;border:1px dashed #cacaca;width:960px;">
		<div style="border-bottom:1px dashed #cacaca;text-transform:uppercase">
			{if isset($measurement)}
					<h1>EDIT MEASUREMENT: {$measurement.name_measurement}</h1>
			{else}
			<h1>ANARKALI MEASUREMENT</h1>
			{/if}
		</div>
		<div id="measurement_error" style="display:none">
			<span style="color:red;font-size:18px;">Something went wrong! Could not save measurement.</span>
		</div>
		<div id="measurement_errors" class="error_container">
			<ol style="list-style-type:none">
			</ol>
		</div>
		<p style="color:#999999">Please select a standard measurement by bust size or select "Customized" and enter your body measurement.</p>
		<p style="color:#999999">The measurements provided in our form are body measurements. If you are feeding in your own customized dimensions, even then please provide us with body measurements. These are sought to understand your body size better so that we can give you the exact same look as you see in the image ( the pattern of the kurta will be as per the picture and so will be the sleeves ). Our Design Studio shall decide the garment measurements according to the body measurements provided and design the outfit to fit you best.</p>
		<p style="color:#999999">Kindly mention your height in the special instructions box at the time of placing the order, this shall help us give you the correct length of the kurta according to the visual and according to your height.</p>
		<form action="measurement.php" method="post" id="measurement_form" style="padding:10px;">
			<table width="500px" cellspacing="0" style="float:left">
			<tbody>
			<tr style="background:#DFDFDF">				
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_left">&nbsp;</td>
				<td width="30%" align="right" style="border-top: 1px solid #505050;" class="measurement_middle">BUST SIZE (inches): </td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="1" name="mntSize" rel="Bust: 32" {if isset($measurement)}disabled{/if}><br>
				<b>32</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="2" name="mntSize" rel="Bust: 34" {if isset($measurement)}disabled{/if}><br>
				<b>34</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="3" name="mntSize" rel="Bust: 36" {if isset($measurement)}disabled{/if}><br>
				<b>36</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="4" name="mntSize" rel="Bust: 38" {if isset($measurement)}disabled{/if}><br>
				<b>38</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="5" name="mntSize" rel="Bust: 40" {if isset($measurement)}disabled{/if}><br>
				<b>40</b>
				</td>
				<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" value="6" name="mntSize" rel="Bust: 42" {if isset($measurement)}disabled{/if}><br>
				<b>42</b>
				</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="border-top: 1px solid #505050;" class="measurement_middle">
				<br><input type="radio" checked="" value="Custom" name="mntSize"><br>
				<b>Customized</b>
				</td>{/if}				
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>A</b></td>
				<td width="30%" align="left" class="measurement_middle">Top Length</td>
				<td width="10%" align="center" class="measurement_middle">42</td>
				<td width="10%" align="center" class="measurement_middle">42</td>
				<td width="10%" align="center" class="measurement_middle">43</td>
				<td width="10%" align="center" class="measurement_middle">43</td>
				<td width="10%" align="center" class="measurement_middle">44</td>
				<td width="10%" align="center" class="measurement_middle">44</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="A" id="A" value="{if isset($measurement)}{$measurement.A}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
		
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>B</b></td>
				<td width="20%" align="left" class="measurement_middle">Body Length</td>
				<td width="10%" align="center" class="measurement_middle">12.5</td>
				<td width="10%" align="center" class="measurement_middle">13</td>
				<td width="10%" align="center" class="measurement_middle">13.5</td>
				<td width="10%" align="center" class="measurement_middle">13.5</td>
				<td width="10%" align="center" class="measurement_middle">14</td>
				<td width="10%" align="center" class="measurement_middle">14.5</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="B" id="B" value="{if isset($measurement)}{$measurement.B}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>C</b></td>
				<td width="20%" align="left" class="measurement_middle">Shoulder</td>
				<td width="10%" align="center" class="measurement_middle">14.5</td>
				<td width="10%" align="center" class="measurement_middle">15</td>
				<td width="10%" align="center" class="measurement_middle">15</td>
				<td width="10%" align="center" class="measurement_middle">15.5</td>
				<td width="10%" align="center" class="measurement_middle">16</td>
				<td width="10%" align="center" class="measurement_middle">17</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="C" id="C" value="{if isset($measurement)}{$measurement.C}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>D</b></td>
				<td width="20%" align="left" class="measurement_middle">Arm Hole</td>
				<td width="10%" align="center" class="measurement_middle">19</td>
				<td width="10%" align="center" class="measurement_middle">19</td>
				<td width="10%" align="center" class="measurement_middle">19.5</td>
				<td width="10%" align="center" class="measurement_middle">19.5</td>
				<td width="10%" align="center" class="measurement_middle">20</td>
				<td width="10%" align="center" class="measurement_middle">20.5</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="D" id="D" value="{if isset($measurement)}{$measurement.D}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>E</b></td>
				<td width="20%" align="left" class="measurement_middle">Sleeve Length</td>
				<td width="10%" align="center" class="measurement_middle">5.5</td>
				<td width="10%" align="center" class="measurement_middle">5.5</td>
				<td width="10%" align="center" class="measurement_middle">5.5</td>
				<td width="10%" align="center" class="measurement_middle">6</td>
				<td width="10%" align="center" class="measurement_middle">6</td>
				<td width="10%" align="center" class="measurement_middle">6</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="E" id="E" value="{if isset($measurement)}{$measurement.E}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>F</b></td>
				<td width="20%" align="left" class="measurement_middle">Sleeve Loose</td>
				<td width="10%" align="center" class="measurement_middle">11.5</td>
				<td width="10%" align="center" class="measurement_middle">12</td>
				<td width="10%" align="center" class="measurement_middle">12.5</td>
				<td width="10%" align="center" class="measurement_middle">13</td>
				<td width="10%" align="center" class="measurement_middle">14</td>
				<td width="10%" align="center" class="measurement_middle">15</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="F" id="F" value="{if isset($measurement)}{$measurement.F}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>G</b></td>
				<td width="20%" align="left" class="measurement_middle">Neck Deep</td>
				<td width="10%" align="center" class="measurement_middle">7.5</td>
				<td width="10%" align="center" class="measurement_middle">7.5</td>
				<td width="10%" align="center" class="measurement_middle">7.5</td>
				<td width="10%" align="center" class="measurement_middle">7.5</td>
				<td width="10%" align="center" class="measurement_middle">8</td>
				<td width="10%" align="center" class="measurement_middle">8.5</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="G" id="G" value="{if isset($measurement)}{$measurement.G}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>H</b></td>
				<td width="20%" align="left" class="measurement_middle">Front Shape</td>
				<td width="10%" align="center" class="measurement_middle">11.5</td>
				<td width="10%" align="center" class="measurement_middle">12</td>
				<td width="10%" align="center" class="measurement_middle">12.5</td>
				<td width="10%" align="center" class="measurement_middle">12.5</td>
				<td width="10%" align="center" class="measurement_middle">13</td>
				<td width="10%" align="center" class="measurement_middle">14</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="H" id="H" value="{if isset($measurement)}{$measurement.H}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>I</b></td>
				<td width="20%" align="left" class="measurement_middle">Chest</td>
				<td width="10%" align="center" class="measurement_middle">32</td>
				<td width="10%" align="center" class="measurement_middle">34</td>
				<td width="10%" align="center" class="measurement_middle">36</td>
				<td width="10%" align="center" class="measurement_middle">38</td>
				<td width="10%" align="center" class="measurement_middle">40</td>
				<td width="10%" align="center" class="measurement_middle">42</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="I" id="I" value="{if isset($measurement)}{$measurement.I}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>J</b></td>
				<td width="20%" align="left" class="measurement_middle">Waist</td>
				<td width="10%" align="center" class="measurement_middle">28</td>
				<td width="10%" align="center" class="measurement_middle">30</td>
				<td width="10%" align="center" class="measurement_middle">32</td>
				<td width="10%" align="center" class="measurement_middle">36.5</td>
				<td width="10%" align="center" class="measurement_middle">38.5</td>
				<td width="10%" align="center" class="measurement_middle">40.5</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="J" id="J" value="{if isset($measurement)}{$measurement.J}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>				
				<td width="10%" align="center" class="measurement_left"><b>K</b></td>
				<td width="20%" align="left" class="measurement_middle">Hips</td>
				<td width="10%" align="center" class="measurement_middle">34.5</td>
				<td width="10%" align="center" class="measurement_middle">36</td>
				<td width="10%" align="center" class="measurement_middle">38.5</td>
				<td width="10%" align="center" class="measurement_middle">40.5</td>
				<td width="10%" align="center" class="measurement_middle">44.5</td>
				<td width="10%" align="center" class="measurement_middle">48.5</td>
				{if $cookie->isLogged()}<td width="10%" align="center" style="padding-top:5px;" class="measurement_middle">
					<input type="text" size="5" name="K" id="K" value="{if isset($measurement)}{$measurement.K}{/if}" class="custom_fields">
				</td>{/if}					
			</tr>
			<tr>
				<td colspan="7" style="text-align:left">*All Measurements in Inches</td>
			</tr>
			<tr>
			<td colspan="8" style="text-align:left">*The minimum length for an Anarkali is 40 inches as recommended by the IndusDiva Design Studio.</td>
			</tr>
		</tbody>
		</table>
			<div style="width:440px;padding:0px;float:left">
				<img src="{$img_ps_dir}styles/anarkali-2.png" alt="measurement info"/>
			</div>
			<div id="measurement-alias" style="padding:0 10px;text-align:left;float:left">
				{if isset($measurement)}
				{else}
					{if $cookie->isLogged()}<span style="color:#999999">Please select a name to save this measurement. For example Me, Mom, Aditi</span>
					<br/>
					<span>Measurement For:</span>
					<input id="name_measuremnet" name="name_measurement" class="text required" value="" size="20" style="font-size:15px;height:15px;line-height:18px;height:18px;"/>{/if}
				{/if}
			</div>
			<p class="submit" style="clear:both;text-align:center">
				<input type="hidden" name="type_measurement" value="5"/>
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
		$('#measurement-alias').fadeIn();
	}
	else
	{
		$('.custom_fields').removeClass('required').removeClass('number');
		$('#measurement-alias').removeClass('required');
		$('#measurement-alias').fadeOut();
		$("#measurement_form").validate({
			errorContainer: containerCreate,
			errorLabelContainer: $("ol", containerCreate),
			wrapper: 'li',
			meta: "validate",
			groups: {
			    measurements: "name_measurement A B C D E F G H I J K"
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
			    measurements: "name_measurement A B C D E F G H I J K"
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
							    $('#kurta_measurement_id').append('<option value='+result.id_measurement+'>'+result.name+'</option>');
							    $('#kurta_measurement_id').val(result.id_measurement);
							    $('#kurta_measurement_id').show();
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
		$('#kurta_measurement_id').val($('input:radio[name=mntSize]:checked').val());
		$.fancybox.close();
	}
});
{/literal}
</script>
