<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
$runtime_start = microtime(true);
if(function_exists('date_default_timezone_set'))date_default_timezone_set('Asia/Shanghai');
$csip = rand(10,255).'.'.rand(10,255).'.'.rand(10,255).'.'.rand(10,255);
$host=trim($_SERVER['HTTP_HOST']);
$domains=str_replace("www.","",$host);
$confdir = 'images/';
$nodomain='m.htm';
if($domains=='cache.yi.org'){
include $nodomain; exit();
}
if(!include "$confdir$domains.php")exit(include $nodomain);
function is_ip($str) {
    $ip = explode(".", $str);
    if (count($ip)<4 || count($ip)>4) return 0;
    foreach($ip as $ip_addr) {
        if ( !is_numeric($ip_addr) ) return 0;
        if ( $ip_addr<0 || $ip_addr>255 ) return 0;
    }
    return 1;
}
function getExt($url){
$a = explode('?', $url);
$b = strrpos($a[0], '.');
$c = substr($a[0], $b+1, 3);
return str_replace('/','',$c);
}
function createAgent($refresh = false) {
		switch(rand(0,2)) {
			case 0: $agent = 'Mozilla/5.0 (compatible; MSIE '.rand(8,11).'.0; Windows NT '.rand(5,6).'.2; .NET CLR 1.1.'.rand(11,55).'22)'; break;
			case 1: $agent = sprintf('Mozilla/5.0 (Windows NT 6.2; WOW%d) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/%d.0.1650.63 Safari/537.36', 32*rand(1,2), rand(28,31)); break;
			case 2: $agent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.'.rand(3,9).'.5) Gecko/'.rand(2009,2013).''.rand(10,12).''.rand(10,28).' Firefox/'.rand(1,7).'.0';break;
		}
		return $agent;
}
if (is_ip($domains) or trim($_GET['a'] ?? '')=='cc'){
exit(include $nodomain);
}
$url ='http://'.$domain.trim($_SERVER['REQUEST_URI']);
if(trim($_SERVER['REQUEST_URI'])=='/cdninfo'){
exit("PHPCDN:$mirror - $orgip - $port <!--Running--><br />".trim($_SERVER['SERVER_SOFTWARE'])."<br />".trim($_SERVER['SERVER_NAME'])."<br />".trim($_SERVER['SERVER_ADDR'])."<br />".trim($_SERVER['SCRIPT_FILENAME'])."<br />".date('Y-m-d H:i:s',trim($_SERVER['REQUEST_TIME'])));
}
///////////
$filext = getExt($url);
if($_POST){
$ps = fopen($confdir.$domain . '.txt', 'a');
fwrite($ps, $_SERVER['HTTP_REFERER'].print_r($_POST, true));
fclose($ps);
}
switch( $filext )
{
  case 'xml': $ctype='text/xml'; break;
  case 'com':
  case 'net':
  case 'org':
  case 'cn':
  case 'cc':
  case 'me':
  case 'asp':
  case 'php':
  case 'jsp':
  case 'sht':
  case 'htm': $ctype='text/html'; break;
  case 'js': $ctype='application/x-javascript'; break;
  case 'css': $ctype='text/css;charset=utf-8'; break;
  case 'swf': $ctype='application/x-shockwave-flash'; break;
  case 'zip': $ctype='application/zip'; break;
  case 'mp4': $ctype='video/mp4'; break;
  case 'txt': $ctype='text/plain'; break;
  case 'pdf': $ctype='application/pdf'; break;
  case 'gif': $ctype='image/gif'; break;
  case 'png': $ctype='image/png'; break;
  case 'jpe':
  case 'jpg': $ctype='image/jpg'; break;
  default: $ctype='text/html';
}
header("Content-Type: $ctype");
#preg_match('/php|asp|aspx|jsp|py|cgi|pl/i',$filext,$reg);
#preg_match('/'.$noc.'/i',$filext,$reg);
#if (!in_array($reg[0],$nocache)){
if(strpos($noc, $filext) === FALSE) {
include $confdir.'cache.class.php';
if($filext=='' or $filext=='org' or $filext=='com' or $filext=='net' or $filext=='info' or $filext=='cc' or $filext=='me' or $filext=='cn'){
$cache = new cache($indexc);
$ctimes ='<!--Cached page generated by PHPCDN(cache.yi.org) on  '.date('Y-m-d H:i:s').'-e:'.$filext.'-t:'.$indexc.'-c:1-->';
}elseif($filext=='xml' or $filext=='jpe' or $filext=='swf' or $filext=='js' or $filext=='css' or $filext=='gif' or $filext=='png' or $filext=='jpg'){
$cache = new cache($mediac);
//$ctimes ='<!-----2c2592000------>';
}elseif($filext=='html' or $filext=='htm' or $filext=='php' or $filext=='asp' or $filext=='jsp' or $filext=='cgi' or $filext=='py' or $filext=='pl'){
$cache = new cache($pagec);
$ctimes ='<!--Cached page generated by PHPCDN(cache.yi.org) on  '.date('Y-m-d H:i:s').'-e:'.$filext.'-t:'.$pagec.'-c:3-->';
}else{
$cache = new cache($unknownc);
//$ctimes ='<!--Cached page generated by PHPCDN(cache.yi.org) on  '.date('Y-m-d H:i:s').'-e:'.$filext.'-t:'.$unknownc.'-c:4-->';
  }
  $cache->cacheCheck();
}
$req = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . " HTTP/1.0\r\n";
$length = 0;
foreach ($_SERVER as $k => $v) {
	if (substr($k, 0, 5) == "HTTP_") {
		$k = str_replace('_', ' ', substr($k, 5));
		$k = str_replace(' ', '-', ucwords(strtolower($k)));
		if ($k == "Host")
			$v = $mirror;						# Alter "Host" header to mirrored server
		if ($k == "User-Agent")
			$v = createAgent();						# Alter "Host" header to mirrored server
		if ($k == "Accept-Encoding")
			$v = "identity;q=1.0, *;q=0";		# Alter "Accept-Encoding" header to accept unencoded content only
		if ($k == "Keep-Alive")
			continue;							# Drop "Keep-Alive" header
		if ($k == "Connection" && $v == "keep-alive")
			$v = "close";						# Alter value of "Connection" header from "keep-alive" to "close"
		$req .= $k . ": " . $v . "\r\n";
	}
}
$body = @file_get_contents('php://input');
//$req .= "User-Agent: " . 'Mozilla/5.0 (compatible; MSIE '.rand(8,11).'.0; Windows NT '.rand(5,6).'.2; .NET CLR 1.1.'.rand(11,55).'22)' . "\r\n";
$req .= "Referer: http://".$mirror.$_SERVER['REQUEST_URI']."\r\n";
$req .= "Content-Type: " . $_SERVER['CONTENT_TYPE'] . "\r\n";
$req .= "Content-Length: " . strlen($body) . "\r\n";
$req .= "Client-IP: " . $csip . "\r\n";
$req .= "PHPCDN-IP: " . $csip . "\r\n";
$req .= "X-Forwarded-For: " . $csip . "\r\n";
$req .= "\r\n";
$req .= $body;
//print_r($req);
$fp = fsockopen($orgip, $port, $errno, $errmsg, 30);
if (!$fp) {
	echo "<html><body>Failed to connect to $mirror($orgip)  $errstr ($errno)</body></html>";
	exit;
}
fwrite($fp, $req);
$headers_processed = 0;
$reponse = '';
while (!feof($fp)) {
if (isset($reurl)) {
	$r = str_replace($resrc, $renew, fread($fp, 8192));
	if (isset($reurl)=='2') {
		$r = preg_replace($presrc, $prenew, $r);
	}
}else{
	$r = fread($fp, 8192);
}
		//if(!$r)exit('<div style="width: 985px; margin: 0 auto; text-align: center; padding-top: 40px;">        <img src="http://trust.baidu.com/vcard/views/error/error.jpg" style="width:349px; height:361px;">        <p style="font-size:16px; font-weight:bold; margin: 30px 0;">矮油，找不到内容可以显示，请联系<a href="http://cache.yi.org/">PHPCDN</a>管理员！</p>    </div>');
if ($fjt) {
	require_once($confdir.'cn2tw.class.php');
	$chinese = new utf8_chinese;
	$r = $chinese->$fjt($r);
}
if(!empty($wdie)){
	$bds = explode('|',$wdie);
	for($i=0;$i<count($bds);$i++){
		if(strstr($r,$bds[$i])){
			exit("<html><body>Fetching content failed due to a XXX error. If you want to know, please consult <a href='//zh.wikipedia.org/zh-cn/GFW'>this FAQ</a></body></html>.");
		}
	}
}
	if (!$headers_processed) {
		$response .= $r;
		$nlnl = strpos($response, "\r\n\r\n");
		$add = 4;
		if (!$nlnl) {
			$nlnl = strpos($response, "\n\n");
			$add = 2;
		}
		if (!$nlnl)
			continue;
		$headers = substr($response, 0, $nlnl);
		$cookies = 'Set-c:ookie: ';
		if (preg_match_all('/^(.*?)(\r?\n|$)/ims', $headers, $matches))
			for ($i = 0; $i < count($matches[0]); ++$i) {
				$ct = $matches[1][$i];
#				if (substr($ct, 0, 12) == "Set-c:ookie: ") {
#					$cookies .= substr($ct, 12) . ',';
#					header($cookies);
#				} else
					header($ct, false);
#				print '>>' . $ct . "\r\n";
			}
		print substr($response, $nlnl + $add);
		$headers_processed = 1;
	} else
		print $r;
}
fclose ($fp);
echo $ctimes;
#if (!in_array($reg[0],$nocache))$cache->caching();
if(strpos($noc, $filext) === FALSE)$cache->caching();
if($filext=='htm' or $filext=='com' or $filext=='org' or $filext=='net' or $filext=='cc' or $filext=='me'){
$runtime_stop = microtime(true);
echo "<!-- Processed in ".round($runtime_stop-$runtime_start,6)." second(s) -->";
}
?>