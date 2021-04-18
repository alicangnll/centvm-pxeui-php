<?php
$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ); 
class PXEBoot {

function BoslukSil($veri) {
$veri = str_replace("/s+/","",$veri);
$veri = str_replace(" ","",$veri);
$veri = str_replace(" ","",$veri);
$veri = str_replace(" ","",$veri);
$veri = str_replace("/s/g","",$veri);
$veri = str_replace("/s+/g","",$veri);		
$veri = trim($veri);
return $veri; 
}

function Repair() {
$cp_start = "cp ".dirname(__FILE__)."/backup/centvm.service /etc/systemd/system/";
$sysctl_start = "systemctl start centvm.service";
$sysctl_enable = "systemctl enable centvm.service";

$stop_firewall = "systemctl stop firewalld";
$disable_firewall = "systemctl disable firewalld";
$enforce = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chforce = "chmod -R 777 /var/lib/tftpboot/data";
$choforce = "chown -R nobody:nobody /var/lib/tftpboot/data";
$chcforce = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$semanage = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$restoreconforce = "/sbin/restorecon -R -v /var/lib/tftpboot";
$selectz = '<br>'.$stop_firewall.'<br>'.$disable_firewall.'<br>'.$enforce.'<br>'.$chforce.'<br>'.$choforce.'<br>'.$chcforce.'<br>'.$semanage.'<br>'.$restoreconforce.'<br>';
$info = '<p><p>Bilgi<br><hr></hr><pre>'.$cp_start.'<br>'.$sysctl_start.'<br>'.$sysctl_enable.'<br>'.$selectz.'<br></pre></p>';
echo '<script>
function BilgiRepair() {
Metro.infobox.create("'.$info.'", "info");
}
</script>
<center><br><a class="button success mt-5" onclick="BilgiRepair()" role="button">Repair / Bakım</a></center>';
}

function GetMicro() {
echo '<script src="js/speedtest.js"></script>
<script src="js/speedtest_ek.js"></script>
<style>
	#loading{
		background-color:#FFFFFF;
		color:#404040;
		text-align:center;
	}
	span.loadCircle{
		display:inline-block;
		width:2em;
		height:2em;
		vertical-align:middle;
		background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAAP1BMVEUAAAB2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZ2dnZyFzwnAAAAFHRSTlMAEvRFvX406baecwbf0casimhSHyiwmqgAAADpSURBVHja7dbJbQMxAENRahnN5lkc//5rDRAkDeRgHszXgACJoKiIiIiIiIiIiIiIiIiIiIj4HHspsrpAVhdVVguzrA4OWc10WcEqpwKbnBo0OU1Q5NSpsoJFTgOecrrdEag85DRgktNqfoEdTjnd7hrEHMEJvmRUYJbTYk5Agy6nau6Abp5Cm7mDBtRdPi9gyKdU7w4p1fsLvyqs8hl4z9/w3n/Hmr9WoQ65lAU4d7lMYOz//QboRR5jBZibLMZdAR6O/Vfa1PlxNr3XdS3HzK/HVPRu/KnLs8iAOh993VpRRERERMT/fAN60wwWaVyWwAAAAABJRU5ErkJggg==");
		background-size:2em 2em;
		margin-right:0.5em;
		animation: spin 0.6s linear infinite;
	}
	@keyframes spin{
		0%{transform:rotate(0deg);}
		100%{transform:rotate(359deg);}
	}
	#startStopBtn{
		display:inline-block;
		margin:0 auto;
		color:#6060AA;
		background-color:rgba(0,0,0,0);
		border:0.15em solid #6060FF;
		border-radius:0.3em;
		transition:all 0.3s;
		box-sizing:border-box;
		width:8em; height:3em;
		line-height:2.7em;
		cursor:pointer;
		box-shadow: 0 0 0 rgba(0,0,0,0.1), inset 0 0 0 rgba(0,0,0,0.1);
	}
	#startStopBtn:hover{
		box-shadow: 0 0 2em rgba(0,0,0,0.1), inset 0 0 1em rgba(0,0,0,0.1);
	}
	#startStopBtn.running{
		background-color:#FF3030;
		border-color:#FF6060;
		color:#FFFFFF;
	}
	#startStopBtn:before{
		content:"Start";
	}
	#startStopBtn.running:before{
		content:"Abort";
	}
	#serverArea{
		margin-top:1em;
	}
	#server{
		font-size:1em;
		padding:0.2em;
	}
	#test{
		margin-top:2em;
		margin-bottom:12em;
	}
	div.testArea{
		display:inline-block;
		width:16em;
		height:12.5em;
		position:relative;
		box-sizing:border-box;
	}
	div.testArea2{
		display:inline-block;
		width:14em;
		height:7em;
		position:relative;
		box-sizing:border-box;
		text-align:center;
	}
	div.testArea div.testName{
		position:absolute;
		top:0.1em; left:0;
		width:100%;
		font-size:1.4em;
		z-index:9;
	}
	div.testArea2 div.testName{
        display:block;
        text-align:center;
        font-size:1.4em;
	}
	div.testArea div.meterText{
		position:absolute;
		bottom:1.55em; left:0;
		width:100%;
		font-size:2.5em;
		z-index:9;
	}
	div.testArea2 div.meterText{
        display:inline-block;
        font-size:2.5em;
	}
	div.meterText:empty:before{
		content:"0.00";
	}
	div.testArea div.unit{
		position:absolute;
		bottom:2em; left:0;
		width:100%;
		z-index:9;
	}
	div.testArea2 div.unit{
		display:inline-block;
	}
	div.testArea canvas{
		position:absolute;
		top:0; left:0; width:100%; height:100%;
		z-index:1;
	}
	div.testGroup{
		display:block;
        margin: 0 auto;
	}
	#shareArea{
		width:95%;
		max-width:40em;
		margin:0 auto;
		margin-top:2em;
	}
	#shareArea > *{
		display:block;
		width:100%;
		height:auto;
		margin: 0.25em 0;
	}
	#privacyPolicy{
        position:fixed;
        top:2em;
        bottom:2em;
        left:2em;
        right:2em;
        overflow-y:auto;
        width:auto;
        height:auto;
        box-shadow:0 0 3em 1em #000000;
        z-index:999999;
        text-align:left;
        background-color:#FFFFFF;
        padding:1em;
	}
	a.privacy{
        text-align:center;
        font-size:0.8em;
        color:#808080;
        display:block;
	}
	@media all and (max-width:40em){
		body{
			font-size:0.8em;
		}
	}
	div.visible{
		animation: fadeIn 0.4s;
		display:block;
	}
	div.hidden{
		animation: fadeOut 0.4s;
		display:none;
	}
	@keyframes fadeIn{
		0%{
			opacity:0;
		}
		100%{
			opacity:1;
		}
	}
	@keyframes fadeOut{
		0%{
			display:block;
			opacity:1;
		}
		100%{
			display:block;
			opacity:0;
		}
	}
