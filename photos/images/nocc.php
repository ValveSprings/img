<?php
session_start();
/*防止网页刷新刷新*/
function noRefresh()
{
$nowtime = time();
if (session_is_registered('lasttime')){
$lasttime = $_SESSION['lasttime'];
$times = $_SESSION['times'] + 1;
$_SESSION['times'] = $times;
}else{
$lasttime = $nowtime;
$times = 1;
$_SESSION['times'] = $times;
$_SESSION['lasttime'] = $lasttime;
}
/*这里可以修改数字10*/
if (($nowtime - $lasttime)<8){
$nexturl = trim($_SERVER['REQUEST_URI']);
echo "<meta charset=\"utf-8\" /><script language=\"javascript\">setTimeout(\"window.location.replace('$nexturl')\",'8250');</script>";
exit('<p align="center"><img src="http://mapsonline.dundeecity.gov.uk/DCC_GIS_Root/dcc_GIS_Config/images/loading.gif" /></p>
<h2 align="center">网页打开中请等待...</h2>');
}else{
$times = 0;
$_SESSION['lasttime'] = $nowtime;
$_SESSION['times'] = $times;
}
if((integer)$times>3){
WriteIp("ip地址： ".getIp()."时间:".date("Y-m-d H:i:s")."\n");
}
}
/*判断是否代理访问，返回是否*/
function ProxyBrowser()
{
if (isset($_SERVER)) {
$Proxyip =$_SERVER["HTTP_X_FORWARDED_FOR"];
}else {
$Proxyip = getenv("HTTP_X_FORWARDED_FOR");
}
if ($Proxyip!=''){
exit('禁止代理访问！');
return True;
}
}
/* 获取用户真实IP地址*/
function getIP()
{
static $realip;
if (isset($_SERVER)){
if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
$realip =$_SERVER["HTTP_X_FORWARDED_FOR"];
} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
$realip =$_SERVER["HTTP_CLIENT_IP"];
} else {
$realip =$_SERVER["REMOTE_ADDR"];
}
} else {
if (getenv("HTTP_X_FORWARDED_FOR")){
$realip = getenv("HTTP_X_FORWARDED_FOR");
} else if (getenv("HTTP_CLIENT_IP")) {
$realip = getenv("HTTP_CLIENT_IP");
} else {
$realip = getenv("REMOTE_ADDR");
}
}
/*$realip = (!empty($_SERVER['HTTP_CF_CONNECTING_IP']))
? (string) $_SERVER['HTTP_CF_CONNECTING_IP']
: ((!empty($_SERVER['REMOTE_ADDR'])) ? (string) $_SERVER['REMOTE_ADDR'] : '0.0.0.0');*/
return $realip;
}
/*写入IP地址到IP.TXT文件*/
function WriteIp($ip)
{
$fopen = fopen('ip.txt','a+t');//
fwrite($fopen,$ip);
fclose($fopen);
}
function ReadAllIp()
{
$fopen = fopen('ip.txt','r');
$AllIp = file_get_contents("ip.txt");
fclose($fopen);
return $AllIp;
}
/*判断是否为限制访问的IP地址*/
if(strstr(ReadAllIp(),getIp())){
exit('请求过多，拒绝访问！');
}
noRefresh();
/*是代理访问则写入真实IP和代理IP*/
if(ProxyBrowser()){
WriteIp("真是ip地址： ".getIp()."代理IP地址：".getenv("HTTP_X_FORWARDED_FOR")."时间: ".date("Y-m-d
H:i:s")."\n");
}
?>