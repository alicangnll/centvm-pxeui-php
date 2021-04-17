<?php
include("conn.php");

set_time_limit(0);
if (file_exists("yukle.lock")) {
} else {
die("Yükleme yapılmamış (Eksik dosya : yukle.lock)<br><a href='install.php'>Yükle</a>");
}
$getir = new PXEBoot();
$getir->funcControl('shell_exec');
$getir->funcControl('exec');
$getir->funcControl('system');
$getir->Head("PXE Boot");
$otoinstaller_repo = "https://alicangonullu.info/lisans";
$verify = "https://alicangonullu.info/lisans";
$getir->VerifyLic("".$verify."/keycontrol.php?cre=2&uuid=", $verify); 
$getir->GetLangJSON("update.json");

$getlang = file_get_contents("update.json");
$netwk = json_decode($getlang ,true);
$int = strip_tags($netwk["netw"]);

if(!isset($_GET['git'])) {
$sayfa = 'index';
} elseif(empty($_GET['git'])) {

if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2) == "tr") {
$getir->Error("Sayfa Bulunamadı");
} else {
$getir->Error("Page Not Found");
}

} else {
$sayfa = strip_tags($_GET['git']);
}

switch ($sayfa) {
	
case 'index':
setcookie("csrf_keygen", md5(sha1(rand(8, 15))), time()+3600);
echo '<script>
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "csrf_keygen=; expires=Thu, 18 Dec 2013 12:00:00 UTC";
</script><style>
@media (max-width:800px) {
body {
  background-image: url("https://source.unsplash.com/1080x1920/?turkey,türkiye,atatürk,şehir,manzara,deniz");
  background-repeat: no-repeat;
}
.manzara {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  font-weight: bold;
  text-align: center;
  padding: 15px;
}
.form-control {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
}
@media (min-width:800px) {
body {
  background-image: url("https://source.unsplash.com/1920x1080/?turkey,türkiye,atatürk,şehir,manzara,deniz");
  background-repeat: no-repeat;
}
.manzara {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  text-align: center;
  top: 50%;
  font-weight: bold;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
.form-control {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}

.container  {
border-radius: 20px;
}

}
</style>';
echo '<body class="container mx-auto text-center">
<div class="manzara">';
if(isset($_GET["err"])) {
echo '<script>Metro.infobox.create("<p>Hata<br><hr></hr> Invalid password or username</p>", "alert");</script>';
} else {
}
echo '<form data-role="validator" class="form-signin" action="index.php?git=postlgn" method="post">
	<br><br>
    <h1 class="text-center">PXE Boot Panel</h1><br><br>
      <br><br>
  <label for="inputEmail" class="sr-only">Kullanıcı Adı</label>
  <input type="text" name="mail" data-role="input" class="form-control" placeholder="Kullanıcı Adı" required><br>
    <br><br>  <br><br>
  <label for="inputPassword" class="sr-only">Şifre</label>
  <input type="password" data-role="keypad" data-clear-button="true" name="pass" class="form-control" placeholder="Şifre" required><br>
  
  <input type="hidden" name="csrfkey" class="form-control" value="'.$_COOKIE["csrf_keygen"].'" required><br>
  <button class="button primary" type="submit">Sign in</button>
  <br><br>
  <a class="button alert" href="index.php?git=passwordreset">Password Reset</button>
  <br><br>
</form>
  <p class="mt-5 mb-3 text-muted" style="background: rgba(0,0,0, 0.4);color:white;">&copy; 2019-2020</p><br><br>
</body></div>';
break;

case 'passwordreset':
echo '<div class="container card mt-5">
<div class="window-caption">
<span class="title">Mesajlar / Messages</span>
<div class="buttons">
</div></div>
<div class="window-content p-2">
<form data-role="validator" class="form-signin" action="index.php?git=preset" method="post">
<label for="inputPassword" class="sr-only">Token</label>
<input type="password" data-role="keypad" name="token" class="form-control" placeholder="Token" required><br>
<label for="inputPassword" class="sr-only">E-Mail</label>
<input type="text" name="email" data-role="input" class="form-control" placeholder="E-Mail" required><br>
  <button class="button primary" type="submit">Reset / Sıfırla</button>
  <br>
</form>
</div>';
break;

case 'preset':
if($_POST) {
if(isset($_POST["token"]) && isset($_POST["email"])) {
$email = strip_tags($_POST["email"]);
$token = sha1(md5($_POST["token"]));
$stmt = $db->query("SELECT * FROM admin_list WHERE admin_email = ".$db->quote(strip_tags($email))." AND admin_token = ".$db->quote(strip_tags($token))."");
if ($stmt->rowCount() > 0) {
$str = "0123456789";
$str = str_shuffle($str);
$str = substr($str, 0, 5);
$password = sha1(md5($str));
$db->query("UPDATE admin_list SET admin_passwd = ".$db->quote(strip_tags($password))." WHERE admin_email = ".$db->quote(strip_tags($email))."");
echo '
<br>
<div class="card-body">
<h4>Yeni şifren: '.$str.'</h4>
<hr></hr>
<p>NOT : Şifrenizi Kopyalayın ve <b>BİR YERE KAYDEDİN!</b></p>
<br>
<a class="button alert" href="index.php">Index</button>
</div></body>';
exit();
 } else {
echo '
<br>
<div class="card-body">
<b>Lütfen link yapınızı kontrol ediniz! / Please control link type</b>
<a class="button alert" href="index.php">Index</button>
</div></body>';
exit();
}

} else {
echo '
<br>
<div class="card-body">
<b>Something a fault! / Bir şeyler hatalı!</b>
</div></body>';
exit();
    }
} else {
die("NON-POST");
}
break;
	
case 'postlgn':
if($_POST) {
$name = strip_tags($_POST["mail"]);
$pass = sha1(md5($_POST['pass']));
$csrf = strip_tags($_POST['csrfkey']);

if(isset($csrf)) {

} else {
$getir->Error("CSRF Not Found");
}

if(isset($name) && isset($pass)) {
$query = $db->query("SELECT * FROM admin_list WHERE admin_usrname =".$db->quote($name)." AND admin_passwd = ".$db->quote($pass)." ",PDO::FETCH_ASSOC);
if ( $say = $query -> rowCount() ){
if( $say > 0 ){
$getir_mail = str_replace("@", "", strip_tags($_POST["mail"]));
$json2 = json_decode("yukle.json", true);
session_destroy();
session_start();
$_SESSION["user_id"] = md5($getir_mail);
$_SESSION["admin_adi"] = $getir_mail;

setcookie("user_id", md5($getir_mail), time()+3600);
setcookie("admin_adi", md5($getir_mail), time()+3600);

$stmt = $db->prepare('SELECT * FROM admin_list WHERE admin_usrname = :admin');
$stmt->execute(array(':admin' => $name));
if($rowq = $stmt->fetch()) {
$_SESSION["perm"] = md5($rowq["admin_yetki"]);
$_SESSION["mail_adres"] = strip_tags($rowq["admin_email"]);
}


header('Location: index.php?git=pxeboot');

$komut1 = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$komut2 = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$komut3 = "/sbin/restorecon -R -v /var/lib/tftpboot";
$komut4 = "systemctl stop firewalld";
$komut5 = "systemctl disable firewalld";
$komut6 = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$komut7 = "chmod -R 777 /var/lib/tftpboot/data";
$komut8 = "chown -R nobody:nobody /var/lib/tftpboot/data";
shell_exec($komut4);
shell_exec($komut5);
shell_exec($komut6);
shell_exec($komut7);
shell_exec($komut8);
shell_exec($komut1);
shell_exec($komut2);
shell_exec($komut3);
}

} else {
header('Location: index.php?err=1');
}


} else {
$getir->Error("Non-POST");
}


} else {
$getir->Error("Empty Character");
}
break;

case 'pxeboot':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->GetUpdJSON("update.json", "".$verify."/update_get.json");
} else {
$getir->GetUpdJSONEng("update.json", "".$verify."/update_get.json");
}

$fh = fopen('/proc/meminfo','r');
$mem = 0;
while ($line = fgets($fh)) {
  $pieces = array();
  if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
    $mem = $pieces[1];
    break;
  }
}
function get_server_cpu_usage(){
	$load = sys_getloadavg();
	return intval($load[0]);
}
function get_server_memory_usage(){
	$free = shell_exec('free');
	$free = (string)trim($free);
	$free_arr = explode("\n", $free);
	$mem = explode(" ", $free_arr[1]);
	$mem = array_filter($mem);
	$mem = array_merge($mem);
	$memory_usage = $mem[2]/$mem[1]*100;
	return intval($memory_usage);
}
fclose($fh);
$memus = memory_get_usage();
$load = sys_getloadavg();

$total = (disk_total_space("/")/1024);
$available = (disk_free_space("/")/1024);
$used = ($total - $available);
$hdd_usage = intval($used/$total*100);

$connections = "netstat -na | grep -v ESTABLISHED | grep 69 | grep -v 127.0.0.1 | wc -l";
$totalconnections = "netstat -na | grep -v LISTEN | grep -v 127.0.0.1 | wc -l";
$connections1 = shell_exec($connections);
$totalconnections1 = shell_exec($totalconnections);

if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
echo '<br><br><div class="container page">
    <h1 class="text-center">PXE ISO List</h1>
</div>';

echo '<center><div class="container row mt-2">';
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
echo '<div class="container cell-md-4 mt-4">
<div class="icon-box border bd-default">
<div class="icon bg-red fg-white"><span class="mif-cog"></span></div>
<div class="content p-4">
<div class="text-upper">CPU Traffic</div>

<small class="text-upper text-bold text-lead" id="cpumodel"></small>
<div class="text-upper text-bold text-lead" id="cputrafic"></div>
</div></div></div>';

echo '<div class="container cell-md-4 mt-4">
<div class="icon-box border bd-default">
<div class="icon bg-red fg-white"><span class="mif-codepen"></span></div>
<div class="content p-4">
<div class="text-upper">RAM Usage</div>
<div class="text-upper text-bold text-lead" id="freeram"></div>
</div></div></div>';

echo '<div class="container cell-md-4 mt-4">
<div class="icon-box border bd-default">
<div class="icon bg-red fg-white"><span class="mif-drive"></span></div>
<div class="content p-4">
<div class="text-upper">HDD Capacity</div>
<div class="text-upper text-bold text-lead" id="hddusage"></div>
</div></div></div>

<div class="container cell-md-13 mt-5">
<div class="icon-box border bd-default">
<div class="icon bg-red fg-white"><span class="mif-chart-line"></span></div>
<div class="content p-4">
<div class="text-upper">Uptime</div>
<div class="text-upper text-bold text-lead" id="uptime"></div>
</div></div></div>';

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

echo '</div></center><br>';
$getir->AlertBox('<p><p>Bilgi<br><hr></hr><pre>'.$cp_start.'<br>'.$sysctl_start.'<br>'.$sysctl_enable.'<br>'.$selectz.'<br></pre></p>');


shell_exec($stop_firewall);
shell_exec($disable_firewall);
shell_exec($enforce);
shell_exec($chforce);
shell_exec($choforce);
shell_exec($chcforce);
shell_exec($semanage);
shell_exec($restoreconforce);
if(file_exists("backup/centvm.service")) {
unlink("backup/centvm.service");
} else {
}
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

$select2 = '
[Unit]
Description=CentVM - PHP-based PXE Panel
After=network.target

[Service]
Type=simple
User=root
ExecStart=sh '.dirname(__FILE__).'/backup/custom_start.sh
Restart=on-abort


[Install]
WantedBy=multi-user.target
';
$file4 = fopen("backup/centvm.service", "a");
fwrite($file4, $select2);
fclose($file4);



echo '<center><br><a class="button success mt-5" onclick="BilgiRepair()" role="button">Repair / Bakım</a></center>';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, ''.$verify.'/update_server.json');
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
$getir->GetSlider($obje2->silderone, $obje2->sildertwo, $obje2->silderthree, $obje2->silderonelink, $obje2->sildertwolink, $obje2->silderthreelink);
} else {
$getir->GetSliderEng($obje2->silderone, $obje2->sildertwo, $obje2->silderthree, $obje2->silderonelink, $obje2->sildertwolink, $obje2->silderthreelink);
}
echo '<div class="container mt-5">
<div class="window-caption">
<span class="title">PXE ISO Info</span>
</div>

