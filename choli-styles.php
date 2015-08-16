<?php
include(dirname(__FILE__).'/config/config.inc.php');

//will be initialized bellow...
if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
	$rewrited_url = null;

include(dirname(__FILE__).'/init.php');
include(dirname(__FILE__).'/header.php');
?>
<div style="width:980px;padding:0px;">
    <h1 style="padding: 10px;font-size:24px;text-align:center;border-bottom:1px dashed #cacaca;text-transform:uppsecase">Your Personal Stylist</h1>
    <p style="padding:10px;">Lehenga Cholis are the epitome of stylish feminine attire and the perfect choli can add eons of gorgeousness to your ensemble. Our design studio brings to you the trendiest and most fashionable Choli Designs which have been sketched keeping in mind the best in vogue. Irrespective of it being the standard measurements or custom ones, we put in all efforts to ensure that the Choli fits you snug in the very first trial. The best in fashion, fit and quality is something we would never compromise on and your satisfaction is something we pride to deliver. So everytime you don the customized cholis from IndusDiva be assured that you will set hearts racing. All our Cholis come with seamless padding and so you can choose to wear them without a brassiere. The pipings and latkans (tie ups) speckle the designs with richness and charm. The wide neck patterns specific to cholis help the lady flaunt those regal choker necklaces, kundan sets and Rani Hars, after all only the best suits the queen in you. We offer custom stitching for all measurements though the blouses above bust size 42 will not come with paddings.</p>
    <h2 style="font-family:Abel;font-size:20px;text-align:center;border-bottom:1px dashed #cacaca;font-weight:normal">OUR CHOLI STYLES</h2>
	<div style="text-align:center">
	    <div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Round</div>
    		<div><img src="/img/styles/1-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">A classic design synonymous with simplicity and everlasting style, it comes with a round front and back. Always in vogue, it fits everyone irrespective of their body figure chart.</div>
    	</div>
		<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Drop Down V</div>
    		<div><img src="/img/styles/2-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">So do you have a flattering back and love to flaunt it? Then this style inspired from the classic sweetheart design is apt for you. It's that perfect design you would want to combine with your fantastic designer Lehenga. As it goes well for all body types, you can go ahead and choose it with no qualms.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Halter</div>
    		<div><img src="/img/styles/3-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">The perfect cocktail design! Are you one of those ladies who love flaunting their back, showing off their shoulders and those chiseled collar bones? You have the right choice, here. Halter Design is perfect for small framed women and adds incredible uniqueness when combined with the Lehenga of your choice. This design brings to life the statement that pairing the perfect choli can add oodles of style to your gorgeous Lehenga.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px; margin: 10px;width: 192px;float:left">
    		<div class="style-name">Diamond Neck with V Tie up</div>
    		<div><img src="/img/styles/4-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">We suggest this ultra charming design for small framed women which comes with a diamond neck emphasizing the collar bones, slight extended sleeves barely covering the shoulder and a V Back Tie up with one hook. Latkans (decorative hangings) add to the overall look, this is an apt design for narrow shouldered ladies.</div>
    	</div>
    	<div style="clear:both;"></div>
	    <div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Backless One Hook</div>
    		<div><img src="/img/styles/5-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">You are sexy and you know it! For women like you, this backless design with one hook is the perfect style. A broad neck combined with a simple tie up at the back, intact with latkans (decorative hangings), this style goes well with the trendy Lehengas made of fabrics like chiffon and georgette. The perfect cocktail designer choli design!</div>
    	</div>
		<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Crisscross Back</div>
    		<div><img src="/img/styles/6-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">And just when you thought that flaunting designer wear demands you to be size perfect, we ask you to rethink. For all those ladies who want to get off their diets for a while and leave worries to the wind, pick this design with a simple round front and the crisscross adjustable back. You can choose to fluctuate between sizes and yet look as beautiful and stylish as ever.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Round Tie up ( Long Choli )</div>
    		<div><img src="/img/styles/7-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">If you are one of those who loves to choose the quintessential long choli design, this round tie up design with sweetheart neck is the perfect fit for you. A design which suits all ladies irrespective of their body figure chart, it is chic and trendy with ample touch of ethnicity.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px; margin: 10px;width: 192px;float:left">
    		<div class="style-name">Zig Zag Back ( Long Choli )</div>
    		<div><img src="/img/styles/8-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">This Long Choli Design comes with a criss cross back and a square neck, blending style and oomph. Absolutely stylish, this is perfect for ladies irrespective of their body figure chart and adds eons of charm to their ensemble.</div>
    	</div>
	</div>
</div>
<?php
include(dirname(__FILE__).'/footer.php');
?>