<?php
#header('Content-type: text/html; charset=utf-8');
#if(Extension_Loaded('zlib')) Ob_Start('ob_gzhandler');
#Header("Content-type: text/html");
/*if($_SERVER['HTTP_REFERER'] == '')
{
   exit('403');
}*/
date_default_timezone_set ('Asia/Shanghai');
$host=trim($_SERVER['HTTP_HOST']);
preg_match("/[^\.\/]+\.([^\.\/]+(\.(com|net|org)\.cn)?)$/i", $host, $matches);
if(substr_count($matches[1],".")>0) $domains=$matches[1]; else $domains=$matches[0];
$url = trim($_SERVER['REQUEST_URI']);
$ids = explode("/", $url);
#$sp='./spider/'.$ids['2'].'/'.date('Y/m/');
$sp='./hpc/'.trim(strtolower($domains)).date('-Y-m-');
#zmkdirs($sp, 0777);
function zmkdirs($pathname, $mode = 0755) {
is_dir(dirname($pathname)) || zmkdirs(dirname($pathname), $mode);
return is_dir($pathname) || @mkdir($pathname, $mode);
}

function get_naps_bot()
{
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (strpos($useragent, 'googlebot') !== false){
                return 'Googlebot';
        }
        if (strpos($useragent, 'msnbot') !== false){
                return 'MSNbot';
        }
        if (strpos($useragent, 'slurp') !== false){
                return 'Yahoobot';
        }
        if (strpos($useragent, 'baiduspider') !== false){
                return 'Baiduspider';
        }
        if (strpos($useragent, 'sogouspider') !== false){
                return 'Sogoubot';
        }
        if (strpos($useragent, 'yodaobot') !== false){
                return 'Yodaobot';
        }
        if (strpos($useragent, 'Sosospider') !== false){
                return 'Sosospider';
        }
        return false;
}
/*if (isset($_SERVER['HTTP_CLIENT_IP'])) 
  {
  $clientip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif (isset($_SERVER['HTTP_X_FORWARD_FOR'])) 
  {
  $clientip = $_SERVER['HTTP_X_FORWARD_FOR'];
  }else
  {
  $clientip = $_SERVER['REMOTE_ADDR'];
  }*/
$clientip = (!empty($_SERVER['HTTP_INCAP_CLIENT_IP']))
? (string) $_SERVER['HTTP_INCAP_CLIENT_IP']
: ((!empty($_SERVER['REMOTE_ADDR'])) ? (string) $_SERVER['REMOTE_ADDR'] : '0.0.0.0');
$tlc_thispage = addslashes($_SERVER['HTTP_USER_AGENT']);
$searchbot = get_naps_bot();
$vts = $_SERVER['REQUEST_TIME'];
$rf = $_SERVER['HTTP_REFERER'];
$vt = date('H:m:s', $vts);
#echo $clientip." > ".$tlc_thispage. "   ". date("Y-m-d / H:m:s") ."   Sb: ".$searchbot;
$uda = $vt." <a href=http://www.so.com/s?pq=ip&src=srp&q=$clientip target=_blank>".$clientip ."</a> > ".$tlc_thispage. " S: ".$searchbot ."    U: <a href=$url target=_blank>".$url ."</a>  <br />R:<a href=$rf target=_blank>".$rf."</a><br />";
$sb = $sp.date('d').'.html';
$fp_puts = fopen($sb,"ab");
fputs($fp_puts,$uda."\r\n");
#if(Extension_Loaded('zlib')) Ob_End_Flush();