<div class="window-content p-2">
<table class="table" data-role="table">
<thead>
<tr>
    <th data-sortable="true" data-sort-dir="asc">ID</th>
    <th data-sortable="true" data-format="text">Işletim Sistemi</th>
    <th data-sortable="true"></th>
	<th data-sortable="true"></th>
</tr>
</thead>
<tbody>';
$_DIR = opendir("/var/lib/tftpboot/data/iso");
while (($_DIRFILE = readdir($_DIR)) !== false){
if(!is_dir($_DIRFILE)){
$ext = pathinfo($_DIRFILE, PATHINFO_EXTENSION);
if($_SESSION["perm"] == md5("1")) {
if($ext == "iso") {
  echo '<tr>
      <td><span class="mif-drive2"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
      <td><a href="index.php?git=odeliso&name='.strip_tags($_DIRFILE).'">Sil</a></td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} elseif($ext == "img") {
  echo '<tr>
      <td><span class="mif-drive"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
      <td><a href="index.php?git=odeliso&name='.strip_tags($_DIRFILE).'">Sil</a></td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} elseif($ext == "vhd") {
  echo '<tr>
      <td><span class="mif-drive"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
      <td><a href="index.php?git=odeliso&name='.strip_tags($_DIRFILE).'">Sil</a></td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} elseif($ext == "vhdx") {
  echo '<tr>
      <td><span class="mif-drive"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
      <td><a href="index.php?git=odeliso&name='.strip_tags($_DIRFILE).'">Sil</a></td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} else {
	  echo '<tr>
      <td><span class="mif-files-empty"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
      <td><a href="index.php?git=odeliso&name='.strip_tags($_DIRFILE).'">Sil</a></td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
}

} else {
if($ext == "iso") {
  echo '<tr>
      <td><span class="mif-drive2"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} elseif($ext == "img") {
  echo '<tr>
      <td><span class="mif-drive"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} elseif($ext == "vhd") {
  echo '<tr>
      <td><span class="mif-drive"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} elseif($ext == "vhdx") {
  echo '<tr>
      <td><span class="mif-drive"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
} else {
	  echo '<tr>
      <td><span class="mif-files-empty"></span></td>
      <td>'.strip_tags($_DIRFILE).'</td>
	  <td><a href="index.php?git=genpxe&name='.strip_tags($_DIRFILE).'">Generate Config</a></td>
  </tr>';
}
}


}
}
echo '</tbody></table>
<br><br></div></body>';
break;

