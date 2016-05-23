<?php
session_start();
set_time_limit(500);
# -----------------------------
include("db-config.php");


$pesan='';
$ip_address = $_SERVER['REMOTE_ADDR'] ;
if(isset($_POST['kirim'])){
	$u = addslashes($_POST['text_user']);
	$p = base64_encode($_POST['text_password']);
	
	if($ip_address=='127.0.0.1' || $ip_address=='::1'){
		$sql = mysqli_query($jazz,"SELECT * FROM sys_login INNER JOIN pemohon ON pemohon.user_id = sys_login.user_id WHERE pemohon.departemen <> '' AND sys_login.user_password = '$p' AND sys_login.user_name = '$u'");
	}else{
		$sql = mysqli_query($jazz,"SELECT * FROM sys_login INNER JOIN pemohon ON pemohon.user_id = sys_login.user_id WHERE pemohon.departemen <> '' AND sys_login.user_ip = '$ip_address' AND sys_login.user_password = '$p' AND sys_login.user_name = '$u'");
	}
	
	$ada = mysqli_num_rows($sql);
	if($ada>=1){
		
		$rs = mysqli_fetch_array($sql);
		$_SESSION['u'] = $rs['user_id'] ;

	}else{
		$pesan='<script>alert("Maaf, Anda salah input");</script>';
	}
	
}

echo $pesan;
echo '<script>window.history.back();</script>';

?>