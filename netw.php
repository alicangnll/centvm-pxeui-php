<?php   
$durum = strip_tags($_GET["id"]);
$int = strip_tags($_GET["crd"]);

if(strip_tags($durum) == "1") {
session_start();
$rx[] = @file_get_contents("/sys/class/net/".$int."/statistics/rx_bytes");
$tx[] = @file_get_contents("/sys/class/net/".$int."/statistics/tx_bytes");
sleep(1);
$rx[] = @file_get_contents("/sys/class/net/".$int."/statistics/rx_bytes");
$tx[] = @file_get_contents("/sys/class/net/".$int."/statistics/tx_bytes");
    
$tbps = $tx[1] - $tx[0];
$rbps = $rx[1] - $rx[0];
    
$round_rx=round($rbps/1024, 2);
$round_tx=round($tbps/1024, 2);
    
$time=date("U")."000";
$_SESSION['rx'][] = "[".$time.", ".$round_rx."]";
$_SESSION['tx'][] = "[".$time.", ".$round_tx."]";
$data['label'] = $int;
$data['data'] = $_SESSION['rx'];

if (count($_SESSION['rx'])>60) {
$x = min(array_keys($_SESSION['rx']));
unset($_SESSION['rx'][$x]);
}
    
echo '{"label":"'.$int.'","data":['.implode($_SESSION['rx'], ",").']}';
} elseif(strip_tags($durum) == "2") {
$uptime = shell_exec("uptime -p");
$uptimerep = str_replace("up", "", $uptime);
echo '{"name":"uptime","data": "'.trim($uptimerep).'"}';
} elseif(strip_tags($durum) == "3") { 

$free = shell_exec('free');
$free = (string)trim($free);
	$free_arr = explode("\n", $free);
	$mem = explode(" ", $free_arr[1]);
	$mem = array_filter($mem);
	$mem = array_merge($mem);
	$memory_usage = $mem[2]/$mem[1]*100;
echo '{"name":"freeram","data": "'.trim(intval($memory_usage)).'"}';
} else {
}
?>