case 'odeliso':
$getir->logincheck($_COOKIE['admin_adi']);
$getir->GetSuperPerm($_SESSION["perm"]);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
echo '
<div class="container mt-5">
<div class="window-caption">
<span class="title">PXE ISO Info</span>
</div>

<div class="window-content p-2">
<b>'.strip_tags($_GET["name"]).' adlı dosyayı silmek istediğinize emin misiniz ?</b><br>
<b>You will delete '.strip_tags($_GET["name"]).'. Are you sure ?</b>
<br><br>
<a class="button success" href="index.php?git=deliso&name='.strip_tags($_GET["name"]).'">Yes</a>
<a class="button alert" href="index.php?git=pxeboot">No</a>
</div>
</body>';
break;

case 'deliso':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
echo '</body>';
$file_pointer = "/var/lib/tftpboot/data/iso/".strip_tags($_GET["name"])."";

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
break;

case 'logs':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
$dnsmasq_stat = "systemctl status dnsmasq";
$lsla_stat = "ls -la /var/lib/tftpboot/data/iso";
$netstat = "netstat -v | grep -v STREAM | grep -v DGRAM | grep -v SEQPACKET | grep -v Source | grep -v State | grep -v UNIX | grep -v Bluetooth | grep -v Internet | grep -v centos | grep -v localhost";
$default = "cat /var/lib/tftpboot/pxelinux.cfg/default";
$phpabout = "php -v | grep -v Zend | grep -v Copyright";
$linuxinfo = "uname -a | grep -v grep";
$hostname = "hostnamectl";
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}

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
echo '<div class="container">
<br>
<b>Linux Bilgisi</b>
<hr></hr>
<pre>'.shell_exec($linuxinfo).'</pre>
<br><br>

<b>Hostname Bilgisi</b>
<hr></hr>
<pre>'.shell_exec($hostname).'</pre>
<br><br>

<b>Syslinux Bilgisi</b>
<hr></hr>
<pre>'.shell_exec("syslinux -v").'</pre>
<br><br>

<b>PHP Bilgisi</b>
<hr></hr>
<pre>'.shell_exec($phpabout).'</pre>
<br><br>

<b>DNSMASQ Bilgisi</b>
<hr></hr>
<pre>'.shell_exec($dnsmasq_stat).'</pre>
<br><br>

<b>Dosya Sistemi</b>
<hr></hr>
<pre>'.shell_exec($lsla_stat).'</pre>
<br><br>

<b>PXE Config</b>
<hr></hr>
<pre>'.shell_exec($default).'</pre>
<br><br>

<b>NetStat</b>
<hr></hr>
<pre>'.shell_exec($netstat).'</pre>
<br><br>

</div></div><br></div></body>';
break;

case 'edit':
$getir->logincheck($_COOKIE['admin_adi']);
$getir->GetSuperPerm($_SESSION["perm"]);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
echo '
<div class="container card mt-5">

<div class="window-caption">
<span class="title">DHCP Server Editor</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
  <p>Lütfen DHCP Server bilgilerini giriniz.</p><br>
  <p>Please write DHCP Server informations.</p><br>
<br>
	<form action="index.php?git=pedit" method="post">';
$netw = shell_exec('ls /sys/class/net');
$oparray = preg_split("#[\r\n]+#", $netw);
echo '<div class="form-group">
<label for="exampleInputEmail1">Interface Name</label>
<select data-role="select" id="intname" name="intname">';
$array = array();
foreach($oparray as $line){
echo '<option value="'.trim($line).'">'.trim($line).'</option>';
}
echo '</select></div>';

echo '<div class="form-group">
  <label for="exampleInputEmail1">Server IP</label>
  <input data-role="input" data-role="input" data-prepend="Server IP: " type="text" class="form-control" name="serverip" placeholder="192.168.56.101">
	</div>

	<div class="form-group">
	<label for="exampleInputEmail1">Server Range Lowest IP</label>
	<input data-role="input" data-prepend="Range Lowest IP: " type="text" class="form-control" name="serverlowrange" placeholder="192.168.56.101">
	</div>

	<div class="form-group">
	<label for="exampleInputEmail1">Server Range Highest IP</label>
	<input type="text" data-role="input" data-prepend="Range Highest IP: " class="form-control" name="serverhighrange" placeholder="192.168.56.254">
	</div>

	<div class="form-group">
	<label for="exampleInputEmail1">Server Gateway</label>
	<input type="text" data-role="input" data-prepend="Server Gateway: " class="form-control" name="servergateway" placeholder="255.255.255.0">
	</div>
	
		<div class="form-group">
	<label for="exampleInputEmail1">Ekstra Ayarlar</label>
	<textarea data-role="textarea" class="form-control" name="extracfg" placeholder="Ekstra Ayarlar"></textarea>
	</div>
	<br>
	<button type="submit" class="button secondary">Gönder</button>
</form>

</div></body>';
break;

case 'pedit':
$getir->logincheck($_COOKIE['admin_adi']);
$getir->GetSuperPerm($_SESSION["perm"]);
if (file_exists("backup/dnsmasq.conf")) {
	unlink("backup/dnsmasq.conf");
	touch("backup/dnsmasq.conf");
} else {
	touch("backup/dnsmasq.conf");
}
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
'.strip_tags($_POST["extracfg"]).'
dhcp-boot=pxelinux.0
pxe-service=x86PC, "PXE Boot Manager / By Ali Can Gonullu", pxelinux
# Enable TFTP
enable-tftp
tftp-root=/var/lib/tftpboot';
$file3 = fopen("backup/dnsmasq.conf", "a");
fwrite($file3, $select);
fclose($file3);
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
$shell2 = shell_exec("rm -rf /etc/dnsmasq.conf");
$shell3 = shell_exec("cp backup/dnsmasq.conf /etc/");
echo '
<div class="container card mt-5">

