<?php
/*
	File: common.inc.php
	Author: Apple
	Update: 2009-8-31 16:27:51
*/
//phpɾ��Ŀ¼��Ŀ¼�������ļ���Ŀ¼
/*
�������һ�����õݹ���һ����ɾ��Ŀ¼���ļ��뵱ǰĿ¼������Ŀ¼Ŷ������Ŀ¼Ϊ��Ϊ�ն�����ɾ����
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