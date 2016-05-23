<?php
session_start();
# -----------------------------
include("db-config.php");



$SE_UserId = $_SESSION['u'] ;

if( isset($_POST['kirim']) && $_POST['kirim'] == "Kirim Permintaan" ){
	
	if( $_POST['text_dept']=='' || $_POST['text_pemohon']=='' || $_POST['text_tgl_butuh']=='' || $SE_UserId==''){
		echo "<script>alert('Maaf proses kirim permintaan gagal'); history.go(-1)</script>";
		exit();
	}else{
		$sql2 = mysqli_query($jazz,"SELECT x FROM temp_rinci_permintaan WHERE user_id = '$SE_UserId' AND kodepm = ''");
    	$ada = mysqli_num_rows($sql2);
		
		if( $ada == 0 ){
			echo "<script>history.go(-1)</script>";
			exit();
		}else{
			
			$k = explode('-',$_POST['text_tgl_minta']);
			$l = date('H:i:s');
			$tgl= $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . $l ;
			
			$k = explode('-',$_POST['text_tgl_butuh']);
			$tgl2= $k[2] . '-' . $k[1] . '-' . $k[0];
			
			$user_id = $_POST['user_id'] ;
			$sql2 = mysqli_query($jazz,"SELECT user_approve FROM tabel_departemen INNER JOIN pemohon ON tabel_departemen.x = pemohon.departemen WHERE pemohon.user_id = '$user_id'");
    		$rs = mysqli_fetch_array($sql2);
			$user_approve = $rs[0] ;
			
			if( $user_approve=='' ){
				echo "<script>alert('Maaf, permintaan setujui oleh siapa ?'); history.go(-1)</script>";
				exit();
			}
			
			# x
			# kodepm
			# tgl
			# departemen
			# nama
			# klasifikasi
			# tgl_butuh
			# user_approve
			# approve
			# dilihat
			# dilihat_user_approve
			mysqli_query($jazz,"INSERT INTO permintaan VALUES (
					'', 
					'', 
					'$tgl', 
					'$_POST[text_dept]', 
					'$user_id', 
					'$_POST[text_pemohon]', 
					'$_POST[rdo_urgen]',
					'$tgl2', 
					'$user_approve', 
					'0', 
					'0',
					'0'
					)"); 
			
			
			
			$sql2 = mysqli_query($jazz,"SELECT x FROM permintaan WHERE user_id = '$user_id' AND tgl = '$tgl'");
    		$rs = mysqli_fetch_array($sql2);
			$idx = $rs[0];
			
			
			mysqli_query($jazz,"INSERT INTO 
				rinci_permintaan (idx, user_id, tgl, kodebrg, namabrg, jml, sudah) 
				SELECT '$idx' AS idx, user_id, tgl, kodebrg, namabrg, jml, '0' AS sudah 
				FROM temp_rinci_permintaan 
				WHERE kodepm = '' AND user_id = '$SE_UserId'");
				
			mysqli_query($jazz,"DELETE FROM temp_rinci_permintaan WHERE kodepm = '' AND user_id = '$SE_UserId'");
			
			echo "<script>alert('Form Permintaan berhasil dikirim'); location = 'frm_ctt_permintaan_brg.php'</script>";
		}
		
	}
}

# ---------------------------------


?>