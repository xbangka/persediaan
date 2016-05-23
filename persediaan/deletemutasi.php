<?php 
	include('config.php'); 
	
	if(!isset($_SESSION['id'])){
		echo '<script>window.location= "index.php";</script>';
		exit;
	}

	if( isset($_POST['nomutasi']) && $_POST['pass']!='' ){
		$x=$_POST['nomutasi'];
		$p = md100($_POST['pass']);
		$sql = mysqli_query($jazz,"SELECT p FROM user WHERE x = '$_SESSION[id]'");
		$data = mysqli_fetch_array($sql);
		
		if($p==$data['p']){

			$sql3 = mysqli_query($jazz,"SELECT mutasi, jml, kodebrg, idx_rinci FROM mutasi WHERE nomutasi = '$x'");
			$data3 = mysqli_fetch_array($sql3);
				   
			if($data3['mutasi'] == '1'){
				
				$sql4 = mysqli_query($jazz,"SELECT sisa, masuk FROM barang WHERE kodebrg = '$data3[kodebrg]'");
				$data4 = mysqli_fetch_array($sql4);
				$sisa = $data4[0] - $data3['jml'];
				$masuk = $data4[1] - $data3['jml'];
				
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', masuk = '$masuk' WHERE kodebrg = '$data3[kodebrg]'");
				
			}else{
				
				$sql4 = mysqli_query($jazz,"SELECT sisa, keluar FROM barang WHERE kodebrg = '$data3[kodebrg]'");
				$data4 = mysqli_fetch_array($sql4);
				$sisa = $data4[0] + $data3['jml'];
				$keluar = $data4[1] + $data3['jml'];
				
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', keluar = '$keluar' WHERE kodebrg = '$data3[kodebrg]'");
				
				if( is_numeric($data3['idx_rinci'])  && !empty($data3['idx_rinci']) ){
					mysqli_query($jazz,"UPDATE rinci_permintaan SET sudah = '0' WHERE x = '$data3[idx_rinci]'");
					$sql4 = mysqli_query($jazz,"SELECT idx FROM rinci_permintaan WHERE x = '$data3[idx_rinci]' AND sudah = '0'");
					$data7 = mysqli_fetch_array($sql4);
					mysqli_query($jazz,"UPDATE permintaan SET dilihat = '0' WHERE x = '$data7[idx]'");
				}
				
			}
			
			mysqli_query($jazz,"DELETE FROM mutasi WHERE nomutasi='$x'");
			////////////////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'Delete Data Mutasi No. ' . $x ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			////////////////////////////
		}
		
	}
	header('location: '.$_SERVER['HTTP_REFERER']);
?>