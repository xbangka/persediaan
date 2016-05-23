<?php 
include('../config.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "../index.php";</script>';
	exit;
}


if(isset($_POST['aksi']) && $_POST['aksi'] == '1'){
	
	$txt_op = $_POST['txt_op'] ;
	
	$sql = mysqli_query($jazz,"SELECT RIGHT(kodebrg,4) FROM barang WHERE LEFT(kodebrg,3) = '$txt_op' ORDER BY kodebrg DESC LIMIT 0,1");
	$x = mysqli_fetch_array($sql);
	if($x[0] ==''){ $x[0] = 0; }
	$x = floattostr($x[0]) + 1 ;
	echo $txt_op . sprintf("%04d", $x);

}

?>