<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6594 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class RecentSearchesControllerCore extends FrontController
{
	public function displayContent()
	{
		$searchTerms = array();
		
		if (($handle = fopen("gsearch-terms.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$searchTermLine = $data[0];
				$searchTerms[] = $searchTermLine;
			}
			fclose($handle);
		}
		$countKeywords = count($searchTerms);
		$nPages = (int)(sqrt((float)($countKeywords)));
		
        $pageNo = Tools::getValue('p');
        if( $pageNo === 'popular-categories' ) {
            self::$smarty->assign('popularcategories',"true");
        } else if($pageNo && $pageNo > 0)
		{
			$keywords = array_slice($searchTerms, $pageNo*$nPages, $nPages);
			self::$smarty->assign('keywords', $keywords);
		}
		else
		{
			$pages = range(1,$nPages);
			self::$smarty->assign('pages', $pages);
		}
		
		self::$smarty->display(_PS_THEME_DIR_.'recent-searches.tpl');
	}
	
	public function displayHeader()
	{
		global $link;
		
		$pageNo = Tools::getValue('p', '');
		self::$smarty->assign('meta_title', 'Recent searches on IndusDiva.com');
		self::$smarty->assign('meta_description', 'Popular products searhes '.$pageNo);
		self::$smarty->assign('nobots', 1);
		
		parent::displayHeader();
	}
}

