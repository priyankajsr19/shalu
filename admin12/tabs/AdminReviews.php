<?php
require_once(PS_ADMIN_DIR.'/../modules/productcomments/ProductComment.php');
require_once(PS_ADMIN_DIR.'/rules/rules_base.php');
require_once(PS_ADMIN_DIR.'/rules/product_review_approved.php');
class AdminReviews extends AdminTab
{
	public function postProcess()
	{
		global $currentIndex, $cookie, $smarty;

		if(Tools::getValue('approve'))
		{
			$id_comment = Tools::getValue('reviewID');
			$comment = new ProductComment((int)($id_comment));
			$comment->validate = 1;
			$comment->update();
			
			$product = new Product($comment->id_product, true, (int)($cookie->id_lang));
			$customer = new Customer($comment->id_customer);
			
			//send mail notifications
			Mail::Send((int)($cookie->id_lang), 'review_approved', Mail::l('Your product review for '. $product->name),
				array('{product_name}' => $product->name, '{firstname}' => $customer->firstname, '{product_url}' => $product->getLink()), $customer->email, $customer->firstname.' '.$customer->lastname);
			
			//queue reward rule exec
			if(!product_review_approved::rewardExistsForReference($comment->id_customer, EVENT_REVIEW_APPROVED, 3, $comment->id_product))
			{
			    Tools::sendSQSRuleMessage(EVENT_REVIEW_APPROVED, $comment->id_product, $comment->id_customer, date('Y-m-d H:i:s'));
			}
		}
		
		if(Tools::getValue('disapprove'))
		{
			$id_comment = Tools::getValue('reviewID');
			$comment = new ProductComment((int)($id_comment));
			$comment->deleted = 1;
			$comment->update();
			
			$product = new Product($comment->id_product, true, (int)($cookie->id_lang));
			$customer = new Customer($comment->id_customer);
			
			//send mail notifications
			Mail::Send((int)($cookie->id_lang), 'review-reject', Mail::l('Your product review for '. $product->name),
			        array('{product_name}' => $product->name, '{firstname}' => $customer->firstname, '{product_url}' => $product->getLink()), $customer->email, $customer->firstname.' '.$customer->lastname);
		}
		
		if(Tools::getValue('restore'))
		{
			$id_comment = Tools::getValue('reviewID');
			$comment = new ProductComment((int)($id_comment));
			$comment->deleted = 0;
			$comment->update();
		}
		
		if(Tools::getValue('editReview'))
		{
			$id_comment = Tools::getValue('reviewID');
			$reviewContent = Tools::getValue('reviewContent');
			$reviewTitle = Tools::getValue('reviewTitle');
			
			$comment = new ProductComment((int)($id_comment));
			$comment->content = $reviewContent;
			$comment->title = $reviewTitle;
			$comment->validate = Tools::getValue('approveReview') ? 1 : 0;
			
			$product = new Product($comment->id_product, true, (int)($cookie->id_lang));
			$customer = new Customer($comment->id_customer);
			
			if($comment->validate)
			{
			    //queue reward rule exec
			    if(!product_review_approved::rewardExistsForReference($comment->id_customer, EVENT_REVIEW_APPROVED, 3, $comment->id_product))
			        Tools::sendSQSRuleMessage(EVENT_REVIEW_APPROVED, $comment->id_product, $comment->id_customer, date('Y-m-d H:i:s'));
			    
			    //send mail notifications
			    Mail::Send((int)($cookie->id_lang), 'review_approved', Mail::l('Your product review for '. $product->name),
			            array('{product_name}' => $product->name, '{firstname}' => $customer->firstname, '{product_url}' => $product->getLink()), $customer->email, $customer->firstname.' '.$customer->lastname);
			}
			
			$comment->update();
		}
		
		if(Tools::getValue('view'))
		{
			$id_comment = Tools::getValue('reviewID');
			$comment = new ProductComment((int)($id_comment));
			$smarty->assign('review', $comment);
		}
		
		$p = (int)Tools::getValue('p', 1);
		$n = Tools::getValue('n', 20);
		
		$totalReviews = ProductComment::getTotalComments();
		$pages = $totalReviews/$n;
		if($totalReviews > $n)
			$smarty->assign('pages', $pages);
		
		$comments = ProductComment::getComments($p, $n);
		
		$smarty->assign('reviews', $comments);
		$smarty->assign('currentIndex', $currentIndex);
		$smarty->assign('token', $this->token);
		$smarty->assign('customerToken', Tools::getAdminToken('AdminCustomers'.(int)(Tab::getIdFromClassName('AdminCustomers')).(int)($cookie->id_employee)));
	}
	
	public function display()
	{
		global $smarty;
		$smarty->display(_PS_THEME_DIR_.'admin/reviews.tpl');
	}
}