<div class="window-caption">
<span class="title">DHCP Server Editor</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<code>
<b> Lütfen bu kodları root izniyle /etc/dnsmasq.conf içeriğini tamamen sildikten sonra yapıştırın. (Eğer panel bunu yapıştıramazsa)</b><br>
<b> Please paste these codes with root permission after deleting /etc/dnsmasq.conf completely. (If panel cannot paste that) </b><br>
<br><pre>'.$select.'</pre>
<hr></hr>
<b> cat /etc/dnsmasq.conf</b><br>
<hr></hr>
<br><pre>'.shell_exec("cat /etc/dnsmasq.conf").'</pre>
</code>
<br>
</div></body>';
break;

case 'genpxe':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
echo '

<div class="container card mt-5">

<div class="window-caption">
<span class="title">ISO PXE Config</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<p>Lütfen ISO PXE Config bilgilerini giriniz.</p>
<br>
<b>ISO Name : '.strip_tags($_GET["name"]).'</b>
<br>
<form action="index.php?git=pgenpxe" method="post">

<div class="form-group">
<label for="exampleInputEmail1">Label ID</label>
<input type="text" data-role="input" data-prepend="Label ID: " class="form-control" name="labelid" placeholder="Label ID">
</div>


<input type="hidden" class="form-control" name="labelisoname" value="'.strip_tags($_GET["name"]).'">
<div class="form-group">
<label for="exampleInputEmail1">ISO Location</label>
<input type="text" data-role="input" data-prepend="ISO Location: " class="form-control" name="labelisoname" placeholder="data/iso/'.strip_tags($_GET["name"]).' | http://'.strip_tags($_SERVER['SERVER_NAME']).'/backup/'.strip_tags($_GET["name"]).'">
</div>


<div class="form-group">
<label for="exampleInputEmail1">Label Name</label>
<input type="text" data-role="input" data-prepend="Label Name: " class="form-control" name="labelname" placeholder="Win/Linux/macOS">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Special Config</label>
<input type="text" data-role="input" data-prepend="Special Config: " class="form-control" name="speconf" placeholder="append iso raw">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Other Config</label>
<input type="text" data-role="input" data-prepend="Other Config: " class="form-control" name="othercfg" placeholder="Other Config">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Delete Old PXE Menu</label>
<select name="delete" data-role="select" class="form-control" id="delete">
<option value="1">YES</option>
<option value="0">NO</option>
</select>
</div>
<br><br><br>
<button class="button secondary">Create</button>
</form></div>
</body>';
break;


case 'pgenpxe':
if($_POST) {
$word1 = strip_tags($_POST["labelisoname"]);
$word = str_replace(".", "", $word1);
$file = "backup/default-".$word."";
if (!file_exists($file)) {
	touch($file);
} else {
  unlink($file);
  touch($file);
}

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

echo '';
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]); 
if(intval($_POST["labelid"]) <= 1) {
die("<p>PXE Data Unsuccesfully</p>
<p>Label ID birden küçük olmamalı</p> 
<br>
<a class='button secondary'>Home Page / Ana Sayfa</a>
</body>");
} else {
}



if(intval($_POST["delete"]) == "1") {
$txt = 'default menu.c32
prompt 0
timeout 100

# Local Hard Disk pxelinux.cfg default entry
menu title PXE Boot Menu By Ali Can
LABEL 1
MENU LABEL Boot local hard drive
MENU AUTOBOOT
MENU DEFAULT
LOCALBOOT 0

LABEL '.intval($_POST["labelid"]).'
MENU LABEL '.strip_tags($_POST["labelname"]).'
kernel memdisk
initrd '.strip_tags($_POST["labelisoname"]).'
'.strip_tags($_POST["speconf"]).' 
'.strip_tags($_POST["othercfg"]).'';
$shell = shell_exec("rm -rf /var/lib/tftpboot/pxelinux.cfg/default");
$fp = fopen("/var/lib/tftpboot/pxelinux.cfg/default","a");
fwrite($fp,$txt);
fclose($fp);

$update = $db->prepare("INSERT INTO boot_menu(boot_name, boot_isoname, boot_speconf, boot_othercfg, boot_date, boot_labelid) VALUES (:bootname, :isoname, :speconf, :othercfg, :tarih, :labelid) ");
$update->bindValue(':bootname', strip_tags($_POST["labelname"]));
$update->bindValue(':isoname', strip_tags($_POST["labelisoname"]));
$update->bindValue(':speconf', strip_tags($_POST["speconf"]));
$update->bindValue(':othercfg', strip_tags($_POST["othercfg"]));
$update->bindValue(':labelid', strip_tags($_POST["labelid"]));
$update->bindValue(':tarih', date("Y-m-d"));
$update->execute();
if($update){
echo '
<div class="card-body">
<code>
<b> Lütfen bu kodları root izniyle /var/lib/tftpboot/default içeriğini tamamen sildikten sonra yapıştırın. </b><br>
<br><pre>'.$txt.'</pre>
<br><pre>'.$shell.'</pre>
</code>
</div></body>';
}

} else {
$txt = '
LABEL '.intval($_POST["labelid"]).'
MENU LABEL '.strip_tags($_POST["labelname"]).'
kernel memdisk
initrd '.strip_tags($_POST["labelisoname"]).'
'.strip_tags($_POST["speconf"]).' 
'.strip_tags($_POST["othercfg"]).'';

$fp = fopen("/var/lib/tftpboot/pxelinux.cfg/default","a");
fwrite($fp,$txt);
fclose($fp);

$update = $db->prepare("INSERT INTO boot_menu(boot_name, boot_isoname, boot_speconf, boot_othercfg, boot_date) VALUES (:bootname, :isoname, :speconf, :othercfg, :tarih) ");
$update->bindValue(':bootname', strip_tags($_POST["labelname"]));
$update->bindValue(':isoname', strip_tags($_POST["labelisoname"]));
$update->bindValue(':speconf', strip_tags($_POST["speconf"]));
$update->bindValue(':othercfg', strip_tags($_POST["othercfg"]));
$update->bindValue(':tarih', date("Y-m-d"));
$update->execute();
if($update){
echo '
<div class="card-body">
<code>
<b> Lütfen bu kodları root izniyle /var/lib/tftpboot/default içeriğini tamamen sildikten sonra yapıştırın. </b><br>
<br><pre>'.$txt.'</pre>
</code>
</div></body>';
}

}

}
break;

case 'repair':
$getir->logincheck($_COOKIE['admin_adi']);

