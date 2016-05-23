<?php 
session_start();
# -----------------------------
include("db-config.php");

$SE_UserId = $_SESSION['u'] ;

if($SE_UserId!=''){
	$x = $_POST['kode_x'] ;
	
	$sql = mysqli_query($jazz,"SELECT x FROM permintaan WHERE x = '$x' AND approve = '0'");
	$ada = mysqli_num_rows($sql);
	if($ada>=1){
		
		mysqli_query($jazz,"DELETE FROM permintaan WHERE x = '$x'");
		
		mysqli_query($jazz,"DELETE FROM rinci_permintaan WHERE idx = '$x'");

	}
	
}

echo "<script>history.go(-1)</script>";
?>
