<?php
echo "\nHello Campaings...Am back";

define('_PS_ADMIN_DIR_', getcwd());
define('PS_ADMIN_DIR', _PS_ADMIN_DIR_); // Retro-compatibility

include(PS_ADMIN_DIR.'/../config/config.inc.php');
include(PS_ADMIN_DIR.'/functions.php');
if (!defined('_PS_BASE_URL_'))
        define('_PS_BASE_URL_', Tools::getShopDomain(true));
global $protocol_content;
$protocol_content = (isset($useSSL) AND $useSSL AND Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';

global $link;
$link = new Link();

$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
$campaigns_to_run = array();
$sql = "select id_campaign from ps_mailers where status = 1 and scheduled_time < now()";
$res = $db->ExecuteS($sql);
foreach($res as $camp) {
    $id_campaign = $camp['id_campaign'];
    $usql = "update ps_mailers set status=99 where id_campaign = {$id_campaign}";
    $db->Execute($usql);
    if( $db->Affected_Rows() === 1 ) {
        // updated the status to 99 - this is the only process trying to run this campaign
        array_push($campaigns_to_run, $id_campaign);
    } else {
        // this campaign's status was 1 but some other process updated it to 99, so ignore
    }
}

if( count($campaigns_to_run) === 0 ) {
    echo "\nNone there??Good bye!!!";
    echo "\n -------------------------------------------- \n";
    return;
}

echo "\nRunning mailers for Campaign Ids - ". implode(",", $campaigns_to_run);

$sql = "select email, firstname, unsubscribe from ps_customer where newsletter = 0";
//$sql = "select email, firstname, unsubscribe from ps_customer where newsletter = 0 and id_customer in (3288)";
$to_list = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);

global $smarty;
foreach($campaigns_to_run as $id_campaign) {
    echo "\n --------------------------------------------";
    echo "\n For Campaign Id {$id_campaign}";
    $sql = "select * from ps_mailers where id_campaign = {$id_campaign}";
    $result = $db->ExecuteS($sql);
    foreach($result as $c) {
        $id_campaign = $c["id_campaign"];
        $c_name = $c['campaign_name'];
        $subject = $c['subject'];
        $utm_s = $c['utm_source'];
        $utm_m = $c['utm_medium'];
        $utm_c = $c['utm_campaign'];
        $b_image = $c['banner_image'];
        $u_image = $c['upnext_image'];
        $write_up = $c['write_up'];
        $b_url = $c['banner_link'];
        $pid_l = $c['pid_l'];
        $pids = explode(",", $c['pids'] );
        $template = $c['template'];
        $a_link = $c['action_link']; 
        
        //assign data to smarty
        $b_utm_url = buildURL($b_url,$utm_s, $utm_m, $utm_c);
        $a_utm_link = buildURL($a_link,$utm_s, $utm_m, $utm_c);
        $lp_info = getProductInformation($pid_l,$utm_s, $utm_m, $utm_c,'large' );
        $otherp_info = array();
        foreach($pids as $pid) {
            array_push($otherp_info, getProductInformation($pid,$utm_s, $utm_m, $utm_c));
        }
        
        $notify = array("venugopal.annamaneni@violetbag.com", "lekshmi.gopinathan@violetbag.com");
        $templateVars = array();
        $notify_subject = "Started sending mails for Mail Campaign {$id_campaign} - Subject {$subject}";
        $templateVars['{mail_content}'] = "";
        @Mail::Send(1, 'mailer_campaign', $notify_subject , $templateVars, $notify , null, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);

        
        
        foreach($to_list as $to) {
            $smarty->assign("b_url", htmlentities($b_url));
            $smarty->assign("b_utm_url", htmlentities($b_utm_url));
            $smarty->assign("b_image", htmlentities($b_image));
            $smarty->assign("u_image", htmlentities($u_image));
            $smarty->assign("write_up", htmlentities($write_up));
            $smarty->assign("c_name", htmlentities($c_name));
            $smarty->assign("utm_s", htmlentities($utm_s));
            $smarty->assign("utm_m", htmlentities($utm_m));
            $smarty->assign("utm_c", htmlentities($utm_c));
            $smarty->assign("pid_l", $pid_l);
            $smarty->assign("pids", $pids) ;
            $smarty->assign("template", htmlentities($template));
            $smarty->assign("a_link", htmlentities($a_link));
            $smarty->assign("a_utm_link", $a_utm_link);
            $smarty->assign("utm_url", htmlentities(buildUTMUrl($utm_s, $utm_m, $utm_c)));
            $smarty->assign("subject", htmlentities($subject));
            
            //For large Image Product
            if( !empty($lp_info) ) {
                $smarty->assign("lp_name",  strtoupper($lp_info["name"]));
                $smarty->assign("lp_desc",  $lp_info["description"]);
                $smarty->assign("lp_price",$lp_info["price"]);
                $smarty->assign("lp_sprice",$lp_info["sprice"]);
                $smarty->assign("lp_url",$lp_info["url"]);
                $smarty->assign("lp_image",$lp_info["image"]);
            }
            //For all small image products
            $smarty->assign("otherp_info", $otherp_info);

            $smarty->assign('unsub_key', $to['unsubscribe']);

            $previewMail = $smarty->fetch(_PS_THEME_DIR_.$template);
            $previewMailTxt = $smarty->fetch(_PS_THEME_DIR_.'text_'.$template);
            
            $to_email = $to['email'];
            $templateVars = array();
            $templateVars['{mail_content}'] = $previewMail;
            $templateVars['{mail_content_text}'] = $previewMailTxt;
            @Mail::Send(1, 'mailer_campaign', $subject, $templateVars, $to_email , null, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
            echo "\nMail Sent To : {$to_email}";
            usleep(200000);
        }   
    }
    echo "\nDone for campaign id {$id_campaign}";
    $usql = "update ps_mailers set status=2 where id_campaign = {$id_campaign}";
    $db->Execute($usql);
}
echo "\nDone sending mails for the scheduled campaigns";
echo "\n----------------------------------------------";

function buildUTMUrl($utm_s, $utm_m, $utm_c) {
    return "utm_source=".$utm_s."&utm_medium=".$utm_m."&utm_campaign=".$utm_c;
}
function buildURL($url,$utm_s, $utm_m, $utm_c) {
    $utm_url = buildUTMUrl($utm_s, $utm_m, $utm_c);
    if( strpos($url, "?") === false)
        return $url . "?" . $utm_url;
    else
        return $url . "&" . $utm_url;
}
function getProductInformation($pid,$utm_s, $utm_m, $utm_c, $size='list') {
    $info = array();
    if( isset($pid) && !empty($pid) ) {
        global $link;
        $temp = 0;
        $product = SolrSearch::getProductsForIDs(array($pid),$temp);
        $product = $product[0];
    
        $info['name'] = strtoupper((string)$product["name"]);
        $info['description'] = (string)$product['description'];
        $info['price'] = round($product["mrp"]);
        $info['sprice'] = round($product["offer_price"]);
        $info['url'] = buildURL((string)$product["product_link"],$utm_s, $utm_m, $utm_c);
        $info['image'] = (string)$product["image_link_$size"]; 
        //echo "<pre>"; print_r( $info ); exit;
    }
    return $info;
}

?>