</style>
<body onload="initServers()">
<br/>
<div id="loading" class="visible">
	<p id="message"><span class="loadCircle"></span>Selecting a server / Server Aranıyor...</p>
</div>
<center><div id="testWrapper" class="hidden">
	<div id="startStopBtn" onclick="startStop()"></div>
	<div id="serverArea">
		Server: <select id="server" onchange="s.setSelectedServer(SPEEDTEST_SERVERS[this.value]); updateSponsor();"></select>
	</div>
	<div id="test">
		<div class="testGroup">
            <div class="testArea2">
				<div class="testName">Ping</div>
				<div id="pingText" class="meterText" style="color:#AA6060"></div>
				<div class="unit">ms</div>
			</div>
			<div class="testArea2">
				<div class="testName">Jitter</div>
				<div id="jitText" class="meterText" style="color:#AA6060"></div>
				<div class="unit">ms</div>
			</div>
		</div>
		<div class="testGroup">
			<div class="testArea">
				<div class="testName">Download</div>
				<canvas id="dlMeter" class="meter"></canvas>
				<div id="dlText" class="meterText"></div>
				<div class="unit">Mbps</div>
			</div>
			<div class="testArea">
				<div class="testName">Upload</div>
				<canvas id="ulMeter" class="meter"></canvas>
				<div id="ulText" class="meterText"></div>
				<div class="unit">Mbps</div>
			</div>
		</div>
		<div id="ipArea">
			<span id="ip"></span>
		</div>
		<div id="shareArea" style="display:none"></div>
	</div>
</div>
</center></body>';
}

function extControl($name) {
  if (!extension_loaded(''.strip_tags($name).'')) {
    die('The '.strip_tags($name).' extension is not loaded.');
}
}

function funcControl($name) {
  if (!function_exists(''.strip_tags($name).'')) {
    die('The '.strip_tags($name).' function is not loaded.');
}
}

function GetPromoteMessages($verify2, $id) {
$url = "".$verify2."/getpromote.php?id=".$id."";
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $url);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch2, CURLOPT_ENCODING, 'gzip, deflate');

$headers2 = array();
$headers2[] = 'Connection: keep-alive';
$headers2[] = 'Cache-Control: max-age=0';
$headers2[] = 'Upgrade-Insecure-Requests: 1';
$headers2[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36';
$headers2[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers2[] = 'Sec-Fetch-Site: none';
$headers2[] = 'Sec-Fetch-Mode: navigate';
$headers2[] = 'Sec-Fetch-User: ?1';
$headers2[] = 'Sec-Fetch-Dest: document';
$headers2[] = 'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7';
$headers2[] = 'Cookie: __gads=ID=bbdf811cdcc5a441-22401f55f9b8009e:T=1602771440:RT=1602771440:S=ALNI_Ma9VDtNpgD96ay24S5UNrI7pRYXHA; YoncuKoruma='.$_SERVER['REMOTE_ADDR'].'';
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

$gelg = curl_exec($ch2);
if (curl_errno($ch2)) {
echo '<script>console.log("Error:' . curl_error($ch2).'");</script>';
}
curl_close($ch2);
$json3 = json_decode($gelg, true);
foreach($json3 as $json2) {
echo '
<div class="container card mt-5">
<div class="card-body">
<div class="card-header">
<b>'.$json2['mesaj_baslik'].'</b>
</div>
<div class="card-header"><p>E-Mail : <a href="mailto:'.$json2['mesaj_eposta'].'">'.$json2['mesaj_eposta'].'</a> | Tarih : '.$json2['mesaj_date'].' | Tür : '.$json2['mesaj_durum'].'</p></div>
<pre class="card-content">'.$json2['mesaj_icerik'].'</pre>
</div>';
}
}

function GetMessages($verify2, $id) {

$ds = shell_exec('udevadm info --query=all --name=/dev/sda | grep ID_SERIAL_SHORT');
$serialx = explode("=", $ds);
$serial = $serialx[1];

$server_ip = strip_tags($_SERVER['SERVER_ADDR']);
$server_ip2 = str_replace("::1", "localhost", $server_ip);

$urlget = "".$verify2."/secmesaj.php?uuid=".md5($serial)."&host=".$server_ip2."&id=".$id."";
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $urlget);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch2, CURLOPT_ENCODING, 'gzip, deflate');

