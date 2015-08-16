<?php


define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
require_once(dirname(__FILE__).'/init.php');
//include(PS_ADMIN_DIR.'/header.inc.php');
@ini_set('max_execution_time', 0);

header("Content-type: text/csv");
header("Cache-Control: no-store, no-cache");

$target_path = _PS_ADMIN_DIR_ . "/import/";

if( Tools::getValue('snapdeal') ) {
    
    $id_category = (int)Tools::getValue('id_category');
    
    if( Tools::getValue('DownloadReferenceValues') ) {
        
        $filename = "SnapDeal_Reference_$id_category.csv";
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        ob_clean();
        flush();
        readfile($target_path.$filename);
        exit; 

    } else {
        $target_path = $target_path . basename($_FILES['affiliate_product_ids']['name']) . $_SERVER['REQUEST_TIME'];
        if (move_uploaded_file($_FILES['affiliate_product_ids']['tmp_name'], $target_path)) {
            $outstream = fopen("php://output",'w');
            $f = fopen($target_path, 'r');
            $line = fgetcsv($f);
            if(Tools::getValue('DownloadProducts')) {
                
                $filename = "SnapDeal_Products.csv";

                if( $id_category === 2 ) {
                
                    $header = array("Web page Number","Brand","SKU Code","Product Name","Description","Weight(g)","Length(cm)","Height(cm)","Width(cm)","Freebies","Type","Color","Fabric","Work","Origin","Art Style","Set Contents"); 
                
                    fputcsv($outstream, $header, ',', '"');
                
                    while ($line = fgetcsv($f)) {
               
                        $id_product = (int)$line[0];   
                        $product = new Product($id_product, true, 1 );
                    
                        if( !Product::isProductOfCategory($id_product, $id_category) )
                            continue;
                        $data = array();

                        $data[] = $id_product;
                        $data[] = "IndusDiva";
                        $data[] = $product->reference;
                        $data[] = $product->name;
                        //description
                        $data[] = strip_tags($product->description);

                        $data[] = round((float)$product->weight * 1000);
                        $data[] = "40.7";
                        $data[] = "15.25";
                        $data[] = "30.5";
                    
                        //Freebies
                        $data[] = "";
                    
                        //Type
                        $types = array(
                            "Handloom" => array("Handloom"), 
                            "Saree" => array("Saree"), 
                            "Jacquard" => array("Jacquard"), 
                            "Ikkat" => array("Ikkat"), 
                            "Casual/Daily Wear" => array("Casual","Daily"),
                            "Tie & Dye" => array("Dye","Tie"),
                            "Embroidered" => array("Embroided","Embroidered"),
                            "Printed" => array("Print"),
                            "Chhabra Fuscia Saree" => array("Chhabra","Fuscia"),
                            "Silk" => array("silk")
                        );
                            
                        $t = array();
                        foreach($types as $key => $type_a) {
                            foreach($type_a as $type) {
                                if( stripos($product->name, $type) !== false || stripos($product->description, $type) !== false ) {
                                    $t[] = $key;
                                    break;
                                }
                            }
                        }
                        $data[] = (count($t) >0 ) ? implode("::", $t) : "TODO";

                        //Color
                        $this_value = "TODO";
                        if( stripos($product->color,",") !== false || stripos($product->color,"and") !== false)
                            $this_value = "Multi";
                        else {
                            $datum = array("Pink","Blue","Purple","White","Brown","Wine","Yellow","Orange","Red","Green","Beige","Black","Turquoise","Violet","Maroon","Saddle-Brown","Dark-Violet","Medium-Slate-Blue","Spring-Green","Pale-Violet-Red","Dark-Slate-Blue","Olive-Drab","Mint-Cream","Cadet-Blue","Honey-Dew","Bisque","Dark-Slate-Gray","Lawn-Green","Thistle","Lime","Magenta","Pale-Turquoise","Dark-Red","Dark-Blue","Orchid", "Fire-Brick","Linen","Dark-Gray","Gold","Dark-Orange","Medium-Aqua-Marine","Antique-White","Lime-Green","Dark-Magenta","Medium-Blue","Medium-Purple","Deep-Pink","Slate-Blue","Chartreuse","Dim-Gray","Light-Golden-Rod-Yellow","Misty-Rose","Lavend");
                            $datum = array_unique($datum);
                            usort($datum, 'lsort');
                            foreach($datum as $dt) {
                                $value_parts = explode("-", $dt);
                                $no = false;
                                foreach($value_parts as $p) {
                                    if( stripos($product->color,$p) === false ) {
                                        $no = true;
                                        break;
                                    }
                                }
                                if( $no === false ) {
                                    $this_value = str_replace("-","",$dt);
                                    break;
                                }
                            }
                        }
                        $data[] = $this_value;


                        //Fabric
                        $this_value = "TODO";
                        $datum = array("Velvet","Bhagalpuri Silk","Matka Silk","Pure Georgette","Art Silk","Faux Georgette","Art Crepe","Art Silk","Silk","Net","Tussar Silk","Net","Pure Chiffon","Faux Georgette","Faux Georgette","Cotton Silk","Semi Chiffon","Cotton","Pure Georgette","Chanderi","Satin Stripe","Art Crepe","Faux Tissue","Silk","Faux Organza","Cotton Jute","Polysatin","Supernet","Cotton","Brasso","Pure Crepe","Art Crepe","Tissue","Silk","Polycotton","Pure Crepe","Cotton Silk","Pashmina Silk","Pure Chiffon","Tussar Silk","Kota Doria","Tissue","Faux Pashmina Silk","Maheshwari","Faux Chanderi","Banglore Silk","Raw");
                        $datum = array_unique($datum);
                        usort($datum, 'lsort');
                        foreach($datum as $dt) {
                            $value_parts = explode("-", $dt);
                            $no = false;
                            foreach($value_parts as $p) {
                                if( stripos($product->fabric,$p) === false ) {
                                    $no = true;
                                    break;
                                }
                            }
                            if( $no === false ) {
                                $this_value = str_replace("-","",$dt);
                                break;
                            }
                        }
                        $data[] = $this_value;

                        //Work
                        $this_value = array();
                        $datum = array("Chanderi","Chettinad","Mangalgiri","Baluchari","Patola","Printed","Brocade","Venkatgiri","Jamdani","Bomkai","Bead Work","Border Work","Batik","Banarasi","Booti Work","Lace","Kasavu","Kota Doria","Bandhej","Embroidered","Bagru Printed","Konrad","Kalamkari Printed","Pochampally","Ilkal","Ikkat","Khari Printed","Kanchipuram","Kalamkari","Mysore Silk","Leheria","Kashmiri Work","Gota Patti","Kundan Work","Sonepuri","Dharmavaram","Nowari","Hand Embroidered","Coimbatore","Dhaniakhali","Mirror Work","Narayanpet","Uppada","Bandhani","Dubka Work","Hand Printed","Phulkari","Gharchola","Bengal Tant");
                        $datum = array_unique($datum);
                        usort($datum, 'lsort');
                        foreach($datum as $dt) {
                            $value_parts = explode("-", $dt);
                            $no = false;
                            foreach($value_parts as $p) {
                                if(  stripos($product->description,$p) === false ) {
                                    $no = true;
                                    break;
                                }
                            }
                            if( $no === false ) {
                                $this_value[] = str_replace("-","",$dt);
                            }
                        }
                        $data[] = (count($this_value) >0)?implode("::",$this_value):"TODO";


                        //Origin    
                        $this_value = array();
                        $datum = array("Chanderi","Jaipur","Mysore","Bengal","Kerala","Mangalgiri","Tamil Nadu","Kota","Varanasi","Lucknow","Surat","Maharashtra","Orissa","Assam","Punjab","Maheshwar","Banglore","Hyderabad","Uppada","Rajkot","Dharmavaram","Chettinaad","Bhagalpur","Kanchipuram","Narayanpet","Nagaland","Venkatgiri","Jharkhand","Rasipuram","Patan");
                        $datum = array_unique($datum);
                        usort($datum, 'lsort');
                        foreach($datum as $dt) {
                            $value_parts = explode("-", $dt);
                            $no = false;
                            foreach($value_parts as $p) {
                                if(  stripos($product->description,$p) === false && stripos($product->name,$p) === false ) {
                                    $no = true;
                                    break;
                                }
                            }
                            if( $no === false ) {
                                $this_value[] = str_replace("-","",$dt);
                            }
                        }
                        $data[] = (count($this_value) >0)?implode("::",$this_value):"TODO";
                    
                        //Art Style    
                        $this_value = array();
                        $datum = array("Chettinad","Patola","Lucknavi Chikankari","Leheria","Mirror Work","Lace","Bandhej","Block Printed","Embroidered","Meenakari Work","Printed","Batik","Banarasi","Chanderi","Mangalgiri","Baluchari","Booti Work","Bomkai","Aari Work","Brocade","Venkatgiri","Bead Work","Jamdani","Lace","Border Work","Booti Work","Gota Patti","Kasavu","Kota Doria","Bagru Printed","Meenakari Work","Pochampally","Sambalpuri","Dhaniakhali","Mysore Silk","Phulkari","Kashmiri Work","Maheshwari","Madhubani Printed","Paithani","Sonepuri","Hand Embroidered","Khari Printed","Cutdana Work","Narayanpet","Ilkal","Bengal");
                        usort($datum, 'lsort');
                        $datum = array_unique($datum);
                        foreach($datum as $dt) {
                            $value_parts = explode("-", $dt);
                            $no = false;
                            foreach($value_parts as $p) {
                                if(  stripos($product->description,$p) === false && stripos($product->name,$p) === false  ) {
                                    $no = true;
                                    break;
                                }
                            }
                            if( $no === false ) {
                                $this_value[] = str_replace("-","",$dt);
                            }
                        }
                        $data[] = (count($this_value) >0)?implode("::",$this_value):"TODO";

                        $data[] = "With Blouse Piece";

                        fputcsv($outstream, $data, ',', '"');
                    } 
                } else if( $id_category === 4) {
                    $header = array("Web page Number","Brand","SKU Code","Product Name","Description","Weight(g)","Length(cm)","Height(cm)","Width(cm)","Freebies","Sleeves","Length","Type","Color","Fabric","Neck","Work","Knitted or Woven","Size");
                    fputcsv($outstream, $header, ',', '"');
                    while ($line = fgetcsv($f)) {
                    	$id_product = (int)$line[0];
                        $product = new Product($id_product, true, 1 );
                        if( !Product::isProductOfCategory($id_product, $id_category) )
                            continue;
                        $attributeGroups = $product->getAttributesGroups(1);
                        foreach($attributeGroups as $group ) {
                            $data = array();
		            $data[] = $id_product;
		            $data[] = "IndusDiva";
		            $data[] = $id_product.'-'.$group['attribute_name'];
		            $data[] = $product->name;
                            //description
                            $data[] = strip_tags($product->description);

                            $data[] = round((float)$product->weight * 1000);
                            $data[] = "40.7";
                            $data[] = "15.25";
                            $data[] = "30.5";
                        
                            //Freebies
                            $data[] = "";

                            //Sleeves
                            $types = array(
                                "Full" => array("Full Sleeve","Full Length","Long Sleeve"), 
                                "Half" => array("Half","1/2","Cap","Mega","Layered"), 
                                "Sleeveless" => array("sleeveless"), 
                                "3/4th" => array("Three Fourth","Three Four Length","3/4","3/4th"), 
                            );
                            $this_value = "TODO";
                            foreach($types as $key => $type_a) {
                                foreach($type_a as $type) {
                                    if( stripos($product->sleeves, $type) !== false ) {
                                        $this_value = $key;
                                        break;
                                    }
                                    if( $this_value !== 'TODO' )
                                        break;
                                }
                            }
                            $data[] = $this_value;
                        
                            //Length
                            $data[] = "TODO";

                            //Type
                            $catIds = $product->getCategories();
                            $category_names = array();

                            foreach($catIds as $catID) {
                                $category = new Category((int)$catID);
                                $category_names[] = $category->getName(1);
                            }

                            $category_names = array_diff($category_names, array('Home'));
                            $categories = implode(',', $category_names);
                            $types = array(
                                "Daily Wear" => array("daily","regular","casual"),
                                "Eveningwear" => array("lounge"),
                                "Regular" => array("casual","regular","daily"),
                                "Casual" => array("casual","work"),
                                "Party Wear" => array("party"),
                            );
                                
                            $this_value = "TODO";
                            foreach($types as $key => $type_a) {
                                foreach($type_a as $type) {
                                    if( stripos($categories, $type) !== false ) {
                                        $this_value = $key;
                                        break;
                                    }
                                }
                                if( $this_value  !== "TODO" )
                                    break;
                            }
                            $data[] = $this_value;

                            //Color
                            $this_value = "TODO";
                            if( stripos($product->color,",") !== false || stripos($product->color,"and") !== false)
                                $this_value = "Multi";
                            else {
                                $datum = array("Blue","Pink","Purple","White","Brown","Wine","Yellow","Orange","Red","Green","Beige","Rust","Violet","Black","Turquoise","Cream","Maroon","Grey");
                                $datum = array_unique($datum);
                                usort($datum, 'lsort');
                                foreach($datum as $dt) {
                                    $value_parts = explode("-", $dt);
                                    $no = false;
                                    foreach($value_parts as $p) {
                                        if( stripos($product->color,$p) === false ) {
                                            $no = true;
                                            break;
                                        }
                                    }
                                    if( $no === false ) {
                                        $this_value = str_replace("-","",$dt);
                                        break;
                                    }
                                }
                            }
                            $data[] = $this_value;


                            //Fabric
                            $this_value = "TODO";
                            $datum = array("Chanderi","Cotton","Cotton Silk","Cotton","Cotton","Silk","Cotton Silk","Cotton","Pure Georgette","Faux Georgette","Kota Doria","Cotton Jute","Pashmina Silk","Net","Art Silk","Satin","Art Crepe","Chiffon","Pure Crepe","Faux Chiffon","Crepe Jacquard","Dupion Silk","Corduaroy","Microvelvet","Woolen");
                            $datum = array_unique($datum);
                            usort($datum, 'lsort');
                            foreach($datum as $dt) {
                                $value_parts = explode("-", $dt);
                                $no = false;
                                foreach($value_parts as $p) {
                                    if( stripos($product->fabric,$p) === false ) {
                                        $no = true;
                                        break;
                                    }
                                }
                                if( $no === false ) {
                                    $this_value = str_replace("-","",$dt);
                                    break;
                                }
                            }
                            $data[] = $this_value;
                        
                            //Neck
                            $types = array(
                                "Round Neck" => array("round neck"),
                                "Chinese Collar" => array("chinese"),
                                "Sweetheart Neck" => array("sweet heart","sweetheart"),
                                "Boat Neck" => array("boat neck"),
                                "Square Neck" => array("square neck","square"),
                                "V-Neck" => array("v-neck"),
                            );
                                
                            $this_value = "TODO";
                            foreach($types as $key => $type_a) {
                                foreach($type_a as $type) {
                                    if( stripos($product->description, $type) !== false ) {
                                        $this_value = $key;
                                        break;
                                    }
                                }
                                if( $this_value  !== "TODO" )
                                    break;
                            }
                            $data[] = $this_value;


                            //Work
                            $types = array(
                                "Embroidered" => array("embroidered","enbroid"),
                                "Printed" => array("print"),
                                "Handcrafted" => array("handcrafted","handmade","hand"),
                            );
                                
                            $this_value = "TODO";
                            foreach($types as $key => $type_a) {
                                foreach($type_a as $type) {
                                    if( stripos($product->description, $type) !== false ) {
                                        $this_value = $key;
                                        break;
                                    }
                                }
                                if( $this_value  !== "TODO" )
                                    break;
                            }
                            $data[] = $this_value;


                            //Knited or Woven
		                    $data[] = "Woven";

		                    //Size
		                    $data[] = $group["attribute_name"];

                            fputcsv($outstream, $data, ',', '"');
                        }
                    }
                }
            } else if(Tools::getValue('DownloadProductStock')) {
                $filename = "SnapDeal_ProductStock.csv";
                $outstream = fopen("php://output",'w');

        
                if( $id_category === 2 ) {
                    $header = array("Web page Number","SKU Code","Product Name","WEIGHT (grams)","MRP","SELLING PRICE","FULFILLMENT MODE","COURIER TYPE","Wooden Packaging","Volumetric Weight","Inventory","Shipping Time in Days");
                    fputcsv($outstream, $header, ',', '"');
                    while ($line = fgetcsv($f)) {
                        $id_product = (int)$line[0];   
                        $product = new Product($id_product, true, 1 );
                        $data = array();
                        $data[] = $id_product;
                        $data[] = $product->reference;
                        $data[] = $product->name;
			$data[] = (float)$product->weight * 1000;
                        $data[] = (int)round( Tools::convertPrice($product->getPriceWithoutReduct(),4) );
                        $data[] = (int)round( Tools::convertPrice($product->getPrice(),4));
                        $data[] = "Dropshipment"; 
                        $data[] = "Surface"; 
			$data[] = "No";
			$data[] = "";
                        $data[] = (int)Product::getQuantity($id_product);
                        $data[] = (int)$product->shipping_sla;
                        fputcsv($outstream, $data, ',', '"');
                    }
                } else if( $id_category === 4) {
                    $header = array("Web page Number","SKU Code","Product Name","WEIGHT (grams)","MRP","SELLING PRICE","FULFILLMENT MODE","COURIER TYPE","Wooden Packaging","Volumetric Weight","Inventory","Shipping Time in Days");
                    fputcsv($outstream, $header, ',', '"');
                    while ($line = fgetcsv($f)) {
                    	$id_product = (int)$line[0];
                        $product = new Product($id_product, true, 1 );
                        if( !Product::isProductOfCategory($id_product, $id_category) )
                            continue;
                        $attributeGroups = $product->getAttributesGroups(1);
                        foreach($attributeGroups as $group ) {
                            $data = array();

                            $data[] = $id_product;
                            $data[] = $id_product.'-'.$group['attribute_name'];
                            $data[] = $product->name;
                            $data[] = "TODO";

                            $data[] = (int)round( Tools::convertPrice($product->getPriceWithoutReduct(false, $group['id_product_attribute'])) );
                            $data[] = (int)round( Tools::convertPrice($product->getPriceWithoutReduct(true, $group['id_product_attribute'])) );
                            $data[] = "TODO"; 
                            $data[] = "TODO"; 
                            $data[] = "No"; 
                            $data[] = "TODO"; 
                            $data[] = (int)Product::getQuantity($id_product, $group['id_product_attribute']);
                            $data[] = (int)$product->shipping_sla;
                            fputcsv($outstream, $data, ',', '"');
                        }
                    }
                }
            }
        }
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        fclose($outstream);
    }
}
