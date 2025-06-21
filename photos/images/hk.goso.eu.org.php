<?php
$mirror = 'www.google.com.hk';
$orgip = 'www.google.com.hk';
$port = '80';
$limit = '30';
$domain=str_replace("vvvvvv.","",$mirror);
//$fjt = 'big5_gb2312';//gb2312_big5/big5_gb2312
$reurl = '1';
$resrc = array('1' => 'Google','2' => 'href="http://www.google.com.hk','3' => "add_Favorite('http://www.google.com.hk",'4' => '<meta property="article:publisher" content="https://www.facebook.com/orzbookcom"/>','5' => 'Powered by orzbook.com v2.0 © 2014 orzbook.com','6' => 'src="/Uploads','7' => 'url="/Uploads');
$renew = array('1' => 'Elgoog','2' => 'href="http://hk.goso.eu.org','3' => "add_Favorite('http://hk.goso.eu.org",'4' => '','5' => 'Powered by PHPCDN v1.0 © 2014 hk.goso.eu.org','6' => 'src="//www.google.com.hk/Uploads','7' => 'url="//www.google.com.hk/Uploads');
$presrc = array ('/<div style=\"text-align:center;margin:50px auto;\">(.*?)<\/div>/is',
                   '/<header><h5>(.*?)<\/h5><\/header>/is');
$prenew = array ('<img src="http://www.yichuan.net/indexjs/tougao.jpg" width="250" height="60" />', 'cssno');
#$nocache = array('php', 'a2sp', 'a1spx', 'jsp', 'py', 'cgi', 'pl');
$noc = 'php|asp|aspx|jsp|py|cgi|pl';
$indexc = '3600';//主要页面 / news/等
$mediac = '2592000';//多媒体 gif png等
$pagec = '31557600';//单页 .html htm
$unknownc = '3600';// 未知类型
?>