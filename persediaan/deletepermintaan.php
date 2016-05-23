<?php 
	include('config.php'); 
	
	if(!isset($_SESSION['id'])){
		echo '<script>window.location= "index.php";</script>';
		exit;
	}

	if( isset($_POST['nopermintaan']) && $_POST['pass']!='' ){
		$x=$_POST['nopermintaan'];
		$p = md100($_POST['pass']);
		$sql = mysqli_query($jazz,"SELECT p FROM user WHERE x = '$_SESSION[id]'");
		$data = mysqli_fetch_array($sql);
		
		if($p==$data['p']){
			
			mysqli_query($jazz,"DELETE FROM permintaan WHERE x='$x'");
			mysqli_query($jazz,"DELETE FROM rinci_permintaan WHERE idx='$x'");
			
			
			////////////////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'DELETE permintaan x:' . $x ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			////////////////////////////
		}
		
	}
	header('location: '.$_SERVER['HTTP_REFERER']);
?>