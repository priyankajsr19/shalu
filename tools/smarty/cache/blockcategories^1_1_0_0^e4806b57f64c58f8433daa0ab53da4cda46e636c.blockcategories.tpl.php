<?php /*%%SmartyHeaderCode:20278669484e2c10ba77e8e5-54265192%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4806b57f64c58f8433daa0ab53da4cda46e636c' => 
    array (
      0 => '/var/www/violet/modules/blockcategories/blockcategories.tpl',
      1 => 1306504148,
      2 => 'file',
    ),
    '27c1b9555df688f460180b857b068864e58ed314' => 
    array (
      0 => '/var/www/violet/modules/blockcategories/category-tree-branch.tpl',
      1 => 1306134704,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20278669484e2c10ba77e8e5-54265192',
  'has_nocache_code' => false,
  'cache_lifetime' => 3600,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>

<!-- Block categories module -->
<div id="categories_block_left" class="block">
	<h4>Categories</h4>
	<div class="block_content">
		<ul class="tree dhtml">
									
<li >
	<a href="http://trumpserver/violet/category.php?id_category=2"  title="Now that you can buy movies from the iTunes Store and sync them to your iPod, the whole world is your theater.">iPods</a>
	</li>
												
<li >
	<a href="http://trumpserver/violet/category.php?id_category=3"  title="Wonderful accessories for your iPod">Accessories</a>
	</li>
												
<li class="last">
	<a href="http://trumpserver/violet/category.php?id_category=4"  title="The latest Intel processor, a bigger hard drive, plenty of memory, and even more new features all fit inside just one liberating inch. The new Mac laptops have the performance, power, and connectivity of a desktop computer. Without the desk part.">Laptops</a>
	</li>
							</ul>
		<script type="text/javascript">
		// <![CDATA[
			// we hide the tree only if JavaScript is activated
			$('div#categories_block_left ul.dhtml').hide();
		// ]]>
		</script>
	</div>
</div>
<!-- /Block categories module -->
<?php } ?>