$stop_firewall = "systemctl stop firewalld";
$disable_firewall = "systemctl disable firewalld";
$enforce = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chforce = "chmod -R 777 /var/lib/tftpboot/data";
$choforce = "chown -R nobody:nobody /var/lib/tftpboot/data";
$chcforce = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$semanage = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$restoreconforce = "/sbin/restorecon -R -v /var/lib/tftpboot";

shell_exec($stop_firewall);
shell_exec($disable_firewall);
shell_exec($enforce);
shell_exec($chforce);
shell_exec($choforce);
shell_exec($chcforce);
shell_exec($semanage);
shell_exec($restoreconforce);
if(file_exists("backup/centvm.service")) {
unlink("backup/centvm.service");
} else {
}
if(file_exists("backup/custom_start.sh")) {
unlink("backup/custom_start.sh");
} else {
}
$select = ''.$stop_firewall.'
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

$select2 = '
[Unit]
Description=CentVM - PHP-based PXE Panel
After=network.target

[Service]
Type=simple
User=root
ExecStart=sh '.dirname(__FILE__).'/backup/custom_start.sh
Restart=on-abort


[Install]
WantedBy=multi-user.target
';
$file4 = fopen("backup/centvm.service", "a");
fwrite($file4, $select2);
fclose($file4);

$cp_start = "cp ".dirname(__FILE__)."/backup/centvm.service /etc/systemd/system/";
$sysctl_start = "systemctl start centvm.service";
$sysctl_enable = "systemctl enable centvm.service";
echo '
<br>
<div class="container card mt-5">
<div class="window-caption">
<span class="title">PXE Repair Info</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<p>Lütfen Komut Bloğuna Bağlanıp <b>root</b> olarak komutları girin</p>
<p>Yeniden başlatma gibi işlemlerde yapmanız gerekmektedir</p>
<br>
<pre>
'.$cp_start.'
'.$sysctl_start.'
'.$sysctl_enable.'
'.$select.'
</pre>
<br>
<a type="button" class="button secondary" href="index.php?git=pxeboot" class="btn btn-dark">Ana Sayfa</a>
</div></body>';
break;

case 'addiso':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, ''.$otoinstaller_repo.'/get_oslist.php');
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

$json3 = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$obje3 = json_decode($json3, true);
echo '
<br><br>
<div class="container card">

<div class="window-caption">
<span class="title">WGet ISO</span>
<div class="buttons"></div></div>
<form action="index.php?git=paddiso" method="post">
<div class="form-group">
<br>
<input data-role="input" data-prepend="WGet Link: " type="text" class="form-control" name="wgetiso">
</div>
<br>
<button class="button secondary">Download</button></form>
<br>

<div class="window-caption">
<span class="title">ISO Automatic Installer</span>
<div class="buttons"></div></div>
<form action="index.php?git=autoinstaller" method="post">
<div class="form-group">
<br>
<select data-role="select" name="server">
<optgroup label="ISO List">';
foreach($obje3 as $getz) {
echo '<option value="'.strip_tags(urlencode($getz["iso_name"])).'">'.strip_tags($getz["iso_name"]).'</option>';
}
echo '</optgroup></select></div>
<br>
<button class="button secondary">Install</button></form>
<br><br>

<div class="window-caption">
<span class="title">Upload ISO</span>
<div class="buttons"></div></div>
<div class="buttons"></div>
<form id="upload_form" enctype="multipart/form-data" method="post">
<div class="form-group">
<br>
<input data-mode="drop" type="file" class="form-control" name="dosya" id="dosya" data-role="file" onchange="uploadFile()">
</div>
<br>
<progress id="progressBar" class="absolute top-0 h-4 rounded shim-blue" style="-webkit-appearance:none;appearance:none;width:100%;" value="0" max="100" style="width:100%;"></progress>
<h3 id="status"></h3><br>
</form>
</div>


</body>';
?>
<script>
function _(el) {
  return document.getElementById(el);
}

function uploadFile() {
  var file = _("dosya").files[0];
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  formdata.append("dosya", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "index.php?git=upliso"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
  //use file_upload_parser.php from above url
  ajax.send(formdata);
}

function progressHandler(event) {
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").value = Math.round(percent);
  _("status").innerHTML = Math.round(percent) + "% yüklendi...";
}

function completeHandler(event) {
  _("status").innerHTML = "Basariyla Yuklendi";
  _("progressBar").value = 0; //wil clear progress bar after successful upload
}

function errorHandler(event) {
  _("status").innerHTML = "Yukleme Basarisiz";
}

function abortHandler(event) {
  _("status").innerHTML = "Yukleme Durduruldu";
}
</script>
<?php
break;

case 'autoinstaller':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
ini_set('post_max_size', '10240M'); 
ini_set('upload_max_filesize', '10240M');
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "".$otoinstaller_repo."/get_oslist.php?isoname=".strip_tags($_POST["server"])."");
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

$json4 = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$obje4 = json_decode($json4, true);

$yuklenecek_dosya = "wget -P /var/lib/tftpboot/data/iso ".escapeshellarg($obje4["0"]["iso_url"])."";
$stop_firewall = "systemctl stop firewalld";
$syslinuxcfg = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chmod_cfg = "chmod -R 777 /var/lib/tftpboot/data";
$chown_cfg = "chown -R nobody:nobody /var/lib/tftpboot/data";
$chcon_cfg = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$semanage_cfg = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$restorecon_cfg = "/sbin/restorecon -R -v /var/lib/tftpboot";

echo '
<div class="container mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme Penceresi / ISO Upload Window</span>
</div>

<div class="window-content p-2">
<pre>
URL : '.($obje4["0"]["iso_url"]).'<br>
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
break;

case 'upliso':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
ini_set('post_max_size', '10240M'); 
ini_set('upload_max_filesize', '10240M');
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
$dizin2 = '/var/lib/tftpboot/data/iso/';
echo '</body>';


