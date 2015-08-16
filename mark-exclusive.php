<?php
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');


ini_set('max_execution_time', 600);
ini_set('memory_limit', '-1');
 
$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
if( $_POST['update'] ) {

	$id_product = Tools::getValue('id_product');
	$is_exclusive = Tools::getValue('is_exclusive');

        $product = new Product($id_product);
	//$sql = "update ps_product set is_exclusive=$is_exclusive where id_product = $id_product";
	//$db->ExecuteS($sql);
        $product->is_exclusive = $is_exclusive;
        $product->update();
	//Search::indexation();		 
	
	$resp['id_product'] = $_POST['id_product'];
	$resp['is_exclusive'] = $_POST['is_exclusive'];
	$resp['response'] = 'success';
	echo json_encode($resp);
	exit;
}

 
$code = Tools::getValue('code');
if( empty($code) ) {
	echo "code mandatory<br/>";
	echo "Usage :: http://dev.indusdiva.com/mark-exclusive.php?code=BLR002"; exit;
}
$sql = "select id_supplier from ps_supplier where code = '$code'";
$res = $db->getRow($sql);
$id_supplier = $res['id_supplier'];
    
$sql = "select id_product,is_exclusive from ps_product where id_supplier = $id_supplier";
$products = $db->ExecuteS($sql);

?>
<html>
<head>
	<title>Indusdiva-Sudarshan BLR0002 products list</title>
</head>
<body style="font-size:0.9em">
<table style="font-size:0.9em;border-collapse:collapse; border:1px solid #CCC;">
<tr>
	<th> Image</th>
	<th> Exclusive </th>	
	<th></th>	
</tr>
<?php
foreach($products as $product) {

	$id_product = $product['id_product'];
	$found = 0;
	$sproduct = SolrSearch::getProductsForIDs(array($product['id_product']),$found);
	if( empty($sproduct) ) {
		$sproduct =  new Product($id_product, true, 1);
		$idImage = $sproduct->getCoverWs();
		if($idImage)
			$idImage = $sproduct->id.'-'.$idImage;
		else
			$idImage = Language::getIsoById(1).'-default';
		$list_image = $link->getImageLink($sproduct->link_rewrite,$idImage, "medium");
	} else {
		$list_image = $sproduct[0]['image_link_medium'];
	}
	if( !empty($product['is_exclusive']) ) 
		echo "<tr style='background-color:#383; color:#FFF; height:205px' id='trow_$id_product'>";
	else
		echo "<tr id='trow_$id_product' style='height:205px'>";
	echo "<td style='text-align:center'><a target='__new' href='http://www.indusdiva.com/$id_product-product.html'><img src='".$list_image."'/></a></td>";
	echo "	<td style='text-align:center;width:250px'>
			<label for='is_exclusive_".$id_product."'>Is Exclusive</label><br/>
			<input type='text' id='is_exclusive_".$id_product."' value='".$product['is_exclusive']."'/>
		</td>";
	echo "	<td style='text-align:center;width:250px'>
			<br/>
			<input type='button' value='update' id='update_".$id_product."' rel='".$id_product."' class='update'/>
			<br/>
			<label id='label_".$id_product."' style='color:#1A1; font-size:0.8em'></label>
		</td>";
	echo "</tr>";
}
?>
</table>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$('.update').click(function(){
			var id_product = $(this).attr("rel");
			var is_exclusive = $("#is_exclusive_"+id_product).val();

			var data = 'update=1&id_product='+id_product+'&is_exclusive='+is_exclusive;
			$.ajax({
				type: "POST",
				url: "http://dev.indusdiva.com/mark-exclusive.php",
				data : data,
				success : function(data) { 
						if(data.response == 'success') { 
							$("#label_"+data.id_product).html("Updated").css("color","#FFF").css("font-size","1em").css("font-weight:bold");
							if( parseInt(data.is_exclusive) == 1 )
								$("#trow_"+data.id_product).css("background-color","#383").css("color","#FFF");
							else
								$("#trow_"+data.id_product).css("background-color","#FFF").css("color","#000");
							$("#label_"+data.id_product).html(data.reason).css("color","#F33").css("font-weight:bold");
						} 
					},
				dataType : "json"
			});
		});	
	});
</script>
</body>
</html>
