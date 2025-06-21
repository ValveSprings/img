<?php
function detect($ip, $host, $url)
{
 $errstr = '';
 $errno = '';
 $fp = fsockopen ($ip, 80, $errno, $errstr, 90);
 if (!$fp)
 {
return false;
 }
 else  
 {
  $out = "GET {$url} HTTP/1.1\r\n";
  $out .= "Host:{$host}\r\n";
  $out .= "Connection: close\r\n\r\n";
  fputs ($fp, $out);
  
  while($line = fread($fp, 4096)){
  $response .= $line;
  }
  fclose( $fp );
  
  //去掉Header头信息  
  $pos = strpos($response, "\r\n\r\n");
  $response = substr($response, $pos + 4);
 
  return $response;
 }
}
//////////////si1/////////////////////
$si1ip = '202.71.207.178';
$si1h = 'share.cn-link.com';
$si1r = '/cdninfo';
$si1 = detect($si1ip, $si1h, $si1r );
preg_match('/<!--(.*?)-->/is', $si1, $s1);
$s1 = isset($s1['1']) ? $s1['1'] : 'Stop';
echo $si1h.'('.$si1ip.') is '.$s1.'<br />';
//////////////si2/////////////////////
$si2ip = '113.28.57.74';
$si2h = 'essay.cn-link.com';
$si2r = '/cdninfo';
$si2 = detect($si2ip, $si2h, $si2r );
preg_match('/<!--(.*?)-->/is', $si2, $s2);
$s2 = isset($s2['2']) ? $s2['2'] : 'Stop';
echo $si2h.'('.$si2ip.') is '.$s2.'<br />';
//////////////si3/////////////////////
$si3ip = '14.43.94.210';
$si3h = 'essay.cn-link.com';
$si3r = '/cdninfo';
$si3 = detect($si3ip, $si3h, $si3r );
preg_match('/<!--(.*?)-->/is', $si3, $s3);
$s3 = isset($s3['3']) ? $s3['3'] : 'Stop';
echo $si3h.'('.$si3ip.') is '.$s3.'<br />';
?>