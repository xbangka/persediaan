<?php 
include('../config.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "../index.php";</script>';
	exit;
}

if(isset($_POST['aksi']) && $_POST['aksi'] == '2'){

$tahun = $_POST['tahun'] ;
$bulan = $_POST['bulan'] ;

?>
    

<table  class="table table-striped table-bordered table-hover" id="dataTables-example">

    <?php
	
	$filter_time = $tahun . '-' . $bulan ;
	$n = 0 ;
	$sql2 = mysqli_query($jazz,"SELECT * FROM db_persediaan.permintaan WHERE LEFT(tgl,7) = '$filter_time' ORDER BY tgl ASC");
    while($data2 = mysqli_fetch_array($sql2)){
		$n += 1 ;
		if($n % 2 == 0){
			$asir = 'style="background-color:#F4F4F4"' ;
		}else{
			$asir = '' ;
		}
		
		$k = explode('-',substr($data2['tgl'],0,10) ) ; 
		$l = substr($data2['tgl'],11,5) ;
		$tgl = $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . $l ;
		
		$k = explode('-',substr($data2['tgl_butuh'],0,10) ) ; 
		$tgl2 = $k[2] . '-' . $k[1] . '-' . $k[0] ;
		
		if($data2['klasifikasi']=='1'){ $klasifikasi = '(Segera)' ; }else{ $klasifikasi = '(Biasa)' ; } 
		
	?>
    
	<tr <?=$asir?>>
		<td height="50" class="object_label">
            
            <div style="margin:0px 10px 0px 10px">
            <?php 
			if($data2['dilihat']=='0'){ 
				if($data2['approve']=='0'){ 
					echo '<span style="float:right"><a href="javascript:;"><img src="../public/images/delete.png"/></a></span>' ;
				}else{
					echo '<span style="float:right"><a href="get_permintaan.php?kode='.$data2['kodepm'].'"><img src="../public/images/led.gif"/></a></span>' ;
				}
			}else{
				echo '<span style="float:right"><a href="javascript:;"><img src="../public/images/OK.png"/></a></span>' ;
			}
			?>
            
            <span style="float:right;margin-right:100px">Kode : <span style="color:#C40003">
            <a href="rpt_form_permintaan_brg.php?kodepm=<?=$data2['kodepm']?>" target="_blank">
				<?=strtoupper($data2['kodepm'])?>
            </a>
            </span>
            <br />
            Tgl : <?=$tgl?>
            <br />
            Tgl_butuh : <?=$tgl2 . ' ' .$klasifikasi?>
            <br />
            Oleh : <?=$data2['nama']?>
            </span>
            
            <span style="color:#8C0002">
            	<?php
				$q2 = mysqli_query($jazz,"SELECT * FROM rinci_permintaan WHERE idx='$data2[x]' ORDER BY x ASC");
    			while($dat4 = mysqli_fetch_array($q2)){
					if($dat4['sudah']=='1'){
					echo '(<img src="../public/images/OK.png"/>' . ') '.$dat4['kodebrg'].' - '.$dat4['namabrg'].' (' . $dat4['jml'] . ')<br />';
					}else{
					echo '(<img src="../public/images/led.gif"/>' . ') '.$dat4['kodebrg'].' - '.$dat4['namabrg'].' (' . $dat4['jml'] . ')<br />';
					}
				}
				?>
            </span>
            </div>
            
        </td>
	</tr>
    
    <?php
	}
	?>
    
	<tr>
		<td height="30">&nbsp;</td>
	</tr>
</table>
    
    

<?php
}
?>