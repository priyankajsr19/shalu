<?php
@ini_set('max_execution_time', 0);

class AdminMailer extends AdminTab
{
    private $mailer_confirm,$c_name,$utm_s,$utm_m,$utm_c,$b_url,$b_utm_url,$pid_l,$pid, $template,$subject, $id_campaign, $b_image, $a_link,$a_utm_link, $u_image, $write_up;
    
    
    public function postProcess()
    {
        global $currentIndex, $cookie, $smarty;
        $id_employee = (int)($cookie->id_employee);
        $db = Db::getInstance();
        $smarty->assign("preview", 'false');

        $this->mailer_confirm = false;
        $this->c_name = Tools::getValue('campaign_name');
        $this->utm_s = Tools::getValue('utm_source');
        $this->utm_m = Tools::getValue('utm_medium');
        $this->utm_c = Tools::getValue('utm_campaign');
        $this->b_url = Tools::getValue('banner_url');
        $this->pid_l = Tools::getValue('pid_large');
        $this->pid  = Tools::getValue('pid');
        if( empty($this->pid_l) )
            $this->pid_l = 0;
        $this->template = Tools::getValue('template');
        $this->subject = Tools::getValue('subject');
        $this->a_link = Tools::getValue('action_link');
        $this->id_campaign = intval(Tools::getValue('id_campaign',0));
        $this->write_up = Tools::getValue('write_up');
        
        $b_id = uniqid();
        $hasImage = true;
        if( isset($_FILES) && isset($_FILES['banner_image'])) {
            $dir = 'mails/';
            $ub_image_name = "banner_image";
            $ub_image_ext = substr( $_FILES['banner_image']['type'], strpos($_FILES['banner_image']['type'],"/")+1);
            $res = Tools::uploadImage($b_id, $ub_image_name, $dir, $ub_image_ext);
            if( !$res ) {
                if( $this->id_campaign === 0 ) {  
                    $this->b_image = '';
                } else {
                    $res = $db->ExecuteS("select banner_image from ps_mailers where id_campaign = {$this->id_campaign}");
                    //echo "<pre>"; print_r( $res ); exit;
                    $this->b_image = $res[0]['banner_image'];
                    if(empty($this->b_image))
                        $hasImage = false;
                }
            } else {
                $iname = $_FILES[$ub_image_name]['name'];
                $this->b_image = "http://"._MEDIA_SERVER_1_.'/img/'.$dir.$b_id.'-'.$iname;
                $hasImage = true;
            }
        }
        if( !$hasImage )
            $this->_errors[] = "Unable to upload banner image";
        
        $b_id = uniqid();
        $hasImage = true;
        if( isset($_FILES) && isset($_FILES['upnext_image'])) {
            $dir = 'mails/';
            $ub_image_name = "upnext_image";
            $ub_image_ext = substr( $_FILES['upnext_image']['type'], strpos($_FILES['upnext_image']['type'],"/")+1);
            $res = Tools::uploadImage($b_id, $ub_image_name, $dir, $ub_image_ext);
            if( !$res ) {
                if( $this->id_campaign === 0 ) {  
                    $this->u_image = '';
                } else {
                    $res = $db->ExecuteS("select upnext_image from ps_mailers where id_campaign = {$this->id_campaign}");
                    //echo "<pre>"; print_r( $res ); exit;
                    $this->u_image = $res[0]['upnext_image'];
                    if(empty($this->u_image))
                        $hasImage = false;
                }
            } else {
                $iname = $_FILES[$ub_image_name]['name'];
                $this->u_image = "http://"._MEDIA_SERVER_1_.'/img/'.$dir.$b_id.'-'.$iname;
                $hasImage = true;
            }
        }
        if( !$hasImage )
            $this->_errors[] = "Unable to upload Up-Next image";
        $this->assignToSmarty();
        $this->fillProductsInformation();
        
        if( $_POST['psubmit'] && $_POST["psubmit"] === "Preview") {
            if( $this->id_campaign === 0 ) { // new campaign 
                $sql = "insert into ps_mailers(campaign_name, utm_source, utm_medium, utm_campaign,
                    banner_image,upnext_image, write_up, banner_link, pid_l, pids,id_employee, template,action_link,subject) values (".
                        "'".pSQL($this->c_name)."',".
                        "'".pSQL($this->utm_s)."',".
                        "'".pSQL($this->utm_m)."',".
                        "'".pSQL($this->utm_c)."',".
                        "'".pSQL($this->b_image)."',".
                        "'".pSQL($this->u_image)."',".
                        "'".pSQL($this->write_up)."',".
                        "'".pSQL($this->b_url)."',".
                        "".$this->pid_l.",".
                        "'". pSQL(implode($this->pid,","))."',".
                        "".$id_employee.",".
                        "'".pSQL($this->template)."',".
                        "'".pSQL($this->a_link)."',".
                        "'".pSQL($this->subject)."'".
                    ")";

                $db->Execute($sql);
                $this->id_campaign = $db->Insert_ID();
            } else { // edit or preview old campaign
               $sql = "update ps_mailers set 
                            campaign_name = '".pSQL($this->c_name)."',
                            utm_source = '".pSQL($this->utm_s)."',
                            utm_medium = '".pSQL($this->utm_m)."',
                            utm_campaign = '".pSQL($this->utm_c)."',
                            banner_image = '".pSQL($this->b_image)."',
                            upnext_image = '".pSQL($this->u_image)."',
                            write_up = '".pSQL($this->write_up)."',
                            banner_link = '".pSQL($this->b_url)."',
                            pid_l = {$this->pid_l},
                            pids = '".pSQL(implode($this->pid,","))."',
                            template = '".pSQL($this->template)."',
                            action_link = '".pSQL($this->a_link)."',
                            subject = '".pSQL($this->subject)."'
                        where id_campaign = {$this->id_campaign}";
                $db->Execute($sql);       
            }
            $previewMail = $smarty->fetch(_PS_THEME_DIR_.$this->template);
            $previewMailTxt = $smarty->fetch(_PS_THEME_DIR_.'text_'.$this->template);
            $smarty->assign("previewMailTxt", $previewMailTxt);
            $smarty->assign("previewMail", $previewMail);
            $smarty->assign("id_campaign", $this->id_campaign);
            $smarty->assign("preview", 'true');

        } else if($_POST['tmsubmit'] && $_POST["tmsubmit"] === "Test Mail" ) {
            $previewMail = $smarty->fetch(_PS_THEME_DIR_.$this->template);
            $previewMailTxt = $smarty->fetch(_PS_THEME_DIR_.'text_'.$this->template);
            $smarty->assign("previewMailTxt", $previewMailTxt);
            $smarty->assign("previewMail", $previewMail);
            
            $testmail = Tools::getValue('testmail');
            if( empty($this->id_campaign) || empty($testmail) ) {
                $this->_errors[] = "Unable to send test mail. Please check again";
            } else {
                
                $templateVars = array();
                $templateVars['{mail_content}'] = $previewMail;
            	$templateVars['{mail_content_text}'] = $previewMailTxt;
                @Mail::Send(1, 'mailer_campaign', $this->subject, $templateVars, $testmail , null, 'care@indusdiva.com', 'Indusdiva.com', NULL, NULL, _PS_MAIL_DIR_, false);
                $this->_errors[] = "Mail Sent to {$testmail}";
            }
            $smarty->assign("id_campaign", $this->id_campaign);
            $smarty->assign("preview", 'true');
        } else if( $_POST['ssubmit'] && $_POST["ssubmit"] === "Submit") {
            $previewMail = $smarty->fetch(_PS_THEME_DIR_.$this->template);
            $previewMailTxt = $smarty->fetch(_PS_THEME_DIR_.'text_'.$this->template);
            $smarty->assign("previewMailTxt", $previewMailTxt);
            $smarty->assign("previewMail", $previewMail);
            $smarty->assign("preview", 'true');
            if($this->id_campaign === 0) {    
                $this->_errors[] = "Unable to schedule mailer.";
                $smarty->assign("id_campaign", $this->id_campaign);
            } else {
                $scheduled_at = Tools::getValue("scheduled_at");
                //convert from local time to UTC
                $scheduled_at_gmt = new Datetime($scheduled_at);
                $scheduled_at_gmt->setTimezone(new DateTimeZone('GMT'));
                $scheduled_at_gmt = $scheduled_at_gmt->format('Y-m-d H:i:s');
                $sql = "update ps_mailers set status=1,scheduled_time = '{$scheduled_at_gmt}' where id_campaign = ". $this->id_campaign;
                $db->Execute($sql);
                $this->_errors[] = "Mail scheduled at {$scheduled_at}";
                $smarty->assign("id_campaign", $this->id_campaign);
                $this->mailer_confirm = true;
            }
            
        }

        $smarty->assign('currentIndex', $currentIndex);
        $smarty->assign('token', $this->token);
    }