if(!empty($_FILES['dosya'])) {
$path = "backup/";
$path = $path . basename($_FILES['dosya']['name']);
$ext = pathinfo($_FILES['dosya']['name'], PATHINFO_EXTENSION);
if($ext == "iso") {
} elseif($ext == "img") {
} elseif($ext == "dmg") {
} elseif($ext == "bin") {
} elseif($ext == "vhdx") {

if(file_exists($_FILES['dosya']['name'])) {
$vhdext = "guestmount --add ".strip_tags($_FILES['dosya']['name']).".vhdx --inspector --ro ".dirname(__FILE__)."/backup/".strip_tags($_FILES['dosya']['name'])."";
} else {
$create = "mkdir ".dirname(__FILE__)."/backup/".strip_tags($_FILES['dosya']['name'])."";
$vhdext = "guestmount --add ".strip_tags($_FILES['dosya']['name']).".vhdx --inspector --ro ".dirname(__FILE__)."/backup/".strip_tags($_FILES['dosya']['name'])."";
}

} elseif($ext == "vhd") {

if(file_exists($_FILES['dosya']['name'])) {
$vhdext = "guestmount --add ".strip_tags($_FILES['dosya']['name']).".vhd --inspector --ro ".dirname(__FILE__)."/backup/".strip_tags($_FILES['dosya']['name'])."";
} else {
$create = "mkdir ".dirname(__FILE__)."/backup/".strip_tags($_FILES['dosya']['name'])."";
$vhdext = "guestmount --add ".strip_tags($_FILES['dosya']['name']).".vhd --inspector --ro ".dirname(__FILE__)."/backup/".strip_tags($_FILES['dosya']['name'])."";
}

} else {
die('<div class="container card mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme / ISO Upload</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>Uzantı desteklenmiyor</b>
</div></div>');
}
if(move_uploaded_file($_FILES['dosya']['tmp_name'], $path)) {
$getcp = "mv ".dirname(__FILE__)."/backup/".basename($_FILES['dosya']['name'])." /var/lib/tftpboot/data/iso";

$stop_firewall = "systemctl stop firewalld";
$syslinuxcfg = "setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
$chmod_cfg = "chmod -R 777 /var/lib/tftpboot/data";
$chown_cfg = "chown -R nobody:nobody /var/lib/tftpboot/data";
$chcon_cfg = "chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$semanage_cfg = "semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$restorecon_cfg = "/sbin/restorecon -R -v /var/lib/tftpboot";

echo '
<div class="container card mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme Penceresi / ISO Upload Window</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>'.$getcp.'</b><br>
<b>'.strip_tags(basename($_FILES['dosya']['name'])).' Dosya Başarıyla Yüklendi</b>
<br>

<pre>
'.shell_exec($create).'<br>
'.shell_exec($vhdext).'<br>

'.shell_exec($getcp).'<br>
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

} else {
echo '<div class="container card mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme / ISO Upload</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>'.strip_tags(basename( $_FILES['dosya']['name'])).' Dosya Yüklenemedi</b>
</div></div>';
	}
}
break;

case 'speedtest':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
$getir->GetMicro();
break;


case 'paddiso':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
}
$yuklenecek_dosya = "wget -P /var/lib/tftpboot/data/iso ".escapeshellarg($_POST["wgetiso"])."";
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
break;

case 'admin':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
if($_SESSION["perm"] == md5("1")) {
echo '
<br><br><div class="container card mt-5">
<div class="window-caption">
<span class="title">Kullanıcı İşlemleri / User Configurations</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<a class="button" href="index.php?git=langupd">Dil Değiştirme / Change Language </a><br><br>
<a class="button" href="index.php?git=resetpass">Şifre Sıfırlama / Password Reset</a><br><br>
<a class="button" href="index.php?git=resettoken">Token Sıfırlama / Token Reset</a><br><br>
<a class="button" href="index.php?git=addadmin">Admin Ekle / Add Admin</a><br>';

echo '<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Username</th>
        <th>E-Mail</th>
		<th>Yetki</th>
        <th></th>
    </tr>
    </thead>
    <tbody>';
$stmt = $db->prepare('SELECT * FROM admin_list');
$stmt->execute();
while($rowd = $stmt->fetch()) {
echo '<tr>
<td>'.intval($rowd["admin_id"]).'</td>
<td>'.strip_tags($rowd["admin_usrname"]).'</td>
<td>'.strip_tags($rowd["admin_email"]).'</td>';
if(strip_tags($rowd["admin_yetki"]) == "1") {
echo '<td><font color="green">Admin</font></td>';
} else {
echo '<td><font color="red">User</font></td>';
}
echo '<td><a href="index.php?git=deladmin&id='.intval($rowd["admin_id"]).'">Sil</a></td>
</tr>';
}
echo '</div><br></tbody></table></body>';
} else {
echo '
<br><br><div class="container card mt-5">
<div class="window-caption">
<span class="title">Kullanıcı İşlemleri / User Configurations</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<a class="button" href="index.php?git=resetpass">Şifre Sıfırlama / Password Reset</a><br><br>
<a class="button" href="index.php?git=resettoken">Token Sıfırlama / Token Reset</a><br><br>
</div></body>';
}
break;

