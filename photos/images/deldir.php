<?php
/*
	File: common.inc.php
	Author: Apple
	Update: 2009-8-31 16:27:51
*/
//php删除目录及目录下所有文件子目录
/*
本款函数是一款利用递归来一步步删除目录下文件与当前目录所有子目录哦，不管目录为不为空都可以删除，
*/
set_time_limit(0);
$filenum=0;
function deldir($dir){
 global $filenum;
 $dh=opendir($dir);
 while ($file=readdir($dh)){
  if($file!="."&&$file!=".."){
   $fullpath=$dir."/".$file;
    if(!is_dir($fullpath)){
     unlink($fullpath);
    if(($filenum %100)==0){
     echo "*";
    }
    $filenum=$filenum+1;
   }else{
    deldir($fullpath);
   }
  }
 }
 closedir($dh);
}
deldir("./images/");
echo "delete cache file success. total:".$filenum;
?>