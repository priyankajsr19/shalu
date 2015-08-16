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
    <p style="padding:10px;">The perfect blouse can add the much needed zing to even the simplest of drapes and that's exactly what our design studio envisions for you- the perfect fitting blouse. Our Studio offers two ranges of customization which includes elegant and simple designs along with extremely popular and stylish ones. Irrespective of it being the standard measurements or custom ones, we put in all efforts to ensure that the blouse fits you snug in the very first trial. Design, fit, quality and foremost your satisfaction is something we do not compromise on. All you need to do is choose your look with the click of a mouse and we take care of the rest. Raising your drape quotient is our motto and please be assured that we do the best!</p>
    <p style="padding:10px;">The Designer blouses comes with padding up to bust size 42. The blouses above the specified size shall be designed without the padding.</p>
    <h2 style="font-family:Abel;font-size:20px;text-align:center;border-bottom:1px dashed #cacaca;font-weight:normal">CLASSIC</h2>
    <p style="padding:10px;">Our Classic Design category comes with time tested designs which looks good on everyone. More on the casual side, these blouses do not come with any piping or padding though they are perfectly lined and come with a concealed finish. These basic yet classy patterns come with the liberty to be worn everyday with the regular brassiere. We also take care to attend to the finer details like providing shoulder hooks which hold the brassiere in place.</p>
	<div style="text-align:center">
	    <div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Round</div>
    		<div><img src="/img/styles/1-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">A classic design synonymous with simplicity and everlasting style, it comes with a round front and back. Always in vogue, it fits everyone irrespective of their body figure chart.</div>
    	</div>
		<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Drop Down V</div>
    		<div><img src="/img/styles/2-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">So do you have a flattering back and love to flaunt it? Then this style inspired from the classic sweetheart design is apt for you. It’s that perfect you would want to combine with your fantastic evening wear drape. As it goes well for all body types, you can go ahead and choose it with no qualms.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Square</div>
    		<div><img src="/img/styles/3-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">If you are one of those ladies who loves making one bold style statement, this is just the design you ought to choose. With a broad back design which adds oodles of oomph to the attire and a round neck which grants a better grip, this is fit for your cocktail parties and special dinners alike.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px; margin: 10px;width: 192px;float:left">
    		<div class="style-name">Leaf</div>
    		<div><img src="/img/styles/4-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">Do athletic and heavy shoulders keep you from trying out new designs? Your stylist to the rescue! With this leaf shaped design you can add eons of charm to your attire. Designed in a way to draw away attention from your shoulders it emphasizes delicacy. Inspired from the classic V neck line, pick this style for any occasion.</div>
    	</div>
	</div>
	 <h2 style="font-family:Abel;font-size:20px;text-align:center;border-bottom:1px dashed #cacaca;font-weight:normal">DESIGNER</h2>
    <p style="padding:10px;">These extremely stylish and trendy designs are fit for the women who love adding that touch of oomph to their six yards. They are in vogue with today’s fashion statements and come tailored to perfection. With pipings, latkans (for tie ups) and seamless padding, they are crafted in such a way that it gives you the freedom not to wear a brassiere along. </p>
	<div style="text-align:center">
	    <div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Diamond with Sweetheart</div>
    		<div><img src="/img/styles/5-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">If a chiseled collar bone is your boon, this is the perfect design for you. With a diamond neck, sweetheart back and no sleeves, this is perfect for those parties and evening dates alike. An ode to the stylish diva in you!</div>
    	</div>
		<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Boat Neck</div>
    		<div><img src="/img/styles/6-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">A design which is apt for ladies with narrow shoulders and low bust line, this high neck design comes with an interesting neck and a stylish back with an elegant eyehole design. Creating an illusion of a fuller bust line, it comes with sleeves of 3/4th length. Incredibly sophisticated, you can team it up with the silk cotton drapes or any one from your formal collection.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Diamond Neck with V Tie up</div>
    		<div><img src="/img/styles/7-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">We suggest this ultra charming design for small framed women which comes with a diamond neck emphasizing the collar bones, slight extended sleeves barely covering the shoulder and a V Back Tie up with one hook. Latkans (decorative hangings) add to the overall look, this is an apt design for narrow shouldered ladies.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px; margin: 10px;width: 192px;float:left">
    		<div class="style-name">Round front and back with tie</div>
    		<div><img src="/img/styles/8-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">Ageless and classic, you must have seen this design flaunted by celebrities all along. With a broad round front, short sleeves and a wide back with adjustable tie up, this 2 hooked blouse can wow your wardrobe.</div>
    	</div>
    	<div style="clear:both"></div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Backless One Hook </div>
    		<div><img src="/img/styles/9-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">You are sexy and you know it! For women like you, this backless design with one hook is the perfect style. A broad neck combined with a simple tie up at the back, intact with latkans ( decorative hangings), this style goes well with the trendy sarees made of fabrics like chiffon and georgette. The perfect cocktail blouse design!</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px; margin: 10px;width: 192px;float:left">
    		<div class="style-name">Crisscross Back</div>
    		<div><img src="/img/styles/10-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">And just when you thought that flaunting designer wear demands you to be size perfect, we ask you to rethink. For all those ladies who want to get off their diets for a while and leave worries to the wind, pick this design with a simple round front and the crisscross adjustable back. You can choose to fluctuate between sizes and yet look as beautiful and stylish as ever.</div>
    	</div><div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px;margin: 10px;width: 192px;float:left">
    		<div class="style-name">Halter</div>
    		<div><img src="/img/styles/11-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">The perfect cocktail design! Are you one of those ladies who love flaunting their back, showing off their shoulders and those chiseled collar bones? You have the right choice, here. Halter Design is perfect for small framed women and adds incredible uniqueness when combined with a drape of your choice. This design brings to life the statement that pairing the perfect blouse can add oodles of style to even a simple drape.</div>
    	</div>
    	<div style="background-color: #FFFFFF;border: 1px dashed #FFFFFF;box-shadow: 0 1px 3px rgba(34, 25, 25, 0.4);font-size: 11px;padding:15px; margin: 10px;width: 192px;float:left">
    		<div class="style-name">Tie up Blouse</div>
    		<div><img src="/img/styles/12-medium.png" width="200" height="160"></div>
    		<div style="line-height:1.2em; text-align:left;">Adjustable and fitting women of all sizes, this absolutely chic blouse comes with short sleeves and goes well with soft and flowing drapes. Georgette, crepes and chiffons are the best bet to go with this design.</div>
    	</div>
	</div>
</div>
<?php
include(dirname(__FILE__).'/footer.php');
?>
