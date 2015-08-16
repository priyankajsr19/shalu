<?php  
 
			include(dirname(__FILE__).'/../../config/config.inc.php');
			include(dirname(__FILE__).'/../../init.php');
			include(dirname(__FILE__).'/payu.php');
			include(dirname(__FILE__).'/../../header.php');
			
			$payu = new payu();
			$response=$_REQUEST;
			
          // die;
			
			
			
		   if ($response['status'] == 'failure')
			{
			    //echo $this->display(__FILE__, 'error.tpl');
			}
			
			

            $smarty->display('failure.tpl');
            include(dirname(__FILE__).'/../../footer.php');


