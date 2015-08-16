<html>
<head>
	<link type="text/css" rel="stylesheet" href="{$admin_css}" />
	<link type="text/css" rel="stylesheet" href="{$current_theme_css}" />
	<style type="text/css">
		
	</style>
	<script type="text/javascript">
	{literal}
		$(document).ready(function(){
			$(".edit_rule").click(function(){
				var ruleConfigID = $(this).attr('rel');
				$("#editRuleConfigID").val(ruleConfigID);
				$("#editRuleConfigTitle").html($("#"+ruleConfigID+"_title").text());
				$("#editRuleConfigValue").val($("#"+ruleConfigID+"_value").text());
					
				$("#rulesEditForm").fadeIn();
			});
		});
	{/literal}
	</script>
</head>
<body>
	<div style="margin:20 auto;">
		<fieldset style="margin-bottom:10px;">
			<legend><img src="../img/admin/tab-tools.gif" /><a href="deliverystats.php">Rules</a></legend>
			<form action="{$currentIndex}&token={$token}" method="post" id="rulesEditForm" style="display:none;width:400px;margin-left:100px;padding:20px;">
				<input type="hidden" name="editRuleConfigID" value="" id="editRuleConfigID" />
				<label id="editRuleConfigTitle"></label>
				<input type="text" name="editRuleConfigValue" value="" id="editRuleConfigValue" style="width:60px;"/>
				<input type="submit" name="editRules" class="eclusive button" value="Save" style="text-align: right"/>
			</form>
			
			<table id="stats_table" class="table" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th colspan="1" style="width:200px">Rule Config Name</th>
						<th colspan="1" style="width:100px">Value</th>
						<th colspan="1" style="width:100px"></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$ruleConfigs item='ruleConfig'}
					<tr>
						<td colspan="1" id="{$ruleConfig.id}_title">{$ruleConfig.name}</td>
						<td colspan="1" id="{$ruleConfig.id}_value">{$ruleConfig.value}</td>
						<td colspan="1" style="padding:5px 0">
							<span class="edit_rule" rel="{$ruleConfig.id}" style="color:green;text-decoration:underline;cursor:pointer">[edit]</span>
						</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</fieldset>
	</div>
</body>
</html>
