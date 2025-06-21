<?php
#header('Content-type: text/html; charset=utf-8');
if(isset($_REQUEST['acdn']))$acdn = trim($_REQUEST['acdn']);
switch ($acdn)
{
	case 'cdn':
echo '<form method="post">
Example:240.220.222.222 - yahoo.com<br />
AddCDN:<input type="text" name="srcip" style="overflow-x:visible;width:120;"/> - <input type="text" name="domain" style="overflow-x:visible;width:150;"/>
<input type=hidden name=acdn value="cdn" />
<input type="submit" name="Submit" value="Submit" />
</form>';
$whosts = $_SERVER["WINDIR"].'\system32\drivers\etc\hosts';
if ($_POST[Submit]) {
$fp=fopen($whosts,"a");
fwrite($fp,$_POST[srcip].' '.$_POST[domain]."\r\n"); //写入数据，中间用|隔开
fclose($fp);
}
/*读取*/
$lines=file($whosts);
foreach ($lines as $value) {
$line=explode(" ",$value);
echo "$line[0] $line[1]--$domian----<a href=?acdn=cdn&act=del&wd=".$line[1].">DEL</a>--<a href=?acdn=cdn&act=mod&wd=".urlencode($line[1]).">EDIT</a><br>";
}
/*删除*/
if ($_GET[act]=="del") {
echo $wd=trim($_GET[wd]);
foreach ($lines as $key=>$value) {
$line=explode(" ",$value);
if (trim($line[1])==$wd) { //遍历数组，定位符合条件的key，并删除改行
unset($lines[$key]);
break;
}
}
unlink($whosts);
$fp=fopen($whosts,"w");
foreach ($lines as $value) {
fwrite($fp,$value); //写入删除后的新数组
}
fclose($fp);
exit('DEL OK');
}
	break;
	case 'cache':
if($_POST){
		require_once 'cache.class.php';
		$cache = new cache();
		$cache->clearCache($_POST['file']);
}
?>
		System :<?php echo defined('PHP_OS')?PHP_OS: ' ';?>
		Server:<?php echo $_SERVER['SERVER_SOFTWARE'];?>
		Site:<?echo $_SERVER['HTTP_HOST']?> (<?php echo getenv(SERVER_ADDR); ?>)
		<form action="" method="get">Clear:<input name="file" type="text" class="input" id="file" value="/" size="25" style="overflow-x:visible;width:200;"/>
		<input type=hidden name=acdn value="cache" /><input type="submit" name="button" id="button" value="OK" /></form>
<?php
	break;
	default:
echo "<a href=?acdn=cdn>CDN Config</a> <a href=?acdn=cache>CDN Cache</a><br>";
}
?>