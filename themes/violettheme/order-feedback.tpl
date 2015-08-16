<div style="width:980px;">
	{if isset($display_thanks) && $display_thanks}
	<div style="margin:auto;width:600px;border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;padding:10px">
		<h1 style="padding:10px 0; border-bottom:1px dashed #cacaca;text-align:center">FEEDBACK SENT</h1>
		<div>
			<h2 style="text-align:center;padding:20px;font-size:18px;color:#A41E21">Thank you for your feedback!</h2>
			<p>
				You deserve the best shopping experience that the internet can provide and your feedback will help us go that extra mile and get you just that.
			</p>
		</div>
	</div>
	{else}
	<form id="address_form" action="{$link->getPageLink('order-feedback.php', true)}" method="post" class="" style="margin:auto;width:600px;border: 1px solid #D0D3D8;box-shadow: 0 1px 3px 0 black;padding:10px">
		<fieldset>
			<h1 style="padding:10px 0; border-bottom:1px dashed #cacaca;text-align:center">ORDER FEEDBACK</h1>
			<p class="required text">
				<label>1) How would you rate your overall shopping experience with IndusDiva?</label> <br/>
				<div style="padding:5px 20px;">
					<label for="overall-5"><input type="radio" name="overall" id="overall-5" value="5" checked="checked"/><span style="padding:0px 5px; cursor:pointer">Very Satisfied</span></label><br/>
					<label for="overall-4"><input type="radio" name="overall" id="overall-4" value="4" /><span style="padding:0px 5px; cursor:pointer">Satisfied</span></label> <br/>
					<label for="overall-3"><input type="radio" name="overall" id="overall-3" value="3" /><span style="padding:0px 5px; cursor:pointer">Neutral</span></label> <br/>
					<label for="overall-2"><input type="radio" name="overall" id="overall-2" value="2" /><span style="padding:0px 5px; cursor:pointer">Dissatisfied</span></label> <br/>
					<label for="overall-1"><input type="radio" name="overall" id="overall-1" value="1" /><span style="padding:0px 5px; cursor:pointer">Very Dissatisfied</span></label> <br/>
				</div>
			</p>
			<p class="required text">
				<label>2) How likely are you to recommend IndusDiva to your friends and family?</label> <br/>
				<div style="padding:5px 20px;">
					<label for="recommend-5"><input type="radio" name="recommend" id="recommend-5" value="5" checked="checked"/><span style="padding:0px 5px; cursor:pointer">Very Likely</span></label><br/>
					<label for="recommend-4"><input type="radio" name="recommend" id="recommend-4" value="4" /><span style="padding:0px 5px; cursor:pointer">Likely</span></label> <br/>
					<label for="recommend-3"><input type="radio" name="recommend" id="recommend-3" value="3" /><span style="padding:0px 5px; cursor:pointer">Neutral</span></label> <br/>
					<label for="recommend-2"><input type="radio" name="recommend" id="recommend-2" value="2" /><span style="padding:0px 5px; cursor:pointer">Unlikely</span></label> <br/>
					<label for="recommend-1"><input type="radio" name="recommend" id="recommend-1" value="1" /><span style="padding:0px 5px; cursor:pointer">Very Unlikely</span></label> <br/>
				</div>
			</p>
			<p class="required text">
				<label>3) How would you rate the collection of items at IndusDiva?</label> <br/>
				<div style="padding:5px 20px;">
					<label for="collection-5"><input type="radio" name="collection" id="collection-5" value="5" checked="checked"/><span style="padding:0px 5px; cursor:pointer">Very Good</span></label><br/>
					<label for="collection-4"><input type="radio" name="collection" id="collection-4" value="4" /><span style="padding:0px 5px; cursor:pointer">Good</span></label> <br/>
					<label for="collection-3"><input type="radio" name="collection" id="collection-3" value="3" /><span style="padding:0px 5px; cursor:pointer">Neutral</span></label> <br/>
					<label for="collection-2"><input type="radio" name="collection" id="collection-2" value="2" /><span style="padding:0px 5px; cursor:pointer">Poor</span></label> <br/>
					<label for="collection-1"><input type="radio" name="collection" id="collection-1" value="1" /><span style="padding:0px 5px; cursor:pointer">Very Poor</span></label> <br/>
				</div>
			</p>
			<p class="required text">
				<label>4) How satisfied were you with the quality of product(s) delivered to you? </label> <br/>
				<div style="padding:5px 20px;">
					<label for="products-5"><input type="radio" name="products" id="products-5" value="5" checked="checked"/><span style="padding:0px 5px; cursor:pointer">Very Satisfied</span></label><br/>
					<label for="products-4"><input type="radio" name="products" id="products-4" value="4" /><span style="padding:0px 5px; cursor:pointer">Satisfied</span></label> <br/>
					<label for="products-3"><input type="radio" name="products" id="products-3" value="3" /><span style="padding:0px 5px; cursor:pointer">Neutral</span></label> <br/>
					<label for="products-2"><input type="radio" name="products" id="products-2" value="2" /><span style="padding:0px 5px; cursor:pointer">Dissatisfied</span></label> <br/>
					<label for="products-1"><input type="radio" name="products" id="products-1" value="1" /><span style="padding:0px 5px; cursor:pointer">Very Dissatisfied</span></label> <br/>
				</div>
			</p>
			<p class="required text">
				<label>5) How satisfied are you with the fitting of your custom-stitched garment?</label> <br/>
				<div style="padding:5px 20px;">
					<label for="fitting-5"><input type="radio" name="fitting" id="fitting-5" value="5" checked="checked"/><span style="padding:0px 5px; cursor:pointer">Very Satisfied</span></label><br/>
					<label for="fitting-4"><input type="radio" name="fitting" id="fitting-4" value="4" /><span style="padding:0px 5px; cursor:pointer">Satisfied</span></label> <br/>
					<label for="fitting-3"><input type="radio" name="fitting" id="fitting-3" value="3" /><span style="padding:0px 5px; cursor:pointer">Neutral</span></label> <br/>
					<label for="fitting-2"><input type="radio" name="fitting" id="fitting-2" value="2" /><span style="padding:0px 5px; cursor:pointer">Dissatisfied</span></label> <br/>
					<label for="fitting-1"><input type="radio" name="fitting" id="fitting-1" value="1" /><span style="padding:0px 5px; cursor:pointer">Very Dissatisfied</span></label> <br/>
				</div>
			</p>
			<p class="required text">
				<label>6) How satisfied were you with the time taken to deliver your order?</label> <br/>
				<div style="padding:5px 20px;">
					<label for="delivery-5"><input type="radio" name="delivery" id="delivery-5" value="5" checked="checked"/><span style="padding:0px 5px; cursor:pointer">Very Satisfied</span></label><br/>
					<label for="delivery-4"><input type="radio" name="delivery" id="delivery-4" value="4" /><span style="padding:0px 5px; cursor:pointer">Satisfied</span></label> <br/>
					<label for="delivery-3"><input type="radio" name="delivery" id="delivery-3" value="3" /><span style="padding:0px 5px; cursor:pointer">Neutral</span></label> <br/>
					<label for="delivery-2"><input type="radio" name="delivery" id="delivery-2" value="2" /><span style="padding:0px 5px; cursor:pointer">Dissatisfied</span></label> <br/>
					<label for="delivery-1"><input type="radio" name="delivery" id="delivery-1" value="1" /><span style="padding:0px 5px; cursor:pointer">Very Dissatisfied</span></label> <br/>
				</div>
			</p>
			<p class="required text">
				<label>7) How satisfied were you with our customer support?</label> <br/>
				<div style="padding:5px 20px;">
					<label for="support-5"><input type="radio" name="support" id="support-5" value="5" checked="checked"/><span style="padding:0px 5px; cursor:pointer">Very Satisfied</span></label><br/>
					<label for="support-4"><input type="radio" name="support" id="support-4" value="4" /><span style="padding:0px 5px; cursor:pointer">Satisfied</span></label> <br/>
					<label for="support-3"><input type="radio" name="support" id="support-3" value="3" /><span style="padding:0px 5px; cursor:pointer">Did not use</span></label> <br/>
					<label for="support-2"><input type="radio" name="support" id="support-2" value="2" /><span style="padding:0px 5px; cursor:pointer">Dissatisfied</span></label> <br/>
					<label for="support-1"><input type="radio" name="support" id="support-1" value="1" /><span style="padding:0px 5px; cursor:pointer">Very Dissatisfied</span></label> <br/>
				</div>
			</p>
			<p>
				<label>8) Any other feedback or suggestion you would like to share with us? </label> <br/>
		   		<textarea value="" name="suggestions" id="suggestions" type="text" rows="4" class="text required" style="width:500px;"></textarea>
		   	</p>
		</fieldset>
		<p class="submit2" style="padding:0">
                        <input type="hidden" name="oid" value="{$id_order}" />
			<input type="submit" name="submitFeedback" id="submitFeedback" value="Send Feedback" class="button" style="margin:auto;width:150px;"/>
		</p>
		</form>
	{/if}
</div>
