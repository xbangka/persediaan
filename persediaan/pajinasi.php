<?php 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

class Paging{
	
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){

		if(empty($_REQUEST['page']) || !is_numeric($_REQUEST['page'])){
			$posisi=0;
			$_REQUEST['page']=1;
		}else{
			$posisi = abs(($_REQUEST['page']-1)) * $batas;
		}

		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 ... Next, Prev, First, Last
	function navHalaman($halaman_aktif, $jmlhalaman, $tujuan, $strfdr){
		$link_halaman = "";

		// Link First dan Previous
	/*	if ($halaman_aktif > 1){
			$link_halaman .= '<li><a href="?l=gallery&folder='.$strfdr.'">&laquo;</a></li>';
		}*/

		if (($halaman_aktif-1) > 0){
			$previous = $halaman_aktif-1;
			$link_halaman .= '<li><a href="'.$tujuan.$strfdr.'&page='.$previous.'">&laquo;</a></li>';
		}

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= '<li class="active"><a href="#">'.$i.'</a></li>';
			}else{
				$link_halaman .= '<li><a href="'.$tujuan.$strfdr.'&page='.$i.'">'.$i.'</a></li>';
			}
			$link_halaman .= "";
		}

		// Link Next dan Last
		if ($halaman_aktif < $jmlhalaman){
			$next=$halaman_aktif+1;
			$link_halaman .= '<li><a href="'.$tujuan.$strfdr.'&page='.$next.'">&raquo;</a></li>';
		}

		/*if (($halaman_aktif != $jmlhalaman) && ($jmlhalaman != 0)){
			$link_halaman .= '<li><a href="?l=gallery&folder='.$strfdr.'&page='.$jmlhalaman.'">&raquo;</a></li>';
		}*/
		
		return $link_halaman;
	}
}
?>