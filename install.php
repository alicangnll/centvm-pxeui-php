<?php
include("func.php");
$getir = new PXEBoot();
$verify = "https://alicangonullu.info/lisans";
if(file_exists("yukle.lock")) {
	die('<div class="container mx-auto mt-5 card">
	<div class="card-body">
	<b>Yukle.Lock / File Found</b>
	<hr>
	<code>Yukle.Lock dosyası bulundu</code><br>
	<div class="form-group">
	<br><br><a href="install.php?git=index" class="btn btn-dark">Yenile / Refresh<br>
	</a></div></div></div>');
	} else {}
	echo '<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script><meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PXE Installer</title>
	</head>
	<style>
	@fontName:	-apple-system,
	system-ui,
	BlinkMacSystemFont,
	"Segoe UI", "Roboto", "Ubuntu",
	"Helvetica Neue", sans-serif;
	@media (max-width:800px) {
	body {
	background-image: url("https://source.unsplash.com/1080x1920/?turkey,türkiye,atatürk,şehir,manzara,deniz");
	align-items: center;
	justify-content: center;
	}
	}
	body {
	background-image: url("https://source.unsplash.com/1920x1080/?turkey,türkiye,atatürk,şehir,manzara,deniz");
	align-items: center;
	justify-content: center;
	}
	</style>';
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
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Merhabalar</b>
	<hr></hr>
	<p>PHP PXE Yönetim Paneli Server kurulumuna hoşgeldiniz. Devam etmek için lütfen devam tuşuna tıklayın.</p><br>
	<b> Virtualbox 6.1 için kurmanız gereken dosya için <a href="https://download.virtualbox.org/virtualbox/6.1.8/Oracle_VM_VirtualBox_Extension_Pack-6.1.8.vbox-extpack">tıklayın</a></b>
	<br><br>
	<a type="button" href="install.php?git=first_install" class="btn btn-dark">Devam Et</a>
	</div>
	</div></body>';
	$getir->DeleteCookie("rootpwd");
	$getir->DeleteCookie("netwdrv");
	$getir->DeleteCookie("lang");
	$getir->DeleteCookie("user_id");
	$getir->DeleteCookie("admin_adi");
	$getir->DeleteCookie("pxetype");
	break;

	case 'first_install':
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Kuruluma Başlıyoruz</b>
	<hr></hr>
	<p>PHP PXE Yönetim Paneli Server kurulumu öncesi birkaç kontrol yapmalıyız.</p><br>
	<b>Lütfen bu komutları öncelikli olarak girin / First commands (You must be write this commands on commandline)</b><br>';
	echo "<pre>
	systemctl stop firewalld
	systemctl disable firewalld
	chown -R apache:apache ".dirname(__FILE__)."
	chmod 777 -R ".dirname(__FILE__)."
	setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
	</pre>";
	echo '<table class="table">
	<thead>
	<tr>
	<th scope="col">Fonksiyon</th>
	<th scope="col">Durum</th>
	</tr>
	</thead>
	<tbody>';

	$getir->Extension("pdo_mysql", "PDO MySQL");
	$getir->Extension("shell_exec", "Shell EXEC");
	
	echo '</tbody></table>
	<form action="install.php?git=license" method="post">
	<div class="form-group">
	<select id="lang" name="lang" class="form-control form-select" aria-label="Language / Dil">
	<option selected>Language / Dil</option>
	<option value="TR">Türkçe</option>
	<option value="EN">English</option>
	</select>
	<input type="password" class="form-control mt-5" name="rootpwd" id="rootpwd" placeholder="Root Password"><br>
	<select class="form-control form-select" aria-label="Network Driver" id="netwdrv" name="netwdrv">
	<option selected>Network Driver</option>';
	$netw = shell_exec('ls /sys/class/net');
	$oparray = preg_split("#[\r\n]+#", $netw);
	$array = array();
	foreach($oparray as $line){
	echo '<option value="'.$line.'">'.$line.'</option>';
	}
	echo '</select><br><br>
	<button type="submit" class="btn btn-dark">İleri / Next</button><br>
	</div></form></div></div></body>';
	break;

	case 'license':

	if(file_exists("update.json")) {
	unlink("update.json");
	$txt = "";
	$fp = fopen("update.json","a");
	fwrite($fp,$txt);
	fclose($fp);
	} else {
	$txt = "";
	$fp = fopen("update.json","a");
	fwrite($fp,$txt);
	fclose($fp);
	}
	if(empty($_POST["rootpwd"])) {
	die('<div class="mx-auto card">
	<div class="card-body">
	<b>Doğrulama Yapılamadı</b>
	<hr>
	<code>Root Password Not Found</code><br>
	<div class="form-group">
	<br><br><a href="install.php?git=license" class="btn btn-dark">Yenile / Refresh<br>
	</a></div></div></div>');
	} else {
	setcookie("rootpwd", strip_tags($_POST["rootpwd"]), time()+3600);
	$getir->InstallThree($_POST["rootpwd"]);
	}
	
	if(empty($_POST["netwdrv"])) {
	die('<div class="mx-auto card">
	<div class="card-body">
	<b>Doğrulama Yapılamadı</b>
	<hr>
	<code>Network Driver Not Found</code><br>
	<div class="form-group">
	<br><br><a href="install.php?git=license" class="btn btn-dark">Yenile / Refresh<br>
	</a></div></div></div>');
	} else {
	setcookie("netwdrv", strip_tags($_POST["netwdrv"]), time()+3600);
	}
	
	if(empty($_POST["lang"])) {
	die('<div class="mx-auto card">
	<div class="card-body">
	<b>Doğrulama Yapılamadı</b>
	<hr>
	<code>Language Not Found</code><br>
	<div class="form-group">
	<br><br><a href="install.php?git=license" class="btn btn-dark">Yenile / Refresh<br>
	</a></div></div></div>');
	} else {
	setcookie("lang", strip_tags($_POST["lang"]), time()+3600);
	}
	
	$ds = shell_exec('udevadm info --query=all --name=/dev/sda | grep ID_SERIAL_SHORT');
	$serialx = explode("=", $ds);
	$serial = $serialx[1];
	$systemuid = shell_exec("dmidecode -s system-uuid");
	$data = '{"version_name": "Cygen","version": "11","lang" : "'.strip_tags($_POST["lang"]).'", "netw": "'.strip_tags($_POST["netwdrv"]).'"}';
	$file3 = fopen("update.json", "a");
	fwrite($file3, $data);
	fclose($file3);
	$url = "".$verify."/keycontrol.php?cre=2&uuid=".md5($serial)."";
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

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
	$jsondec = json_decode($result, true);
	$systemuid = shell_exec("cat /etc/machine-id");
	$server_ip = strip_tags($_SERVER['SERVER_ADDR']);
	$server_ip2 = str_replace("::1", "localhost", $server_ip);

	if(intval($jsondec["durum"]) == "1") {
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Sign Code : '.md5($serial).'</b><br><br>
	<b>License Status : '.strip_tags($get).' / Doğrulandı</b><br><br>
	<a href="install.php?git=sql_install" class="btn btn-dark">Devam</a>
	</div></div></body>';
	} elseif($jsondec["durum"] == "2") {
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Doğrulama Yapılamadı</b><br><br>
	<b>Hesabınız sistemden banlanmış </b><br><br>
	<a href="install.php?git=license" class="btn btn-dark">Kontrol Et</a>
	</div></div></body>';
	} else {
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Doğrulama Yapılamadı</b><br><br>
	<b>Cihazınız sisteme kaydedilemedi </b><br><br>
	<button class="btn btn-dark">Seri Keyi Al</button>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
	$("button").click(function(){
	$.post("'.$verify.'/savemanual.php",
	{
	uuid: "'.md5($serial).'",
	ip: "'.strip_tags($server_ip2).'",
	dom: "'.$_SERVER['SERVER_ADDR'].'",
	sysuid: "'.trim($systemuid).'"
	},
	function(data,status){
	alert("Veri: " + data + "\nDurum: " + status);
	});
	});
	});
	</script><br><br>
	<a href="install.php?git=license" class="btn btn-dark">Kontrol Et</a>
	</div></div></body>';
	}
	break;
	
	case 'sql_install':
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>SQL Bilgisi</b>
	<hr></hr>
	<p>Lütfen SQL bilgilerini giriniz.</p>
	
	<form action="install.php?git=sqlpost" method="post">
	
	<div class="form-group">
	<label for="exampleInputEmail1">SQL Server</label>
	<input type="text" class="form-control" name="sqlserver" placeholder="localhost">
	</div>
	
	<div class="form-group">
	<label for="exampleInputEmail1">SQL Username</label>
	<input type="text" class="form-control" name="sqlusr" placeholder="root">
	</div>
	
	<div class="form-group">
	<label for="exampleInputEmail1">SQL Password</label>
	<input type="password" class="form-control" name="sqlpasswd" placeholder="1234">
	</div>
	
	<button type="submit" class="btn btn-dark">İleri / Next</button>
	</form></div></div></body>';
	break;
	
	case 'sqlpost':
	$mysqlserv = strip_tags($_POST["sqlserver"]);
	$mysqlusr = strip_tags($_POST["sqlusr"]);
	$mysqlpass = strip_tags($_POST["sqlpasswd"]);
	$getir->ConnMysqli($mysqlserv, $mysqlusr, $mysqlpass);
	
	$sqlSource = "CREATE TABLE `admin_list` (
	`admin_id` int(11) NOT NULL,
	`admin_email` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	`admin_usrname` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	`admin_passwd` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	`admin_token` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	`admin_yetki` varchar(255) COLLATE utf8_turkish_ci NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

	INSERT INTO `admin_list` (`admin_id`, `admin_email`, `admin_usrname`, `admin_passwd`, `admin_token`, `admin_yetki`) VALUES
	(1, 'xxx@xxx.com', 'alicangonullu', '060323f33140b4a86b53d01d726a45c7584a3a2b', '060323f33140b4a86b53d01d726a45c7584a3a2b', '1');

	CREATE TABLE `boot_menu` (
	`boot_id` int(11) NOT NULL,
	`boot_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
	`boot_labelid` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
	`boot_isoname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
	`boot_speconf` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
	`boot_othercfg` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
	`boot_date` date NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

	INSERT INTO `boot_menu` (`boot_id`, `boot_name`, `boot_labelid`, `boot_isoname`, `boot_speconf`, `boot_othercfg`, `boot_date`) VALUES
	(2, 'FreeDOS', '2', 'fdboot.img', 'append', '', '2020-10-22');

	ALTER TABLE `admin_list`
	ADD PRIMARY KEY (`admin_id`);

	ALTER TABLE `boot_menu`
	ADD PRIMARY KEY (`boot_id`);

	ALTER TABLE `admin_list`
	MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

	ALTER TABLE `boot_menu`
	MODIFY `boot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
	COMMIT;";
	$getir->CreateMysqli($mysqlserv, $mysqlusr, $mysqlpass, $sqlSource);

	$hostname = shell_exec("hostnamectl | grep -v hostname | grep -v Icon | grep -v Kernel | grep -v Chassis | grep -v Machine | grep -v Boot | grep -v Virtualization | grep -v CPE | grep -v Architecture");
	$str1 = str_replace("Operating", "", $hostname);
	$str2 = str_replace(":", "", $str1);
	$str3 = str_replace("System", "", $str2);
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>MySQL Kurulumu</b>
	<hr></hr>
	<code>Sistem Tipi : '.trim($str3).'</code><br>
	<div class="form-group">
	<br><br>
	
	<form action="install.php?git=install" method="post">
	<div class="form-group">
	<select id="pxetype" name="pxetype" class="form-control form-select" aria-label="PXE Type">
	<option selected>PXE Type</option>
	<option value="1">iPXE</option>
	<option value="0">Normal</option>
	</select><br>
	<button class="btn btn-primary" type="submit">Submit</button>
	</form>

	</div></div></div></body>';
	break;


	case 'install':
	setcookie("pxetype", intval($_POST["pxetype"]), time()+3600); 
	if(intval($_COOKIE["pxetype"]) == "0") {
	$getir->InstallOne($_COOKIE["rootpwd"]);
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Önyükleme İşlemi</b>
	<b> Sistem Türü : CentOS </b><br>
	<br>
	<a type="button" href="install.php?git=install2" class="btn btn-dark">DHCP Server Kurulumu</a>
	</div>
	</div></body>';
	} else {
	die('<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Ana Yükleme İşlemi</b>
	<hr></hr>
	<code>iPXE : Soon</code><br>
	<a type="button" href="install.php?git=install3" class="btn btn-dark">Kurulumu Bitir</a>
	</div></div></body>');
	}
	//OK
	break;

	case 'install2':
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>DHCP Server Bilgisi</b>
	<hr></hr>
	<p>Lütfen DHCP Server bilgilerini giriniz.</p>
	<form action="install.php?git=pinstall2" method="post">';
	$netw = shell_exec('ls /sys/class/net');
	$oparray = preg_split("#[\r\n]+#", $netw);
	$array = array();
	echo '<div class="form-group">
	<select class="form-control form-select" aria-label="Network Driver" id="intname" name="intname">
	<option selected>Network Driver</option>';
	foreach($oparray as $line){
	echo '<option value="'.$line.'">'.$line.'</option>';
	}
	echo '</select></div>
	<div class="form-group">
	<label for="exampleInputEmail1">Server IP</label>
	<input type="text" class="form-control" name="serverip" placeholder="192.168.56.101">
	</div>

	<div class="form-group">
	<label for="exampleInputEmail1">Server Range Lowest IP</label>
	<input type="text" class="form-control" name="serverlowrange" placeholder="192.168.56.101">
	</div>

	<div class="form-group">
	<label for="exampleInputEmail1">Server Range Highest IP</label>
	<input type="text" class="form-control" name="serverhighrange" placeholder="192.168.56.254">
	</div>

	<div class="form-group">
	<label for="exampleInputEmail1">Server Gateway</label>
	<input type="text" class="form-control" name="servergateway" placeholder="255.255.255.0">
	</div>
	<button type="submit" class="btn btn-dark">İleri / Next</button>
	</form></div></div></body>';
	break;

	case 'pinstall2':
	$getir->FileControl("backup/dnsmasq.conf");
	$getir->FileControl("backup/tftp");
	$getir->FileControl("backup/pxeboot.conf");
	$getir->FileControl("backup/default");
	
	if(intval($_COOKIE["pxetype"]) == "0") {
	$getir->HttpdFile();
	$getir->TFTPFile($_COOKIE["pxetype"]);
	$getir->DNSMASQCfg($_COOKIE["pxetype"]);
	} else {
	die('<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Ana Yükleme İşlemi</b>
	<hr></hr>
	<code>iPXE : Soon</code><br>
	<a type="button" href="install.php?git=install3" class="btn btn-dark">Kurulumu Bitir</a>
	</div></div></body>');
	}
	$getir->DefaultFile();
	if(intval($_COOKIE["pxetype"]) == "0") {
	$getir->InstallerTwo($_COOKIE["rootpwd"]);

	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Ana Yükleme İşlemi</b>
	<br><br>
	<a type="button" href="install.php?git=install3" class="btn btn-dark">Kurulumu Bitir</a>
	</div></div></body>';
	} else {
	die('<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Ana Yükleme İşlemi</b>
	<hr></hr>
	<code>iPXE : Soon</code><br>
	<a type="button" href="install.php?git=install3" class="btn btn-dark">Kurulumu Bitir</a>
	</div></div></body>');
	}
	break;

	case 'install3':
	$getir->CreateLock("yukle.lock");
	$getir->OtherCommands();
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Yükleme Bildirimi</b>
	<hr></hr>
	<p>Yükleme Tamamlandı. Artık Server hazır durumdadır.</p>
	<a type="button" href="index.php" class="btn btn-dark">Devam Et</a>
	<br>
	</body>';
	$getir->DeleteCookie("rootpwd");
	$getir->DeleteCookie("netwdrv");
	$getir->DeleteCookie("lang");
	$getir->DeleteCookie("user_id");
	$getir->DeleteCookie("admin_adi");
	$getir->DeleteCookie("pxetype");
	break;
}
?>