case 'deladmin':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$stmt = $db->prepare('DELETE FROM admin_list WHERE admin_id = :postID');
$stmt->execute(array(':postID' => strip_tags($_GET["id"])));
if($stmt){
echo ('
<div class="container card mt-5">
<div class="window-caption">
<span class="title">Admin Silindi / Admin Deleted</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>Kullanıcı başarıyla silindi</b><br>
</div></div></body>'); 
}

break;

case 'addadmin':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
echo '

<div class="container card mt-5">

<div class="window-caption">
<span class="title">Admin Ekle / Add Admin</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<form action="index.php?git=paddadmin" id="loginForm" name="loginForm" method="post">


<div class="form-group">
<label for="exampleInputEmail1">Kullanıcı Adı / Username</label>
<input type="text" data-role="input" data-prepend="Kullanıcı Adı / Username: " class="form-control" name="username" id="username" placeholder="Kullanıcı Adı / Username">
</div>

<div class="form-group">
<label for="exampleInputEmail1">E-Mail / E-Posta</label>
<input type="text" data-role="input" data-prepend="E-Mail / E-Posta: " class="form-control" name="email" id="email" placeholder="E-Mail / E-Posta">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Şifre / Password</label>
<input type="password" data-role="keypad" data-prepend="Şifre / Password: " class="form-control" name="password" id="password" placeholder="Şifre / Password">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Şifre Tekrar / Password Again</label>
<input type="password" data-role="keypad" data-prepend="Şifre Tekrar / Password Again: " class="form-control" data-validate="required compare=password"  name="confirmpassword" id="confirmpassword" placeholder="Şifre Tekrar / Password Again">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Token / Token</label>
<input type="password" data-role="keypad" data-prepend="Token / Token " class="form-control" name="tokens" placeholder="Token / Token">
</div>

<div class="form-group">
<label for="exampleInputEmail1">Yetki / Permission</label>
<select name="perm" data-role="select" class="form-control" id="perm">
<option value="1">Admin</option>
<option value="2">User</option>
</select>
</div>

<br><br><br>
<span class="invalid_feedback">Pass1 and Pass2 must be equal.</span><br>
<button class="button secondary">Create</button>
</form></div>
</body>';

break;

case 'paddadmin':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$update = $db->prepare("INSERT INTO admin_list(admin_email, admin_usrname, admin_passwd, admin_token, admin_yetki) VALUES (:email, :usrname, :passwd, :token, :perm) ");
$update->bindValue(':email', strip_tags($_POST["email"]));
$update->bindValue(':usrname', strip_tags($_POST["username"]));
$update->bindValue(':passwd', sha1(md5($_POST["password"])));
$update->bindValue(':token', sha1(md5($_POST["tokens"])));
$update->bindValue(':perm', strip_tags($_POST["perm"]));
$update->execute();
if($update){
echo '<div class="container card mt-5">

<div class="window-caption">
<span class="title">Admin Ekle / Add Admin</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>Başarılı / Successful</b><br>
<a href="index.php?git=pxeboot" class="button secondary">Back / Geri Dön</button>
</div>';
}
break;

case 'resetpass':
$getir->logincheck($_COOKIE['admin_adi']);

if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 

$stmt = $db->prepare('SELECT * FROM admin_list WHERE admin_usrname = :admin');
$stmt->execute(array(':admin' => $_SESSION["admin_adi"]));
if($row = $stmt->fetch()) {
echo '<div class="container card card mt-5">
<div class="window-caption">
<span class="title">Şifre Sıfırlama / Password Reset</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<form data-role="validator" class="form-signin" action="index.php?git=presetpass" method="post">
<label for="inputPassword" class="sr-only">Şifre</label>
<input type="password" data-role="keypad" data-prepend="Şifre: " name="passw" class="form-control" placeholder="Şifre" required><br>
  <button class="button primary" type="submit">Reset / Sıfırla</button>
  <br>
</form>
</div>
</body>';
}
break;

case 'resettoken':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$stmt = $db->prepare('SELECT * FROM admin_list WHERE admin_usrname = :admin');
$stmt->execute(array(':admin' => $_SESSION["admin_adi"]));
if($row = $stmt->fetch()) {
echo '
<br>
<div class="container card mt-5">
<div class="window-caption">
<span class="title">Token Sıfırlama / Reset Token</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<div class="card-body">
<form data-role="validator" class="form-signin" action="index.php?git=presettoken" method="post">
<label for="inputPassword" class="sr-only">Token Sıfırla / Reset Token</label>
<input type="password" data-role="keypad" data-prepend="Token: " name="tokenw" class="form-control" placeholder="Token" required><br>
  <button class="button primary" type="submit">Reset / Sıfırla</button>
  <br>
</form>
</div></div>
</body>';
}
break;

case 'presettoken':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 

$update = $db->prepare("UPDATE admin_list SET admin_token = :token WHERE admin_usrname = :adi");
$update->bindValue(':token',  sha1(md5($_POST["tokenw"])));
$update->bindValue(':adi', strip_tags($_SESSION["admin_adi"]));
$update->execute();
if($row = $update->rowCount()) {
echo '
<div class="container card mt-5">
<div class="window-caption">
<span class="title">Şifre Sıfırlama Penceresi / Password Reset Window</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>Şifre Sıfırlama Başarılı / Successful</b><br>
<a class="button primary" href="index.php?git=pxeboot">Home Page / Ana Sayfa</a>
</div></div></body>';
} else {
echo '
<div class="container card mt-5">
<div class="window-caption">
<span class="title">Şifre Sıfırlama Penceresi / Password Reset Window</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>Şifre Sıfırlama Başarısız / Unsuccessful</b><br>
<a class="button primary" href="index.php?git=pxeboot">Home Page / Ana Sayfa</a>
</div></div></body>';
}
break;


case 'presetpass':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 

$update = $db->prepare("UPDATE admin_list SET admin_passwd = :sifre WHERE admin_usrname = :adi");
$update->bindValue(':sifre',  sha1(md5($_POST["passw"])));
$update->bindValue(':adi', strip_tags($_SESSION["admin_adi"]));
$update->execute();
if($row = $update->rowCount()) {
echo '
<div class="container card mt-5">
<div class="window-caption">
<span class="title">ISO Yükleme Penceresi / ISO Upload Window</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<b>Şifre Sıfırlama Başarılı</b><br>
<a class="button primary" href="index.php?git=pxeboot">Home Page / Ana Sayfa</a>
</div></div></body>';
} else {
}
break;

case 'langupd':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$file = json_decode("update.json" ,true);

echo '<div class="container card mt-5">
<div class="window-caption">
<span class="title">Dil Değiştirme / Choose Language</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<form action="index.php?git=plangupd" method="post">
<div class="form-group">
<label for="exampleInputEmail1">Language / Dil</label>
<input type="text" data-role="input" class="form-control" name="lang" placeholder="TR/EN"><br><br>';
echo '<label for="exampleInputEmail1">Network Interface / Ağ Donanımı</label>
<select data-role="select" id="netwdrv" name="netwdrv">';
$netw = shell_exec('ls /sys/class/net');
$oparray = preg_split("#[\r\n]+#", $netw);
$array = array();
foreach($oparray as $line){
echo '<option value="'.$line.'">'.$line.'</option>';
}
echo '</select><br><br>
<button type="submit" class="btn btn-dark">İleri / Next</button><br>
</div></form></div></body>';
break;

case 'plangupd':
$getir->GetSuperPerm($_SESSION["perm"]);
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 

$file = "update.json";
if (file_exists($file)) {
unlink($file);
$txt = "";
$fp = fopen($file,"a");
fwrite($fp,$txt);
fclose($fp);
} else {
$txt = "";
$fp = fopen($file,"a");
fwrite($fp,$txt);
fclose($fp);
}
$data = '{"version_name": "Cygen","version": "11","lang" : "'.strip_tags($_POST["lang"]).'", "netw": "'.strip_tags($_POST["netwdrv"]).'"}';
file_put_contents($file, $data);
$json = json_decode($file,  true);
echo '<script>
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
</script>

<div class="card-body">
<pre>'.$data.'</pre>
</div>
<br>
<a class="button primary" href="index.php?git=langupd">Go Home</a></body>';
session_destroy($_SESSION["lang"]);

break;

case 'mesaj':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$ds = shell_exec('udevadm info --query=all --name=/dev/sda | grep ID_SERIAL_SHORT');
$serialx = explode("=", $ds);
$serial = $serialx[1];
$server_ip = strip_tags($_SERVER['SERVER_ADDR']);
$server_ip2 = str_replace("::1", "localhost", $server_ip);

$urlget = "".$verify."/mesajget.php?uuid=".md5($serial)."&host=".$server_ip2."";
$promote = "".$verify."/promote.php?uuid=".md5($serial)."&host=".$server_ip2."";

$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $promote);
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

$jsong = json_decode($gelg, true);


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

$gelg2 = curl_exec($ch2);
if (curl_errno($ch2)) {
echo '<script>console.log("Error:' . curl_error($ch2).'");</script>';
}
curl_close($ch2);

$jsong2 = json_decode($gelg2, true);

