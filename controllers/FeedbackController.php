<?php


class FeedbackControllerCore extends FrontController
{
	public function run()
	{
		$this->init();
		$this->preProcess();
		global $cookie;
		
		if(Tools::getValue('fb_content'))
		{
			$name = Tools::getValue('fb_name');
			$email = Tools::getValue('fb_email');
			$content = Tools::getValue('fb_content');
			
			$privatekey = "6Le-b9kSAAAAAD_R6n5EHIxGqpF37XYXAcKthirG";
			$resp = recaptcha_check_answer($privatekey,
		                                $_SERVER["REMOTE_ADDR"],
		                                $_POST["recaptcha_challenge_field"],
		                                $_POST["recaptcha_response_field"]);
		
			if (!$resp->is_valid) {
		    	// What happens when the CAPTCHA was entered incorrectly
		    	die(Tools::jsonEncode(array(
					'feedback_status' => 'invalid_recaptcha'
		    	)));
			} else {
		    	Mail::Send((int)(self::$cookie->id_lang), 'feedback', Mail::l('New IndusDiva Feedback'),
					array('{fb_name}' => $name, '{fb_email}' => $email, 
					'{fb_content}' => $content), 'feedbacks@indusdiva.com', 'IndusDiva Feedback');
				die( Tools::jsonEncode(array(
					'feedback_status' => 'succeeded'
				)));
			}
		}
		else if(Tools::getValue('fb_like'))
		{
			$id_product = Tools::getValue('pid');
			if(Tools::getValue('fb_like') == '1')
			{
				Tools::sendSQSRuleMessage(EVENT_FACEBOOK_LIKE, $id_product, $cookie->id_customer, date('Y-m-d H:i:s'));
                                Tools::captureActivity(PSTAT_FB_LIKE, $id_product);
			}
			else if(Tools::getValue('fb_like') == '2')
			{
				Tools::sendSQSRuleMessage(EVENT_FACEBOOK_UNLIKE, $id_product, $cookie->id_customer, date('Y-m-d H:i:s'));
                                Tools::captureActivity(PSTAT_FB_UNLIKE, $id_product);
			}
			die( Tools::jsonEncode(array(
					'feedback_status' => 'succeeded'
			)));
		}
                else if(Tools::getValue('fb_page_like'))
		{
			if(Tools::getValue('fb_page_like') == '1')
			{
				Tools::sendSQSRuleMessage(EVENT_FACEBOOK_PAGE_LIKE, $cookie->id_customer, $cookie->id_customer, date('Y-m-d H:i:s'));
                                
			}
			else if(Tools::getValue('fb_page_like') == '2')
			{
				Tools::sendSQSRuleMessage(EVENT_FACEBOOK_PAGE_UNLIKE, $cookie->id_customer, $cookie->id_customer, date('Y-m-d H:i:s'));
                                
			}
			die( Tools::jsonEncode(array(
					'feedback_status' => 'succeeded'
			)));
		}
		else if(Tools::getValue('plus_click'))
		{
			$id_product = Tools::getValue('pid');
			if(Tools::getValue('plus_click') == '1')
			{
				Tools::sendSQSRuleMessage(EVENT_GOOGLE_LIKE, $id_product, $cookie->id_customer, date('Y-m-d H:i:s'));
                                Tools::captureActivity(PSTAT_G_PLUS, $id_product);
			}
			else if(Tools::getValue('plus_click') == '2')
			{
				Tools::sendSQSRuleMessage(EVENT_GOOGLE_UNLIKE, $id_product, $cookie->id_customer, date('Y-m-d H:i:s'));
                                Tools::captureActivity(PSTAT_G_UNPLUS, $id_product);
			}
			die( Tools::jsonEncode(array(
					'feedback_status' => 'succeeded'
			)));
		}
                else if(Tools::getValue('fb_order_share')) {
                    $cookie = new Cookie('ps');
                    if(! empty($cookie->shareProductCode) ) { //this is set in OrderConfirmationController.php
                        $id_product = Tools::getValue('pid');
                        $id_order = Tools::getValue('oid');
                        Tools::captureActivity(PSTAT_FB_SHARE, $id_product);
                        unset( $cookie->shareProductCode);
                        //FB Like and Share
                        Tools::sendSQSRuleMessage(EVENT_ORDER_FACEBOOK_SHARE, $id_order, $cookie->id_customer, date('Y-m-d H:i:s'));
                    }
                }
	}
}