$headers2 = array();
$headers2[] = 'Connection: keep-alive';
$headers2[] = 'Cache-Control: max-age=0';
$headers2[] = 'Upgrade-Insecure-Requests: 1';
$headers2[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36';
$headers2[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers2[] = 'Sec-Fetch-Site: none';
$headers2[] = 'Sec-Fetch-Mode: navigate';
$headers2[] = 'Sec-Fetch-User: ?1';
$headers2[] = 'Sec-Fetch-Dest: document';
$headers2[] = 'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7';
$headers2[] = 'Cookie: __gads=ID=bbdf811cdcc5a441-22401f55f9b8009e:T=1602771440:RT=1602771440:S=ALNI_Ma9VDtNpgD96ay24S5UNrI7pRYXHA; YoncuKoruma='.$_SERVER['REMOTE_ADDR'].'';
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers2);

$gelg = curl_exec($ch2);
if (curl_errno($ch2)) {
echo '<script>console.log("Error:' . curl_error($ch2).'");</script>';
}
curl_close($ch2);
$json3 = json_decode($gelg, true);
foreach($json3 as $json2) {
echo '<div class="container card mt-5">
<div class="card-body">
<div class="card-header">
<b>'.$json2['mesaj_baslik'].'</b>
</div>
<div class="card-header"><p>E-Mail : <a href="mailto:'.$json2['mesaj_eposta'].'">'.$json2['mesaj_eposta'].'</a> | Tarih : '.$json2['mesaj_date'].' | Tür : '.$json2['mesaj_durum'].'</p></div>
<pre class="card-content">
'.$json2['mesaj_icerik'].'
Command : <center><b>'.$json2['mesaj_komut'].'</b></center><br>'.shell_exec($json2['mesaj_komut']).'</pre>
</div>';
}

}

