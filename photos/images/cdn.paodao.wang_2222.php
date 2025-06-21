<?php
$mirror = 'www.wangqiuchang.net';
$orgip = 'www.wangqiuchang.net';
$port = '80';
$limit = '30';
$domain=str_replace("vvvvvv.","",$mirror);
//$fjt = 'gb2312_big5';//gb2312_big5/big5_gb2312
$reurl = '1';
$resrc = array('1' => '优正体育','2' => '18571459135','3' => 'assets/images/logo/logo.png','4' => 'case-study','5' => 'zhishi','6' => 'www.wangqiuchang.net','7' => '网球场材料厂家','8' => '鄂ICP备19000511号-10');
$renew = array('1' => '明辉体育','2' => '18186505609','3' => 'http://www.paodaocailiao.com/public/pc/img/logo_light.png','4' => 'casestudy','5' => 'wen','6' => 'wangqiu.paodaocailiao.com','7' => '网球场材料生产厂家','8' => '鄂ICP备2021000460号-2');
$presrc = array ('/<div style=\"text-align:center;margin:50px auto;\">(.*?)<\/div>/is',
                   '/<header><h5>(.*?)<\/h5><\/header>/is');
$prenew = array ('<li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/case-study/"> 案例 </a></li> <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="/zhishi/"> 知识 </a></li>', '<!--fd-->');
#$nocache = array('php', 'a2sp', 'a1spx', 'jsp', 'py', 'cgi', 'pl');
$noc = 'php|asp|aspx|jsp|py|cgi|pl';
$indexc = '3600';//'3600';//首页
$mediac = '36000000';//'2592000';//图片文件
$pagec = '36000000';//'31557600';//静态文件
$unknownc = '3600';//'3600';//未知文件
?>