    public function display()
    {
        global $smarty;
        if( $this->mailer_confirm )
            $smarty->display(_PS_THEME_DIR_.'admin/mailer_confirm.tpl');
        else
            $smarty->display(_PS_THEME_DIR_.'admin/mailer.tpl');
    }

    protected function buildUTMUrl() {
        return "utm_source=".$this->utm_s."&utm_medium=".$this->utm_m."&utm_campaign=".$this->utm_c;
    }
    protected function buildURL($url) {
        $utm_url = $this->buildUTMUrl();
        if( strpos($url, "?") === false)
            return $url . "?" . $utm_url;
        else
            return $url . "&" . $utm_url;
    }
    protected  function assignToSmarty() {
        global $smarty;
        
        
        $this->b_utm_url = $this->buildURL($this->b_url);
        $smarty->assign("b_url", htmlentities($this->b_url));
        $smarty->assign("b_utm_url", htmlentities($this->b_utm_url));
        $smarty->assign("b_image", htmlentities($this->b_image));
        $smarty->assign("u_image", htmlentities($this->u_image));
        $smarty->assign("write_up", htmlentities($this->write_up));
        $smarty->assign("c_name", htmlentities($this->c_name));
        $smarty->assign("utm_s", htmlentities($this->utm_s));
        $smarty->assign("utm_m", htmlentities($this->utm_m));
        $smarty->assign("utm_c", htmlentities($this->utm_c));
        $smarty->assign("pid_l", $this->pid_l);
        $smarty->assign("pids", $this->pid) ;
        $smarty->assign("template", htmlentities($this->template));
        $smarty->assign("a_link", htmlentities($this->a_link));
        $this->a_utm_link = $this->buildURL($this->a_link);
        $smarty->assign("a_utm_link", $this->a_utm_link);
        $smarty->assign("utm_url", htmlentities($this->buildUTMUrl()));
        $smarty->assign("subject", htmlentities($this->subject));
        $smarty->assign("unsub_key","adminunsubscribedummykey");
    }
    protected  function fillProductsInformation() {
        global $smarty;
        //For large Image Product
	if( isset($this->pid_l) && !empty($this->pid_l) ) {
            $lp_info = $this->getProductInformation($this->pid_l,'large' );
            $smarty->assign("lp_name",  strtoupper($lp_info["name"]));
            $smarty->assign("lp_desc",  $lp_info["description"]);
            $smarty->assign("lp_price",$lp_info["price"]);
            $smarty->assign("lp_sprice",$lp_info["sprice"]);
            $smarty->assign("lp_url",$lp_info["url"]);
            $smarty->assign("lp_image",$lp_info["image"]);
    }
        //For all small image products
        $otherp_info = array();

        foreach($this->pid as $pid) {
            if( isset($pid) && !empty($pid) )
                array_push($otherp_info, $this->getProductInformation($pid));
        }

        //echo "<pre>" ; print_r( $otherp_info ); exit;
        $smarty->assign("otherp_info", $otherp_info);
    }
    protected  function getProductInformation($pid, $size='list') {
        $link = new Link();
        $product = new Product($pid, true , 1);
        $temp = 0;
        $product = SolrSearch::getProductsForIDs(array($pid),$temp);
        $product = $product[0];
        //echo "<pre>"; print_r( $product ); exit;
        $info = array();
        $info['name'] = strtoupper((string)$product["name"]);
        $info['description'] = (string)$product['description'];
        $info['price'] = round($product["mrp"]);
        $info['sprice'] = round($product["offer_price"]);
        $info['url'] = $this->buildURL((string)$product["product_link"]);
        $info['image'] = (string)$product["image_link_$size"];
	//echo "<pre>"; print_r( $info ); exit;
        return $info;
    }
}
