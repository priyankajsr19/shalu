<?php
include(dirname(__FILE__).'/config/config.inc.php');

//will be initialized bellow...
if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
	$rewrited_url = null;

include(dirname(__FILE__).'/init.php');
include(dirname(__FILE__).'/header.php');
?>
<div style="width:980px;padding:0px;">
    <h1 style="padding: 10px;border-bottom:1px dashed #cacaca">PRE-STITCHED SAREE</h1>
    <p style="padding:10px;">Fifteen seconds, yes that's all you need to drape our pre stitched saree and you are ready to go instantly. Getting lost in the reels of the lovely six yards is easy so we get you a one step process to the perfect drape. It is as comforting as getting into a wrap around skirt. Accentuating the silhouette to the T, it lends the sophisticated and elegant touch. With an attached inskirt, all you need to do now is put it on. Yes, we told you it's going to be easy! Extremely convenient, it cuts down on time without compromising on how beautiful you look in a saree.</p>
    <p style="padding:10px;">Our step-by-step instructions show you how to do it with ease:</p>
	<div style="text-align:center"><img src="img/styles/prestitched-saree.jpg" /></div>
</div>
<?php
include(dirname(__FILE__).'/footer.php');
?>