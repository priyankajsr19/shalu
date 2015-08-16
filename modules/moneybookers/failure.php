<?php  
 
			include(dirname(__FILE__).'/../../config/config.inc.php');
			include(dirname(__FILE__).'/../../init.php');
			include(dirname(__FILE__).'/../../header.php');
			
            $smarty->display('failure.tpl');
            include(dirname(__FILE__).'/../../footer.php');


