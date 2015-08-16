<?php
        include(dirname(__FILE__).'/config/config.inc.php');
        include(dirname(__FILE__).'/init.php');
	
	$for = $_GET['for'];

	if( isset($_GET["image"]) && !empty($_GET["image"]) ) {
		$image = $_GET["image"];
		$count = $_GET["count"];
		$reference = $_GET["code"];
		if( $for === 'indusdiva' ) {
			if(empty($count) )
				$filename = "{$reference}.jpg";
			else
				$filename = "{$reference}_{$count}.jpg";
		} else if( $for === 'snapdeal') {
			$filename = "{$reference}_M_{$count}_2x.jpg"; 
		}
		header("Content-Type: image/jpg");
		header("Content-Description: File Transfer");
		header('Content-Disposition: attachment; filename="'. $filename .'"');
		header("Content-Transfer-Encoding: binary");
		header("Cache-Control: no-store, no-cache");
		$image = (int) preg_replace('/\D/', '', $image);
		$str = str_split($image);
		$filepath = "/var/www/indusdiva.com/img/p/";
		$filepath = $filepath . implode("/",$str) . "/". $image . "-thickbox.jpg";
        	ob_clean();
        	flush();
		readfile($filepath);
		exit;
	}
	

        $reference = $_GET['reference'];
        if( isset($reference) && !empty($reference)) {
                $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
                $sql = "select id_product from ps_product where reference = '$reference'";
                $res = $db->getRow($sql);
                $id_product = $res['id_product'];
                if( isset($id_product) ) {
                        $productObj =  new Product($id_product, true, 1);
        		$images = $productObj->getImages(1);
			$productImages = array();
			foreach ($images AS $k => $image) {
				$productImages[] = $link->getImageLink($productObj->link_rewrite,$image['id_image'], 'thickbox');
       			} 
                } else {
                        echo 'Invalid Product Code';
                }
        } else {
                echo 'Usage : http://admin.indusdiva.com/prod-images.php?reference=[product code]';
                echo '<br/>Replace product code with actual code';
		exit;
        }
?>
<html>
	<head>
		<script type="text/javascript" src="js/jquery/jquery-1.7.2.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				<?php	
					if( $for === 'indusdiva' )
						$count = 0;
					else if( $for === 'snapdeal' )
						$count = 1;
					foreach($productImages as $image) {
						echo "$('<iframe id=\"id_$count\" src=\"http://admin.indusdiva.com/prod-images.php?for={$for}&code={$reference}&count={$count}&image=".urlencode($image)." width=\"0\" height=\"0\" border=\"0\" frameborder=\"0\" scrolling=no marginwidth=\"0\" marginheight=\"0\" vspace=\"0\" hspace=\"0\"></iframe>').appendTo('body');";
						echo PHP_EOL;
						$count++;
					}
				?>	
			});
		</script>
	</head>
</html>