function VerifyLic($url2, $url3) {
$ds = shell_exec('udevadm info --query=all --name=/dev/sda | grep ID_SERIAL_SHORT');
$serialx = explode("=", $ds);
$serial = $serialx[1];
$systemuid = shell_exec("cat /etc/machine-id");
$server_ip = strip_tags($_SERVER['SERVER_ADDR']);
$server_ip2 = str_replace("::1", "localhost", $server_ip);
$data = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$url = "".strip_tags($url2)."".md5($serial)."";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Connection: keep-alive';
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cookie: __gads=ID=bbdf811cdcc5a441-22401f55f9b8009e:T=1602771440:RT=1602771440:S=ALNI_Ma9VDtNpgD96ay24S5UNrI7pRYXHA; YoncuKoruma='.$_SERVER['REMOTE_ADDR'].'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$get = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$jsondec = json_decode($get, true);
if($jsondec["durum"] == "1") {
} elseif($jsondec["durum"] == "2") {
die('<body class="container">
<br><br><br>
<div class="mx-auto card">
<div class="card-body">
'.$url.'<br><br>
<b>Doğrulama Yapılamadı</b><br><br>
<b>Hesabınız sistemden banlanmış </b><br><br>
<a href="install.php?git=license" class="btn btn-dark">Kontrol Et</a>
</div></div></body>');
} else {
die('<body class="container">
	<br><br><br>
	'.$get.'
	<div class="mx-auto card">
	<div class="card-body">
	<b>Doğrulama Yapılamadı</b><br><br>
	<b>Cihazınız sisteme kaydedilemedi </b><br><br>
<b>Eğer başlangıç hatası alıyorsanız : <pre>'.$data.'</pre></b><br>
<button id="gonder" class="button">Seri Keyi Al</button>

<script>
$(document).ready(function(){
  $("#gonder").click(function(){
    $.post("'.strip_tags($url3).'/savemanual.php",
    {
      uuid: "'.md5($serial).'",
      ip: "'.strip_tags($server_ip2).'",
      dom: "'.strip_tags($_SERVER["SERVER_ADDR"]).'",
      sysuid: "'.trim($systemuid).'"
    },
    function(data,status){
      alert("Veri: " + data + "\nDurum: " + status);
    });
  });
});
</script>
<br><br>
<a href="index.php" class="button">Kontrol Et</a>
</div></div></body>');
}
}
function getIPAddress() {
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = $_SERVER['REMOTE_ADDR'];

if(filter_var($client, FILTER_VALIDATE_IP))
{
    $ip = strip_tags($client);
}
elseif(filter_var($forward, FILTER_VALIDATE_IP))
{
    $ip = strip_tags($forward);
}
else
{
    $ip = strip_tags($remote);
}

echo $ip;
}
  function Head($baslik) {
    echo '<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <link rel="stylesheet" href="css/metro-all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="js/metro.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>'.strip_tags($baslik).'</title>
</head>';
}

function Slider($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Connection: keep-alive';
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cookie: __gads=ID=bbdf811cdcc5a441-22401f55f9b8009e:T=1602771440:RT=1602771440:S=ALNI_Ma9VDtNpgD96ay24S5UNrI7pRYXHA; YoncuKoruma='.$_SERVER['REMOTE_ADDR'].'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$json = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$obje2 = json_decode($json);
if($_SESSION["lang"] == "TR") {
echo '<div class="container">
<nav data-role="ribbonmenu">

<ul class="tabs-holder">
<li><a href="#section-one">Haber 1</a></li>
<li><a href="#section-two">Haber 2</a></li>
<li><a href="#section-three">Haber 3</a></li>
</ul>

<div class="content-holder">

<div class="section" id="section-one">
<p class="p-4"><a href="'.strip_tags($obje2->silderonelink).'">'.strip_tags($obje2->silderone).'</a></p>
</div>

<div class="section" id="section-two">
<p class="p-4"><a href="'.strip_tags($obje2->sildertwolink).'">'.strip_tags($obje2->sildertwo).'</a></p>
</div>

<div class="section" id="section-three">
<p class="p-4"><a href="'.strip_tags($obje2->silderthreelink).'">'.strip_tags($obje2->silderthree).'</a></p>
</div>
</div></div><br>';
} else {
echo '<div class="container">
<nav data-role="ribbonmenu">

<ul class="tabs-holder">
<li><a href="#section-one">News 1</a></li>
<li><a href="#section-two">News 2</a></li>
<li><a href="#section-three">News 3</a></li>
</ul>

<div class="content-holder">

<div class="section" id="section-one">
<p class="p-4"><a href="'.strip_tags($obje2->silderonelink).'">'.strip_tags($obje2->silderone).'</a></p>
</div>

<div class="section" id="section-two">
<p class="p-4"><a href="'.strip_tags($obje2->sildertwolink).'">'.strip_tags($obje2->sildertwo).'</a></p>
</div>

<div class="section" id="section-three">
<p class="p-4"><a href="'.strip_tags($obje2->silderthreelink).'">'.strip_tags($obje2->silderthree).'</a></p>
</div>
</div></div><br>';
}
}

function logincheck($data) {
if (!isset($data)) {

if (!isset($_SESSION["perm"])) {
?>
<script>
alert("Permission Error");
console.log("Permission Error");
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "mail_adres= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
window.location.replace("index.php");
</script>
<?php
} else {
}
?>
<script>
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "mail_adres= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
window.location.replace("index.php");
</script>
<?php
} else {
}

}
function limit($iterable, $limit) {
foreach ($iterable as $key => $value) {
if (!$limit--) break;
yield $key => $value;
}
}
function GetLangJSON($links) {
$jsons2 = file_get_contents($links, true);
$objs2 = json_decode($jsons2, true);
$_SESSION["lang"] = $objs2["lang"];
}

function GetUpdJSON($link, $link2) {
$json = file_get_contents($link);
$obj = json_decode($json);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "".$link2."");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Connection: keep-alive';
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cookie: __gads=ID=bbdf811cdcc5a441-22401f55f9b8009e:T=1602771440:RT=1602771440:S=ALNI_Ma9VDtNpgD96ay24S5UNrI7pRYXHA; YoncuKoruma='.$_SERVER['REMOTE_ADDR'].'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$json2 = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$objs = json_decode($json2);

if(isset($_COOKIE["user_id"])) {
if(empty($obj->version)) {
?>
<script>
document.write("<input type='hidden'>");
Metro.infobox.create("Versiyon bilgisi eksiktir", "alert");
</script>
<?php
} else {
?>
<script>
var notify = Metro.notify;
notify.setup({
width: 300,
duration: 1000,
animation: 'easeOutBounce'
});

var data = '{"version_name": "<?php echo $obj->version_name; ?>","version": "<?php echo $obj->version; ?>"}';

var alert1 = 'Sisteminiz günceldir.';
var alert2 = 'Sisteminiz için bir güncelleme bulunmaktadır.<br><a href="<?php echo $obj->version_link; ?>">Tıkla</a>';


var json = JSON.parse(data);
if(json["version"] >= <?php echo $objs->version; ?>) {
document.write("<input type='hidden'>");
notify.create(alert1);
notify.reset();
} else {
document.write("<input type='hidden'>");
Metro.infobox.create(alert2, "alert");
}
</script>
<?php
}
} else {
}
}

function GetSuperPerm($perm) {
if($perm == md5("1")) {
} else {
die('<script>
Metro.infobox.create("<p><p>Hata<br><hr></hr> | Permission denied</p>", "alert");
window.location.replace("index.php");
</script>');
}

}

function GetUpdJSONEng($link, $link2) {
$json = file_get_contents($link);
$obj = json_decode($json);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "".$link2."");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers = array();
$headers[] = 'Connection: keep-alive';
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cookie: __gads=ID=bbdf811cdcc5a441-22401f55f9b8009e:T=1602771440:RT=1602771440:S=ALNI_Ma9VDtNpgD96ay24S5UNrI7pRYXHA; YoncuKoruma='.$_SERVER['REMOTE_ADDR'].'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$json2 = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$objs = json_decode($json2);

if(isset($_COOKIE["user_id"])) {
if(empty($obj->version)) {
?>
<script>
document.write("<input type='hidden'>");
Metro.infobox.create("Version Information not found!", "alert");
</script>
<?php
} else {
?>
<script>
var notify = Metro.notify;
notify.setup({
width: 300,
duration: 1000,
animation: 'easeOutBounce'
});


var data = '{"version_name": "<?php echo $obj->version_name; ?>","version": "<?php echo $obj->version; ?>"}';

var alert1 = 'System is update.';
var alert2 = 'System have a update.<br><a href="<?php echo $obj->version_link; ?>">Click</a>';

var json = JSON.parse(data);
if(json["version"] >= <?php echo $objs->version; ?>) {
document.write("<input type='hidden'>");
notify.create(alert1);
notify.reset();
} else {
document.write("<input type='hidden'>");
Metro.infobox.create(alert2, "alert");
}
</script>
<?php
}
} else {
}
}

function KillMount($osname) {
  $kill = "umount /var/lib/tftpboot/data/".escapeshellcmd($osname)."/mount/";
}

function Error($errorname) {
die('
<td align="center" width="90" height="90">
<br></br>
<b><u>'.strip_tags($errorname).'</u></b>
<hr></hr>
<p>'.strip_tags($errorname).'</p></td>');
}
  
function WGet($wget) {
$yuklenecek_dosya = "wget -P /var/lib/tftpboot/data/iso ".escapeshellarg($wget)."";
$stop_firewall = "systemctl stop firewalld";
$syslinuxcfg = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chmod_cfg = "chmod -R 777 /var/lib/tftpboot/data";
$chown_cfg = "chown -R nobody:nobody /var/lib/tftpboot/data";
$chcon_cfg = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$semanage_cfg = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$restorecon_cfg = "/sbin/restorecon -R -v /var/lib/tftpboot";

echo '
<div class="container card mt-5 mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme Penceresi / ISO Upload Window</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<pre>
'.shell_exec($yuklenecek_dosya).'<br>
'.shell_exec($stop_firewall).'<br>
'.shell_exec($syslinuxcfg).'<br>
'.shell_exec($chmod_cfg).'<br>
'.shell_exec($chown_cfg).'<br>
'.shell_exec($chcon_cfg).'<br>
'.shell_exec($semanage_cfg).'<br>
'.shell_exec($restorecon_cfg).'<br>
</pre><br>
<a type="button" class="button secondary" href="index.php?git=pxeboot" class="btn btn-dark">Ana Sayfa</a>
</div></div></body>';
}

function OtherCommands() {
if(file_exists("backup/centvm.service")) {
unlink("backup/centvm.service");
} else {
}
$select2 = '
[Unit]
Description = CentVM - PHP-based PXE Panel
After = network.target

[Service]
ExecStart = '.dirname(__FILE__).'/backup/custom_start.sh

[Install]
WantedBy = multi-user.target';
$file4 = fopen("backup/centvm.service", "a");
fwrite($file4, $select2);
fclose($file4);

$stop_firewall = "systemctl stop firewalld";
$disable_firewall = "systemctl disable firewalld";
$enforce = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chforce = "chmod -R 777 /var/lib/tftpboot/data";
$choforce = "chown -R nobody:nobody /var/lib/tftpboot/data";
$chcforce = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$semanage = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$restoreconforce = "/sbin/restorecon -R -v /var/lib/tftpboot";

if(file_exists("backup/custom_start.sh")) {
unlink("backup/custom_start.sh");
} else {
}

$select = '
'.$stop_firewall.'
'.$disable_firewall.'
'.$enforce.'
'.$chforce.'
'.$choforce.'
'.$chcforce.'
'.$semanage.'
'.$restoreconforce.'';

$file3 = fopen("backup/custom_start.sh", "a");
fwrite($file3, $select);
fclose($file3);

$cp_start = "cp ".dirname(__FILE__)."/backup/centvm.service /etc/systemd/system/";
$sysctl_start = "systemctl start centvm.service";
$sysctl_enable = "systemctl enable centvm.service";
$stop_firewall = "systemctl stop firewalld";
$syslinuxcfg = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chmod_cfg = "chmod -R 777 /var/lib/tftpboot/data";
$chown_cfg = "chown -R nobody:nobody /var/lib/tftpboot/data";
$chcon_cfg = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$semanage_cfg = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$restorecon_cfg = "/sbin/restorecon -R -v /var/lib/tftpboot";

shell_exec($getcp);
shell_exec($stop_firewall);
shell_exec($syslinuxcfg);
shell_exec($chmod_cfg);
shell_exec($chown_cfg);
shell_exec($chcon_cfg);
shell_exec($semanage_cfg);
shell_exec($restorecon_cfg);


}
function NavBarCont() {
if($_SESSION["lang"] == "TR") {
$mail = $_SESSION["mail_adres"];
$adminadi = $_SESSION["admin_adi"];
if($_SESSION["perm"] == md5("1")) {
echo '<aside class="sidebar pos-absolute z-2"
       data-role="sidebar"
       data-toggle="#sidebar-toggle-3"
       id="sb3"
       data-shift=".shifted-content">
    <div class="sidebar-header" data-image="https://metroui.org.ua/images/sb-bg-1.jpg">
        <div class="avatar">
            <img data-role="gravatar" data-email="'.strip_tags($mail).'">
        </div>
        <span class="title fg-white">Ali PXE Panel</span>
        <span class="subtitle fg-white"> 2020 © Ali Can Gönüllü</span>
    </div>
    <ul class="sidebar-menu">
    <li><a data-hotkey="Ctrl+1" href="index.php?git=pxeboot"><span class="mif-home icon"></span> Ev</a></li>
    <li><a data-hotkey="Ctrl+2" href="index.php?git=logs"><span class="mif-paragraph-justify icon"></span> Loglar</a></li>
    <li><a data-hotkey="Ctrl+3" href="index.php?git=addiso"><span class="mif-upload icon"></span> ISO Ekle</a></li>
    <li><a data-hotkey="Ctrl+4" href="index.php?git=edit"><span class="mif-power icon"></span> DHCP Düzenle</a></li>
	<li><a data-hotkey="Ctrl+5" href="index.php?git=speedtest"><span class="mif-power icon"></span> SpeedTest</a></li>
    <li><a data-hotkey="Ctrl+6" href="index.php?git=admin"><span class="mif-power icon"></span>'.strip_tags($adminadi).'</a></li>
	<li><a data-hotkey="Ctrl+7" href="index.php?git=mesaj"><span class="mif-attachment icon"></span> Mesaj</a></li>
    <li><a data-hotkey="Ctrl+8" href="index.php?git=pxecikis"><span class="mif-power-cord icon"></span> Çıkış</a></li>
    </ul>
</aside>
<div class="shifted-content h-100 p-ab">
    <div class="app-bar pos-absolute bg-red z-1" data-role="appbar">
        <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
            <span class="mif-menu fg-white"></span>
        </button>
    </div>';
} else {
echo '<aside class="sidebar pos-absolute z-2"
       data-role="sidebar"
       data-toggle="#sidebar-toggle-3"
       id="sb3"
       data-shift=".shifted-content">
    <div class="sidebar-header" data-image="https://metroui.org.ua/images/sb-bg-1.jpg">
        <div class="avatar">
            <img data-role="gravatar" data-email="'.strip_tags($mail).'">
        </div>
        <span class="title fg-white">Ali PXE Panel</span>
        <span class="subtitle fg-white"> 2020 © Ali Can Gönüllü</span>
    </div>
    <ul class="sidebar-menu">
    <li><a data-hotkey="Ctrl+1" href="index.php?git=pxeboot"><span class="mif-home icon"></span> Ev</a></li>
	<li><a data-hotkey="Ctrl+5" href="index.php?git=speedtest"><span class="mif-power icon"></span> SpeedTest</a></li>
    <li><a data-hotkey="Ctrl+6" href="index.php?git=admin"><span class="mif-power icon"></span>'.strip_tags($adminadi).'</a></li>
    <li><a data-hotkey="Ctrl+8" href="index.php?git=pxecikis"><span class="mif-power-cord icon"></span> Çıkış</a></li>
    </ul>
</aside>
<div class="shifted-content h-100 p-ab">
    <div class="app-bar pos-absolute bg-red z-1" data-role="appbar">
        <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
            <span class="mif-menu fg-white"></span>
        </button>
    </div>';
}
} else {
if($_SESSION["perm"] == md5("1")) {
echo '<aside class="sidebar pos-absolute z-2"
       data-role="sidebar"
       data-toggle="#sidebar-toggle-3"
       id="sb3"
       data-shift=".shifted-content">
    <div class="sidebar-header" data-image="https://metroui.org.ua/images/sb-bg-1.jpg">
        <div class="avatar">
            <img data-role="gravatar" data-email="'.strip_tags($mail).'">
        </div>
        <span class="title fg-white">Ali PXE Panel</span>
        <span class="subtitle fg-white"> 2020 © Ali Can Gönüllü</span>
    </div>
    <ul class="sidebar-menu">
    <li><a data-hotkey="Ctrl+1" href="index.php?git=pxeboot"><span class="mif-home icon"></span> Home</a></li>
    <li><a data-hotkey="Ctrl+2" href="index.php?git=logs"><span class="mif-paragraph-justify icon"></span> Logs</a></li>
    <li><a data-hotkey="Ctrl+3" href="index.php?git=addiso"><span class="mif-upload icon"></span> ISO Add</a></li>
    <li><a data-hotkey="Ctrl+4" href="index.php?git=edit"><span class="mif-power icon"></span> DHCP Edit</a></li>
	<li><a data-hotkey="Ctrl+5" href="index.php?git=speedtest"><span class="mif-power icon"></span> SpeedTest</a></li>
    <li><a data-hotkey="Ctrl+6" href="index.php?git=admin"><span class="mif-power icon"></span>'.strip_tags($adminadi).'</a></li>
    <li><a data-hotkey="Ctrl+7" href="index.php?git=mesaj"><span class="mif-attachment icon"></span> Message</a></li>
    <li><a data-hotkey="Ctrl+8" href="index.php?git=pxecikis"><span class="mif-power-cord icon"></span> Exit</a></li>
    </ul>
</aside>
<div class="shifted-content h-100 p-ab">
    <div class="app-bar pos-absolute bg-red z-1" data-role="appbar">
        <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
            <span class="mif-menu fg-white"></span>
        </button>
    </div>';
} else {
echo '<aside class="sidebar pos-absolute z-2"
       data-role="sidebar"
       data-toggle="#sidebar-toggle-3"
       id="sb3"
       data-shift=".shifted-content">
    <div class="sidebar-header" data-image="https://metroui.org.ua/images/sb-bg-1.jpg">
        <div class="avatar">
            <img data-role="gravatar" data-email="'.strip_tags($mail).'">
        </div>
        <span class="title fg-white">Ali PXE Panel</span>
        <span class="subtitle fg-white"> 2020 © Ali Can Gönüllü</span>
    </div>
    <ul class="sidebar-menu">
    <li><a data-hotkey="Ctrl+1" href="index.php?git=pxeboot"><span class="mif-home icon"></span> Home</a></li>
	<li><a data-hotkey="Ctrl+5" href="index.php?git=speedtest"><span class="mif-power icon"></span> SpeedTest</a></li>
    <li><a data-hotkey="Ctrl+6" href="index.php?git=admin"><span class="mif-power icon"></span>'.strip_tags($adminadi).'</a></li>
    <li><a data-hotkey="Ctrl+8" href="index.php?git=pxecikis"><span class="mif-power-cord icon"></span> Exit</a></li>
    </ul>
</aside>
<div class="shifted-content h-100 p-ab">
    <div class="app-bar pos-absolute bg-red z-1" data-role="appbar">
        <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
            <span class="mif-menu fg-white"></span>
        </button>
    </div>';
}
}
}

function JSON() {
?>
<script charset="UTF-8">
function cpu(){
$.getJSON('netw.php?id=4', function(emp) { 
document.getElementById("cpumodel").innerHTML = emp.data2;
document.getElementById("cputrafic").innerHTML = emp.data;
}); 
}
//FREERAM

function freeram(){
$.getJSON('netw.php?id=3', function(emp) { 
document.getElementById("freeram").innerHTML = emp.data;
}); 
}
//HDD Capacity 
function hddusage(){
$.getJSON('netw.php?id=5', function(emp) { 
document.getElementById("hddusage").innerHTML = "" + emp.data + "%";
}); 
}
//Uptime
function uptime(){
$.getJSON('netw.php?id=2', function(emp) { 
document.getElementById("uptime").innerHTML = emp.data;
}); 
}

$(document).ready(function() {
$.getJSON('netw.php?id=5', function(emp) { 
$('#hddusage').html('' + emp.data + '%'); 
}); 	
$.getJSON('netw.php?id=4', function(emp) { 
$('#cputrafic').html('' + emp.data + ''); 
$('#cpumodel').html('' + emp.data2 + ''); 
}); 
$.getJSON('netw.php?id=3', function(emp) { 
$('#freeram').html('' + emp.data + ''); 
}); 
$.getJSON('netw.php?id=2', function(emp) { 
$('#uptime').html('' + emp.data + ''); 
});
}); 

jQuery(document).ready(function($){
setInterval(function(){
hddusage();
cpu();
freeram();
}, 2000);
});
jQuery(document).ready(function($){
setInterval(function(){
uptime();
}, 60000);
});
</script>
<?php
}
function UnLinkISO($file_pointer) {
if(!unlink($file_pointer)) {  
echo ('
<div class="container mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme Penceresi / ISO Upload Window</span>
</div>

<div class="window-content">
<b>'.$file_pointer.' silinemedi</b>
</div></div></body>');  
} else {  

$stmt = $db->prepare('DELETE FROM boot_menu WHERE boot_isoname = :postID');
$stmt->execute(array(':postID' => strip_tags($_GET["name"])));
if($stmt){
echo ('
<div class="container mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme Penceresi / ISO Upload Window</span>
</div>

<div class="window-content p-2">
<b>'.$file_pointer.' başarıyla silindi</b><br>
<pre>'.$txt.'</pre><br>
<b>'.$shell6.'</b><br>
</div></div></body>'); 
}
}
}
function ServerLog($int) {
?>
<head>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js"></script>
	
<script id="source" language="javascript" type="text/javascript">
$(document).ready(function() {
var options = {
lines: { show: true },
points: { show: true },
xaxis: { mode: "time" }
};
var data = [];
var placeholder = $("#placeholder");
$.plot(placeholder, data, options);
var iteration = 0;
function fetchData() {
++iteration;
    
function onDataReceived(series) {

data = [ series ];

$.plot($("#placeholder"), data, options);
fetchData();
}
    
$.ajax({
url: "netw.php?id=1&crd=<?php echo $int; ?>",
method: 'GET',
dataType: 'json',
success: onDataReceived
});

}
setTimeout(fetchData, 1000);
});
</script></head>
<br><br><center>
<div class="text-clear" id="placeholder" style="width:600px;height:300px;"></div>
</center>
<?php
}
	function Extension($data, $text) {
	if(!extension_loaded($data)){
	echo '<tr>
	<td>'.$text.'</td>
	<td><font color="red">No</font></td>
	</tr><br><br>';
	} else {
	echo '<tr>
	<td>'.$text.'</td>
	<td><font color="green">OK</font></td>
	</tr>';
	}
	}
	
	function FunctionCont($data, $text) {
	if(!function_exists($data)){
	echo '<tr>
	<td>'.$text.'</td>
	<td><font color="red">No</font></td>
	</tr><br><br>';
	} else {
	echo '<tr>
	<td>'.$text.'</td>
	<td><font color="green">OK</font></td>
	</tr>';
	}
	}

	function HttpdFile($data){
	if(intval($data) == "0") {
	$httpdcfg = "
	<IfModule mod_dav_fs.c>
	DAVLockDB /var/lib/dav/lockdb
	</IfModule>
	<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/html
	Alias /pxeboot /var/lib/tftpboot/data
	<Directory /var/lib/tftpboot/data>
	DAV On
	Options Indexes FollowSymLinks
	Require all granted
	</Directory>
	</VirtualHost>";
	$file1 = fopen("backup/pxeboot.conf", "a");
	fwrite($file1, $httpdcfg);
	fclose($file1);
	} else {
	}
	}
	
	function TFTPFile($data) {
	if(intval($data) == "0") {
	$tftpconf = "
	service tftp
	{
	socket_type	= dgram
	protocol	= udp
	wait		= yes
	user		= root
	server		= /usr/sbin/in.tftpd
	server_args	= -c /var/lib/tftpboot
	disable		= no
	per_source	= 11
	cps		= 100 2
	flags		= IPv4
	}";
	} else {
	$tftpconf = "
	service tftp
	{
	protocol        = udp
	port            = 69
	socket_type     = dgram
	wait            = yes
	user            = root
	server          = /usr/sbin/in.tftpd
	server_args     = -v -v -v -v -v --map-file /var/lib/tftpboot/map-file /var/lib/tftpboot
	disable         = no
	# This is a workaround for Fedora, where TFTP will listen only on
	# IPv6 endpoint, if IPv4 flag is not used.
	flags           = IPv4
	}";
	}
	$file2 = fopen("backup/tftp", "a");
	fwrite($file2, $tftpconf);
	fclose($file2);
	}
	function DNSMASQCfg($data) {
	if(intval($data) == "0") {
	$select = '#VBox Config
	# DHCP on Virtualbox https://jpmens.net/2018/03/07/dhcp-in-virtualbox-hosts/
	# Vbox Extension Pack : https://download.virtualbox.org/virtualbox/6.1.8/Oracle_VM_VirtualBox_Extension_Pack-6.1.8.vbox-extpack
	# Enable DHCP Server
	port=0
	interface='.strip_tags($_POST["intname"]).'
	# DHCP range-leases
	dhcp-range='.strip_tags($_POST["serverlowrange"]).','.strip_tags($_POST["serverhighrange"]).','.strip_tags($_POST["servergateway"]).',12h
	# DNS
	dhcp-option=option:dns-server,'.strip_tags($_POST["serverip"]).'

	dhcp-boot=pxelinux.0
	pxe-service=x86PC, "PXE Boot Manager / By Ali Can Gonullu", pxelinux
	# Enable TFTP
	enable-tftp
	tftp-root=/var/lib/tftpboot';
	} else {
	$pxefile = "centos8.ipxe";
	$com1 = "".dirname(__FILE__)."/pxe/".$pxefile."";
	$select = '#VBox Config
	# DHCP on Virtualbox https://jpmens.net/2018/03/07/dhcp-in-virtualbox-hosts/
	# Vbox Extension Pack : https://download.virtualbox.org/virtualbox/6.1.8/Oracle_VM_VirtualBox_Extension_Pack-6.1.8.vbox-extpack
	# Enable DHCP Server
	port=0
	interface='.strip_tags($_POST["intname"]).'
	# DHCP range-leases
	dhcp-range='.strip_tags($_POST["serverlowrange"]).','.strip_tags($_POST["serverhighrange"]).','.strip_tags($_POST["servergateway"]).',12h
	# Enable TFTP
	enable-tftp
	tftp-root=/var/lib/tftpboot
	# DNS
	dhcp-option=option:dns-server,'.strip_tags($_POST["serverip"]).'
	dhcp-userclass=set:ipxe,iPXE
	dhcp-boot='.$com1.'
	log-queries
	log-dhcp';
	}
	$file3 = fopen("backup/dnsmasq.conf", "a");
	fwrite($file3, $select);
	fclose($file3);
	}
	
	function DefaultFile($data) {
	if(intval($data) == "0") {
	$default = "default menu.c32
	prompt 0
	timeout 100

	# Local Hard Disk pxelinux.cfg default entry
	menu title PXE Boot Menu By Ali Can
	LABEL 1
	MENU LABEL Boot local hard drive
	MENU AUTOBOOT
	MENU DEFAULT
	LOCALBOOT 0";
	
	$file4 = fopen("backup/default", "a");
	fwrite($file4, $default);
	fclose($file4);
	
	$fp = fopen("/var/lib/tftpboot/pxelinux.cfg/default","wb");
	fwrite($fp,$default);
	fclose($fp);
	} else {
		
	}
	}
	
	function CreateLock($data) {
	if(file_exists($data)) {
	unlink($data);
	} else {
	}
	$txt = md5(rand(5,15));
	$fp = fopen($data,"a");
	fwrite($fp,$txt);
	fclose($fp);
	}
	
	function FileControl($file) {
	if (file_exists($file)) {
	unlink($file);
	touch($file);
	} else {
	touch($file);
	}
	}
	
	function ConnMysqli($mysqlserv, $mysqlusr, $mysqlpass) {
	$conn = new mysqli($mysqlserv, $mysqlusr, $mysqlpass);
	$conn->query("SET CHARACTER SET utf8");
	$conn->query("SET NAMES utf8");
	$sql = "CREATE DATABASE pxe_boot";
	if ($conn->query($sql) === TRUE) {
	} else {
	die('<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>MySQL Kurulumu | HATA</b>
	<hr></hr>
	<code>'.$conn->error.'<br></code><br>
	<div class="form-group">
	<br><br><a href="install.php?git=sql_install" " class="btn btn-dark">Tekrar Dene</button><br>
	</div></div></div></body>');
	}
	$conn->close();
	}
	
	function CreateMysqli($mysqlserv, $mysqlusr, $mysqlpass, $sqlSource) {
	$sql = mysqli_connect($mysqlserv, $mysqlusr, $mysqlpass, "pxe_boot");
	mysqli_multi_query($sql,$sqlSource);
	}
	
	function DeleteCookie($name) {
	echo '	<script>document.cookie = "'.$name.'= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";</script>';
	}
	
	function LicenseCommands() {
	$httpd_chmod1 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chmod -R 777 /var/lib/tftpboot/data";
	$httpd_chown1 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chown -R nobody:nobody /var/lib/tftpboot/data";
	$httpd_selinux11 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
	$httpd_selinux21 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
	$tftp_syslinux21 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k	/sbin/restorecon -R -v /var/lib/tftpboot";
	shell_exec($httpd_chmod1);
	shell_exec($httpd_chown1);
	shell_exec($httpd_selinux11);
	shell_exec($httpd_selinux21);
	shell_exec($tftp_syslinux21);

	$stop_firewall = "systemctl stop firewalld";
	$disable_firewall = "systemctl disable firewalld";
	$enforce = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
	$chforce = "chmod -R 777 /var/www/html";
	$choforce = "chown -R nobody:nobody /var/www/html";
	$chcforce = "chcon -R -t httpd_sys_rw_content_t /var/www/html";
	$semanage = "semanage fcontext -a -t httpd_sys_rw_content_t /var/www/html";
	$restoreconforce = "/sbin/restorecon -R -v /var/www/html";

	shell_exec($stop_firewall);
	shell_exec($disable_firewall);
	shell_exec($enforce);
	shell_exec($chforce);
	shell_exec($choforce);
	shell_exec($chcforce);
	shell_exec($semanage);
	shell_exec($restoreconforce);
	}
	
	function ContError($file, $title) {
	if(empty($file)) {
	die('<div class="mx-auto card">
	<div class="card-body">
	<b>Doğrulama Yapılamadı</b>
	<hr>
	<code>'.$title.'</code><br>
	<div class="form-group">
	<br><br><a href="install.php?git=license" class="btn btn-dark">Yenile / Refresh<br>
	</a></div></div></div>');
	} else {
	setcookie($file, strip_tags($file), time()+3600);
	}
	}
}
?>
