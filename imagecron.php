<?php
$dir    = '/home/s3-dev-images-bckup-folder/product-imgs/';
$files1 = scandir($dir);
$len = sizeof($files1);
for($i=0;$i<$len;$i++)
{
	$ff = $files1[$i];
	$fff = $dir.$ff;
	//print_r($fff);
	 $dd = substr(sprintf('%o', fileperms($fff)), -4);
//	 print_r($fff.' - '.$dd);print_r("\n");
	 if($dd != '0777')
	 {
	 	chmod($fff,0777);
	 	print_r('setting permission on file: '.$fff.' ' .$dd);
	 echo "\n";
	 }
	 
}
?>
