<?php
include(dirname(__FILE__).'/config/config.inc.php');

//will be initialized bellow...
if(intval(Configuration::get('PS_REWRITING_SETTINGS')) === 1)
	$rewrited_url = null;

include(dirname(__FILE__).'/init.php');
include(dirname(__FILE__).'/header.php');
?>
<div style="width:980px;height:250px;	padding:0px;background:url('http://cdn.indusdiva.com/img/banners/categories/Sarees.jpg'">
    <h1 style="padding:45px 60px 0 300px;margin:0;font-size:25px;font-family:Abel">Sarees - The Six Yard Wanderlust</h1>
    <p style="padding:0px 270px 0px 260px;text-align:justify">
		IndusDiva is the ultimate resource guide for those who know the beauty of the classic Indian fashion wrapped in culture and tradition. The plethora of sarees that we have shows the diversity of this magnificent Indian Ethnic Wear which is simply mind boggling. From pure Kanchipuram pattu and  Banarasi saris to Uppada and Venkatgiri, in different fabrics ranging from Silk Cotton to Georgette to Crepe and Nets, the most luxurious and unique drapes.  
	</p>
</div>

<div style="margin-top:30px;">
	<div style="float:left; width:320px;">
		<div>
			<a href="http://www.indusdiva.com/30-kanjeevaram-sarees">
				<img width="320" src="http://cdn.indusdiva.com/18268-large/henna-green-pure-silk-saree.jpg"/>
				<h2>Kanjeevaram Sarees</h2>
			</a>
		</div>
		<p>
			In a beautiful blend of quality, trend and tradition, IndusDiva is synonymous to trustworthy Kanjeevaram buys. The treatment and detailing in each of these Kanchipuram Pattu sarees are delicate, sophisticated and speak of a bygone era of understated style and simplicity. Embracing the purity of Silk and the wonder of design just got easy.  
		</p>
		<p style="text-align:center">
			<a href="http://www.indusdiva.com/30-kanjeevaram-sarees">
				<span style="background: none repeat scroll 0 0 black;padding: 5px 10px;color:#fff">SEE ALL</span>
			</a>
		</p>
	</div>
	<div style="float:left; width:320px;margin-left:8px">
		<div>
			<a href="http://www.indusdiva.com/33-banarasi-sarees">
				<img width="320" src="http://cdn.indusdiva.com/19869-large/violet-pure-georgette-paisley-saree-with-geometrical-motifs.jpg"/>
				<h2>Banarasi Sarees</h2>
			</a>
		</div>
		
		<p>
			The online shopping experience with IndusDiva will never leave you disappointed. We have something for everyone. Just a peek into this refreshingly elegant Banarasi saree collection is enough to land you into a fashionable happy state of mind. Feel the spirit of the Ganges and ring of the temple bells through this luscious weaves. 
		</p>
		<p style="text-align:center">
			<a href="http://www.indusdiva.com/33-banarasi-sarees">
				<span style="background: none repeat scroll 0 0 black;padding: 5px 10px;color:#fff">SEE ALL</span>
			</a>
		</p>
	</div>
	<div style="float:right; width:320px;margin-left:8px">
		<div>
			<a href="http://www.indusdiva.com/43-bridal-sarees">
				<img width="320" src="http://cdn.indusdiva.com/4698-large/maroon-georgette-wedding-saree.jpg"/>
				<h2>Bridal Sarees</h2>
			</a>
		</div>
		
		<p>
			Irrespective of borders and distances, look exotic and enigmatic this coming season, extend your online shopping spree with us. Place your order and we will do the rest. Right from color options to blouse designs and fits, our expert team will guide you through, to find you the most exceptional piece you ever had, celebrate life with IndusDiva. 
		</p>
		<p style="text-align:center">
			<a href="http://www.indusdiva.com/43-bridal-sarees">
				<span style="background: none repeat scroll 0 0 black;padding: 5px 10px;color:#fff">SEE ALL</span>
			</a>
		</p>
	</div>
</div>
<?php
include(dirname(__FILE__).'/footer.php');