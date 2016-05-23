<?php 
include('../config.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "../index.php";</script>';
	exit;
}







if(isset($_POST['aksi']) && $_POST['aksi'] == '1'){

	$pass1 = md100($_POST['pass1']) ;
	$pass2 = $_POST['pass2'] ;
	$pass3 = $_POST['pass3'] ;
	
	$sql = mysqli_query($jazz,"SELECT p FROM user WHERE x = '$_SESSION[id]'");
	$data = mysqli_fetch_array($sql);
	
	if( $pass1==$data['p'] && $pass2==$pass3 ){
		
		$p = md100($pass2) ;
		mysqli_query($jazz,"UPDATE user SET p = '$p' WHERE x = '$_SESSION[id]'");
		
		//////////////////
		$tgl = date('Y-m-d H:i:s') ;
		$aksi = 'UPDATE Password x:' . $_SESSION['id'] . ' pass:' . $pass3 ;
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
		mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
		//////////////////
		
		echo 'SUCCESS' ;
		
	}else{
		
		
		//////////////////
		$tgl = date('Y-m-d H:i:s') ;
		$aksi = 'GAGAL UPDATE Password x:' . $_SESSION['id'] ;
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
		mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
		//////////////////
		
		echo 'GAGAL' ;	
	}
	
	
	
	
	
	
	
	
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '2'){
	
	$kode = strtoupper($_POST['kodebrg']);
	$sql2 = mysqli_query($jazz,"SELECT brg, satuan, sisa FROM barang WHERE kodebrg = '$kode'");
	$ada  = mysqli_num_rows($sql2);
	if($ada>=1){
		$data2 = mysqli_fetch_array($sql2);
		echo $data2[0] . '|' . $data2[1] . '|' . $data2[2];
	}else{
		echo 'NONE';
	}
    
	
	
	
	
	
	
	
	
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '3'){
	
	$kode = strtoupper($_POST['kodebrg']);
	$stokbrg = $_POST['stokbrg'];
	$pass = md100($_POST['pass']);
	
	$sql = mysqli_query($jazz,"SELECT p FROM user WHERE x = '$_SESSION[id]'");
	$data = mysqli_fetch_array($sql);
	
	$sql2 = mysqli_query($jazz,"SELECT x FROM barang WHERE kodebrg = '$kode'");
	$ada = mysqli_num_rows($sql2);
	
	if( $pass==$data['p'] && $ada==1 ){
		
		
		//////////
		$sql5 = mysqli_query($jazz,"SELECT sisa FROM barang WHERE kodebrg = '$kode'");
		$data5 = mysqli_fetch_array($sql5);
		///////////
		
		mysqli_query($jazz,"UPDATE barang SET sisa = '$stokbrg' WHERE kodebrg = '$kode'");
		
		//////////////////
		$tgl = date('Y-m-d H:i:s') ;
		$aksi = 'UPDATE stok barang ' . $kode . ' dari ' .$data5['sisa']. ' menjadi ' . $stokbrg ;
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
		mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
		//////////////////
		
		echo 'SUCCESS' ;
		
	}else{
		
		/////////////////
		$tgl = date('Y-m-d H:i:s') ;
		$aksi = 'GAGAL UPDATE stok barang ' . $kode ;
		$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
		mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
		//////////////////
		
		echo 'GAGAL' ;	
	}
    
}

?>