if($_SESSION["perm"] == md5("1")) {
echo '
<div class="container card mt-5 mt-5">
<div class="window-caption">
<span class="title">Mesajlar / Messages</span>
<div class="buttons">
</div></div>
<div class="window-content p-2">
<br><br>
<table class="table table-border cell-border" data-role="table">
<thead>
<tr>
	<th data-sortable="true">ID</th>
    <th>Mesaj Başlık</th>
    <th>Durum</th>
    <th></th>
</tr>
</thead>
<tbody>';
foreach($getir->limit($jsong, 10) as $ig){
echo '<tr class="red">
<td id="mesajid">'.intval($ig['mesaj_id']).'</td>
<td id="mesajbaslik">'.$ig['mesaj_baslik'].'</td>
<td id="mesajdurum">'.$ig['mesaj_durum'].'</td>
<td id="mesajid"><a href="index.php?git=promotegor&id='.intval($ig['mesaj_id']).'">Gör</a></td>
</tr>';
}
foreach($getir->limit($jsong2, 10) as $ig){
echo '<tr class="red">
<td id="mesajid">'.intval($ig['mesaj_id']).'</td>
<td id="mesajbaslik">'.$ig['mesaj_baslik'].'</td>
<td id="mesajdurum">'.$ig['mesaj_durum'].'</td>
<td id="mesajid"><a href="index.php?git=mesajgor&id='.intval($ig['mesaj_id']).'">Gör</a></td>
</tr>';
}
echo '</tbody>
</div>
<b>UUID : '.md5($serial).'</b><br><br>
<a class="button primary" href="index.php?git=community">Chat with Community</a><br><br>
<a class="button primary" href="index.php?git=mesajgonder">Send Message to Creator</a><br><br>
</body>';
} else {
echo '<div class="container card mt-5 mt-5">
<div class="window-caption">
<span class="title">Mesajlar / Messages</span>
<div class="buttons">
</div></div>
<div class="window-content p-2">
<b>UUID : '.md5($serial).'</b><br><br>
<a class="button primary" href="index.php?git=community">Chat with Community</a><br><br>
</div></body>';
}
break;

case 'mesajgonder':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$url = "".$verify."/mesajgonder.php";
$ds = shell_exec('udevadm info --query=all --name=/dev/sda | grep ID_SERIAL_SHORT');
$serialx = explode("=", $ds);
$serial = $serialx[1];
echo '<div class="container card mt-5 mt-5">
<div class="window-caption">
<span class="title">Sent Message / Mesaj Gönder</span>
<div class="buttons">
</div></div>
<div class="window-content p-2">
<form action="'.$url.'" method="post" class="container">

<div class="form-group">
<p>Name</p>
<input type="text" data-role="input" class="mt-4" name="baslik" id="baslik"></div>

<div class="form-group">
<p>E-Mail</p>
<input type="email" data-role="input" class="mt-4" name="mail" id="mail"></div>

<div class="form-group">
<p>Comment</p>
<textarea data-role="textarea" class="mt-4" name="konu" id="konu"></textarea></div>
<input type="hidden" name="uuid" id="uuid" value="'.md5($serial).'">

<input class="button primary mt-5" type="submit" value="Submit">
</form></div></div>';
break;

case 'mesajgor':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$getir->GetMessages($verify, $_GET["id"]);
break;

case 'promotegor':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 
$getir->GetPromoteMessages($verify, $_GET["id"]);
break;


case 'community':
$getir->logincheck($_COOKIE['admin_adi']);
if($_SESSION["lang"] == "TR") {
$getir->NavBar($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} else {
$getir->NavBarEng($_SESSION["admin_adi"], $_SESSION["mail_adres"]);
} 

$ds = shell_exec('udevadm info --query=all --name=/dev/sda | grep ID_SERIAL_SHORT');
$serialx = explode("=", $ds);
$serial = $serialx[1];
$server_ip = strip_tags($_SERVER['SERVER_ADDR']);
$server_ip2 = str_replace("::1", "localhost", $server_ip);
$machine = shell_exec("cat /etc/machine-id");
$urlz = "".$verify."/getcommunity.php?uuid=".md5($machine)."&host=".$server_ip2.""; 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlz);
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

$gelz = curl_exec($ch);
if (curl_errno($ch)) {
echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$machine = shell_exec("cat /etc/machine-id");
$jsonz = json_decode($gelz, true);
?>

<div class="container card mt-5 mt-5">
<div class="window-caption">
<span class="title">Kullanıcılarla Konuşma / Chat with Community</span>
<div class="buttons">
</div></div>

<div class="window-content p-2">
<pre id="output">
<?php
foreach($getir->limit($jsonz, 20) as $iz){
	
echo '<b>'.$iz["mesaj_uuid"].'</b> : '.$iz["mesaj_icerik"].'<br>';
}
?>
</pre><br>
<script>
$(document).ready(function(){
  $("button").click(function(){
    var mesaj = $("#mesaj").val();
    $.post("<?php echo $verify; ?>/mesajal.php",
    {
      uuid: "<?php echo md5($machine); ?>",
      dom: "<?php echo $_SERVER['SERVER_ADDR']; ?>",
      ip: "<?php echo trim($_SERVER['REMOTE_ADDR']); ?>",
      mesaj: mesaj
      
    },
    function(data,status){
      console.log("Durum: " + status + "/" + data);
      location.reload();
    });
  });
});
</script>
<?php
echo '</pre>
  <label for="inputPassword" class="sr-only">Mesaj İçeriği</label>
  <textarea data-role="textarea" class="card" name="mesaj" placeholder="Mesaj Yaz..." id="mesaj" data-role-textarea="true" style="width: 100%;"></textarea>
  <br>
  <button class="button primary" type="submit">Mesaj Gönder</button></div></body>';
break;
break;

case 'pxecikis':
$getir->logincheck($_COOKIE['admin_adi']);
session_destroy();
?>
<script>
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "mail_adres= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
window.location.replace("index.php");
</script>
<?php
break;

default:
die('<script>
document.cookie = "csrf_keygen=; expires=Thu, 18 Dec 2013 12:00:00 UTC";
</script><style>
@media (max-width:800px) {
body {
  background-image: url("https://source.unsplash.com/1080x1920/?turkey,türkiye,atatürk,şehir,manzara,deniz");
  background-repeat: no-repeat;
}
.manzara {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  font-weight: bold;
  text-align: center;
  padding: 15px;
}
.form-control {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
}
@media (min-width:800px) {
body {
  background-image: url("https://source.unsplash.com/1920x1080/?turkey,türkiye,atatürk,şehir,manzara,deniz");
  background-repeat: no-repeat;
}
.manzara {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  text-align: center;
  top: 50%;
  font-weight: bold;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}
.form-control {
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
  color: white;
  box-shadow: 3px solid #f1f1f1;
  z-index: 2;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
}

.container  {
border-radius: 20px;
}

}
</style>
<body class="container mx-auto text-center">
<div class="manzara">
<p class="mt-5 mb-3 text-muted" style="color:white;">Sayfa Bulunamadı</p><br><br>
<a class="button primary" href="index.php">Ana Sayfa</a><br><br>
</body></div>');
break;
}
?>
