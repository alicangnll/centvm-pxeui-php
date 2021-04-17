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
	</div></body>
	<script>
	document.cookie = "rootpwd= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "netwdrv= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "pxetype= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	</script>';
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
	
	$sql = mysqli_connect($mysqlserv, $mysqlusr, $mysqlpass, "pxe_boot");
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
	mysqli_multi_query($sql,$sqlSource);

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
	$hostname = shell_exec("hostnamectl | grep -v hostname | grep -v Icon | grep -v Kernel | grep -v Chassis | grep -v Machine | grep -v Boot | grep -v Virtualization | grep -v CPE | grep -v Architecture");
	$str1 = str_replace("Operating", "", $hostname);
	$str2 = str_replace(":", "", $str1);
	$str3 = str_replace("System", "", $str2);
	
	//SYSLİNUX : OK
	$firewall1 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --add-service=http --zone=public --permanent";
	$firewall2 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --add-service=tftp --zone=public --permanent";
	$firewall3 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --add-service=dhcp --zone=public --permanent";
	$firewall4 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --add-service=dns --zone=public --permanent";
	$firewall5 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --add-service=ftp --zone=public --permanent";
	$firewall6 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --zone=public --permanent --add-port=69/udp";
	$firewall7 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --zone=public --permanent --add-port=4011/udp";
	$firewall8 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k firewall-cmd --reload";
	
	setcookie("pxetype", intval($_POST["pxetype"]), time()+3600); 
	
	if(intval($_COOKIE["pxetype"]) == "0") {
	$installer = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k yum install -y epel-release tftp tftp-server xinetd syslinux net-tools dnsmasq zip nfs-utils tar wget policycoreutils-python-utils libguestfs-tools bind-utils";
	$mk_syslinuxfolder = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k mkdir /var/lib/tftpboot/pxelinux.cfg";
	$copy_syslinux = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp -v /usr/share/syslinux/* /var/lib/tftpboot";
	shell_exec($installer);
	shell_exec($mk_syslinuxfolder);
	shell_exec($copy_syslinux);
	shell_exec($firewall1);
	shell_exec($firewall2);
	shell_exec($firewall3);
	shell_exec($firewall4);
	shell_exec($firewall5);
	shell_exec($firewall6);
	shell_exec($firewall7);
	shell_exec($firewall8);
	
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Önyükleme İşlemi</b>
	<b> Sistem Türü : CentOS </b><br>
	<hr></hr>
	<code>
	//For CentOS 7 Special <br>
	yum provides semanage<br>
	yum -y install policycoreutils-python-2.5-34.el7.x86_64<br>
	//Finished for CentOS7 Special<br>
	'.$installer.'<br>
	'.$mk_syslinuxfolder.'<br>
	'.$copy_syslinux.'<br>
	'.$firewall1.'<br>
	'.$firewall2.'<br>
	'.$firewall3.'<br>
	'.$firewall4.'<br>
	'.$firewall5.'<br>
	'.$firewall6.'<br>
	'.$firewall7.'<br>
	'.$firewall8.'<br>
	</code><br>
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
	echo '<div class="form-group">
	<select class="form-control form-select" aria-label="Network Driver" id="intname" name="intname">
	<option selected>Network Driver</option>';
	$array = array();
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
	if (file_exists("backup/dnsmasq.conf")) {
	unlink("backup/dnsmasq.conf");
	touch("backup/dnsmasq.conf");
	} else {
	touch("backup/dnsmasq.conf");
	}
	if (file_exists("backup/tftp")) {
	unlink("backup/tftp");
	touch("backup/tftp");
	} else {
	touch("backup/tftp");
	}
	if (file_exists("backup/pxeboot.conf")) {
	unlink("backup/pxeboot.conf");
	touch("backup/pxeboot.conf");
	} else {
	touch("backup/pxeboot.conf");
	}
	if (file_exists("backup/default")) {
	unlink("backup/default");
	touch("backup/default");
	} else {
	touch("backup/default");
	}
	if(intval($_COOKIE["pxetype"]) == "0") {
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

	if(intval($_COOKIE["pxetype"]) == "0") {
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

	if(intval($_COOKIE["pxetype"]) == "0") {
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

if(intval($_COOKIE["pxetype"]) == "0") {
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
$cp_default = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/default /var/lib/tftpboot/pxelinux.cfg/";
$default_chmod = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chmod -R 777 /var/lib/tftpboot/pxelinux.cfg";
$mkdir = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k mkdir /var/lib/tftpboot/data";
$mkdir2 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k mkdir /var/lib/tftpboot/data/iso";
$touch_nfserver = 'echo "/var/lib/tftpboot/data	*(rw)" >> /etc/exports';
//NFS SERVER : OK
$httpd_chmod = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chmod -R 777 /var/lib/tftpboot/data";
$httpd_chown = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chown -R nobody:nobody /var/lib/tftpboot/data";
$httpd_selinux1 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$httpd_selinux2 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data";
$tftp_syslinux2 = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k	/sbin/restorecon -R -v /var/lib/tftpboot";
//HTTPD : OK
// Perm Problem Solve :
// systemctl stop firewalld
// setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux
// chmod -R 777 /var/lib/tftpboot/data
// chown -R nobody:nobody /var/lib/tftpboot/data
// chcon -R -t httpd_sys_rw_content_t /var/lib/tftpboot/data
// semanage fcontext -a -t httpd_sys_rw_content_t /var/lib/tftpboot/data
// /sbin/restorecon -R -v /var/lib/tftpboot
$firewall_stop = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl stop firewalld";
$firewall_disable = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl disable firewalld";

$syslinux_conf = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k setenforce 0 && sed -i 's/SELINUX=enforcing/SELINUX=permissive/g' /etc/sysconfig/selinux";
//SYSLİNUX : OK

$httpd_cp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/pxeboot.conf /etc/httpd/conf.d/";
$tftp_cp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/tftp /etc/xinetd.d/";
$dnsmasq_chmod = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k chmod 777 /etc/dnsmasq.conf";
$dnsmasq_cp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k cp ".dirname(__FILE__)."/backup/dnsmasq.conf /etc/";

$xinetd = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl start xinetd";
$xinetd_enab = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl enable xinetd";
$dnsmasq = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl restart dnsmasq";
$dnsmasq_enab = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl enable dnsmasq";
$tftp = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl restart tftp";
$tftp_enab = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl enable tftp";
$nfsserver = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl start nfs-server";
$httpserver = "echo '".strip_tags($_COOKIE["rootpwd"])."' | sudo -S -k systemctl restart httpd";
//<b> Windows Server NFS Server Connect : https://www.rootusers.com/how-to-mount-an-nfs-share-in-windows-server-2016/</b>
//<b> Windows NFS Server Connect : https://graspingtech.com/mount-nfs-share-windows-10/</b>
// <b> TFTP Server Connect FreeDOS : </b>
	shell_exec($cp_default);
	shell_exec($default_chmod);
	shell_exec($httpd_cp);
	shell_exec($tftp_cp);
	shell_exec($dnsmasq_chmod);
	shell_exec($dnsmasq_cp);

	$file4 = fopen("backup/default", "a");
	fwrite($file4, $default);
	fclose($file4);
	$fp = fopen("/var/lib/tftpboot/pxelinux.cfg/default","wb");
	fwrite($fp,$default);
	fclose($fp);

	shell_exec($touch_nfserver);
	shell_exec($mkdir);
	shell_exec($mkdir2);
	shell_exec($firewall_stop);
	shell_exec($firewall_disable);
	shell_exec($syslinux_conf);

	shell_exec($httpd_chmod);
	shell_exec($httpd_chown);
	shell_exec($httpd_selinux1);
	shell_exec($httpd_selinux2);

	shell_exec($xinetd);
	shell_exec($xinetd_enab);
	shell_exec($dnsmasq);
	shell_exec($dnsmasq_enab);
	shell_exec($tftp);
	shell_exec($tftp_enab);
	shell_exec($nfsserver);
	shell_exec($httpserver);
	echo '<body class="container">
	<br><br><br>
	<div class="mx-auto card">
	<div class="card-body">
	<b>Ana Yükleme İşlemi</b>
	<hr></hr>
	<code>
	'.$cp_default.'<br>
	'.$default_chmod.'<br>
	'.$httpd_cp.'<br>
	'.$tftp_cp.'<br>
	'.$dnsmasq_chmod.'<br>
	'.$dnsmasq_cp.'<br>
	'.$touch_nfserver.'<br>
	'.$mkdir.'<br>
	'.$mkdir2.'<br>
	'.$firewall_stop.'<br>
	'.$firewall_disable.'<br>
	'.$syslinux_conf.'<br>
	'.$httpd_chmod.'<br>
	'.$httpd_chown.'<br>
	'.$httpd_selinux1.'<br>
	'.$httpd_selinux2.'<br>
	'.$tftp_syslinux2.'<br>
	'.$xinetd.'<br>
	'.$xinetd_enab.'<br>
	'.$dnsmasq.'<br>
	'.$dnsmasq_enab.'<br>
	'.$tftp.'<br>
	'.$tftp_enab.'<br>
	'.$nfsserver.'<br>
	'.$httpserver.'<br>
	</code><br>
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
	if(file_exists("yukle.lock")) {
	unlink("yukle.lock");
	} else {
	}
	$txt = md5(rand(5,15));
	$fp = fopen("yukle.lock","a");
	fwrite($fp,$txt);
	fclose($fp);
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
	</body>
	<script>
	document.cookie = "rootpwd= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "netwdrv= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "user_id= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "admin_adi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	document.cookie = "pxetype= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	</script>';
break;
}
?>
