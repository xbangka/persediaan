<?php 
session_start();
# -----------------------------
include("db-config.php");


if(isset($_POST['aksi']) && $_POST['aksi'] == '2'){

$tahun = $_POST['tahun'] ;
$bulan = $_POST['bulan'] ;


$SE_UserId = $_SESSION['u'] ;

?>
    

<table border="0" cellpadding="0" cellspacing="0" width="798px" style="margin: 0 auto;" align="center" id="form_posting">
	<tr>
		<td width="798" height="30">&nbsp;</td>
	</tr>
	<tr>
		<form method="post" id="myform" name="myform" action="">
        <td class="object_header" height="30px" align="left">
        &nbsp;&nbsp;Catatan Permintaan Alat/Barang &nbsp;
        <span style="float:right"> 
        
        
        
        <select name="filter_bulan" id="filter_bulan" class="object_select" style="width:180px;" onChange="ganti();">
				<option value="01" <?php if($bulan=='01') echo 'selected' ; ?> >&nbsp; Januari &nbsp;</option>
                <option value="02" <?php if($bulan=='02') echo 'selected' ; ?> >&nbsp; Pebruari &nbsp;</option>
                <option value="03" <?php if($bulan=='03') echo 'selected' ; ?> >&nbsp; Maret &nbsp;</option>
                <option value="04" <?php if($bulan=='04') echo 'selected' ; ?> >&nbsp; April &nbsp;</option>
                <option value="05" <?php if($bulan=='05') echo 'selected' ; ?> >&nbsp; Mei &nbsp;</option>
                <option value="06" <?php if($bulan=='06') echo 'selected' ; ?> >&nbsp; Juni &nbsp;</option>
                <option value="07" <?php if($bulan=='07') echo 'selected' ; ?> >&nbsp; Juli &nbsp;</option>
                <option value="08" <?php if($bulan=='08') echo 'selected' ; ?> >&nbsp; Agustus &nbsp;</option>
                <option value="09" <?php if($bulan=='09') echo 'selected' ; ?> >&nbsp; September &nbsp;</option>
                <option value="10" <?php if($bulan=='10') echo 'selected' ; ?> >&nbsp; Oktober &nbsp;</option>
                <option value="11" <?php if($bulan=='11') echo 'selected' ; ?> >&nbsp; Nopember &nbsp;</option>
                <option value="12" <?php if($bulan=='12') echo 'selected' ; ?> >&nbsp; Desember &nbsp;</option>
		</select>
        <select name="filter_tahun" id="filter_tahun" class="object_select" style="width:100px;" onChange="ganti();">
				
                <?php 
				$tahunx = date('Y') ;
				$thnX =  2016 ;
				$xx = $tahunx - $thnX ;
				
				for ($x = 0; $x <= $xx; $x++) {
					if($tahun==$tahunx) { $select_t = 'selected' ; }else{ $select_t = ''; }
					echo '<option value="'.$tahunx.'" '.$select_t.'>&nbsp; '.$tahunx.' &nbsp;</option>' ;
					$tahunx -= 1 ;
				}
				?>
                
		</select>
        
        
        
        
        </span>
        </td>
        </form>
	</tr>
    
    <?php
	
	$filter_time = $tahun . '-' . $bulan ;
	$n = 0 ;
	$sql2 = mysqli_query($jazz,"SELECT * FROM permintaan WHERE LEFT(tgl,7) = '$filter_time' AND user_id = '$SE_UserId' ORDER BY tgl ASC");
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
            
            
            <?php if($data2['approve']=='0'){ 
			echo '<span style="float:right"><br /><a href="javascript:;" data-toggle="modal" data-target="#myModal" onClick="kode_x(\''.$data2['x'].'\',\''.$tgl.'\')"><img src="../public/images/delete.png"/></a></span>' ;
			}else{
				echo '<span style="float:right"><br /><a href="javascript:;"><img src="../public/images/OK.png"/></a></span>' ;
			}
			?>
            
            <span style="float:right;margin-right:100px"><br />Kode : <span style="color:#C40003">
            <a href="../ga/rpt_form_permintaan_brg.php?kodepm=<?=$data2['kodepm']?>" target="_blank">
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
            <br/>
            <span style="color:#8C0002">
            	<?php
				$q2 = mysqli_query($jazz,"SELECT * FROM rinci_permintaan WHERE user_id='$SE_UserId' AND idx='$data2[x]' ORDER BY x ASC");
    			while($dat4 = mysqli_fetch_array($q2)){
					echo $dat4['kodebrg'] . ' - ' . $dat4['namabrg'] . ' (' . $dat4['jml'] . ')<br />' ;
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
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '6'){

$tahun = $_POST['tahun'] ;
$bulan = $_POST['bulan'] ;

?>
    

<table border="0" cellpadding="0" cellspacing="0" width="798px" style="margin: 0 auto;" align="center" id="form_posting">
	<tr>
		<td width="798" height="30">&nbsp;</td>
	</tr>
	<tr>

        <td class="object_header" height="30px" align="left">
        &nbsp;&nbsp;Konfirmasi &nbsp;
        <span style="float:right"> 
        
        <select name="filter_bulan" id="filter_bulan" class="object_select" style="width:180px;" onChange="ganti();">
            <option value="01" <?php if($bulan=='01') echo 'selected' ; ?> >&nbsp; Januari &nbsp;</option>
            <option value="02" <?php if($bulan=='02') echo 'selected' ; ?> >&nbsp; Pebruari &nbsp;</option>
            <option value="03" <?php if($bulan=='03') echo 'selected' ; ?> >&nbsp; Maret &nbsp;</option>
            <option value="04" <?php if($bulan=='04') echo 'selected' ; ?> >&nbsp; April &nbsp;</option>
            <option value="05" <?php if($bulan=='05') echo 'selected' ; ?> >&nbsp; Mei &nbsp;</option>
            <option value="06" <?php if($bulan=='06') echo 'selected' ; ?> >&nbsp; Juni &nbsp;</option>
            <option value="07" <?php if($bulan=='07') echo 'selected' ; ?> >&nbsp; Juli &nbsp;</option>
            <option value="08" <?php if($bulan=='08') echo 'selected' ; ?> >&nbsp; Agustus &nbsp;</option>
            <option value="09" <?php if($bulan=='09') echo 'selected' ; ?> >&nbsp; September &nbsp;</option>
            <option value="10" <?php if($bulan=='10') echo 'selected' ; ?> >&nbsp; Oktober &nbsp;</option>
            <option value="11" <?php if($bulan=='11') echo 'selected' ; ?> >&nbsp; Nopember &nbsp;</option>
            <option value="12" <?php if($bulan=='12') echo 'selected' ; ?> >&nbsp; Desember &nbsp;</option>
		</select>
        <select name="filter_tahun" id="filter_tahun" class="object_select" style="width:100px;" onChange="ganti();">
				
			<?php 
            $tahunx = date('Y') ;
            $thnX =  2016 ;
            $xx = $tahunx - $thnX ;
            
            for ($x = 0; $x <= $xx; $x++) {
                if($tahun==$tahunx) { $select_t = 'selected' ; }else{ $select_t = ''; }
                echo '<option value="'.$tahunx.'" '.$select_t.'>&nbsp; '.$tahunx.' &nbsp;</option>' ;
                $tahunx -= 1 ;
            }
            ?>
                
		</select>
        
        
        
        
        </span>
        </td>

	</tr>
    
    <?php
	
	$filter_time = $tahun . '-' . $bulan ;
	$n = 0 ;
	$sql2 = mysqli_query($jazz,"SELECT * FROM permintaan WHERE LEFT(tgl,7) = '$filter_time' AND user_approve = '$_SESSION[u]' ORDER BY tgl ASC");
    while($data2 = mysqli_fetch_array($sql2)){
		$n += 1 ;
		if($n % 2 == 0){
			$asir = 'style="background-color:#D4D4D4"' ;
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
            
                <div class="col1"><br />
                    <?php
                    $q2 = mysqli_query($jazz,"SELECT * FROM rinci_permintaan WHERE idx='$data2[x]' ORDER BY x ASC");
                    while($dat4 = mysqli_fetch_array($q2)){
                        echo $dat4['kodebrg'] . ' - ' . $dat4['namabrg'] . ' (' . $dat4['jml'] . ')<br />' ;
                    }
                    ?>
                </div>
                <div class="col3"><br />
                    <?php  if($data2['approve']=='0'){ ?>
                    <button type="button" class="btn btn-primary" onClick="menyetujui(<?=$data2['x']?>);">Menyetujui</button> 
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal" onClick="kode_x(<?=$data2['x'] . ', \'' .$data2['nama'] .'\''?>)">X</button> &nbsp; 
                    <?php }else{ ?>
                    <img src="../public/images/check.png"/>
                    <?php } ?>
                </div>
                <div class="col2">
                    <br />Kode : <span style="color:#C40003">
                    <a href="../ga/rpt_form_permintaan_brg.php?kodepm=<?=$data2['kodepm']?>" target="_blank">
                        <?=strtoupper($data2['kodepm'])?>
                    </a>
                    </span>
                    <br />
                    Tgl : <?=$tgl?>
                    <br />
                    Tgl_butuh : <?=$tgl2 . ' ' .$klasifikasi?>
                    <br />
                    Oleh : <?=$data2['nama']?>
                </div>

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

}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '1'){
	
	$brg = $_POST['brg'] ;
	
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align:center">Kode Barang</th>
            <th style="text-align:center">Nama Barang</th>
            <th style="text-align:center">Satuan</th>
            <th style="text-align:center">Stok</th>
            <th style="text-align:center">Status</th>
        </tr>
    </thead>
    <tbody>
    <?php 
	if($brg == 'semua_data'){
    	$sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE statusx = '1' ORDER BY brg ASC");
	}else{
		$sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE statusx = '1' AND brg like '%" . $brg . "%' ORDER BY brg ASC LIMIT 0,10");
	}
    while($data2 = mysqli_fetch_array($sql2)){
    ?>
        <tr>
            <td align="center">
            <a href="javascript:;" data-dismiss="modal"
                onclick="getdatabrg('<?php echo $data2[1] . '\',\'' . $data2[2] . '\',\'' . $data2[8] . '\',\'' . $data2[3] ;?>')" >
                <?php echo $data2[1] ;?>
            </a>
            </td>
            <td>
            <a href="javascript:;" data-dismiss="modal"
                onclick="getdatabrg('<?php echo $data2[1] . '\',\'' . $data2[2] . '\',\'' . $data2[8] . '\',\'' . $data2[3] ;?>')">
                <?php echo $data2[2] ;?>
            </a>
            </td>
            <td><?php echo $data2[3] ;?></td>
            <td align="right"><?php echo number_format($data2[8], 0, '', '.') ;?></td>
            <td><?php if($data2[5]=='1') { echo 'Tersedia'; }else{ echo 'Tidak Tersedia'; } ;?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<?php
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '3'){
	
	$kode = $_POST['kodebrg'] ;
	$sql2 = mysqli_query($jazz,"SELECT brg, satuan, sisa FROM barang WHERE statusx = '1' AND kodebrg = '$kode'");
	$ada  = mysqli_num_rows($sql2);
	if($ada>=1){
		$data2 = mysqli_fetch_array($sql2);
		echo $data2[0] . '|' . $data2[1] . '|' . $data2[2];
	}else{
		echo 'NONE';
	}
    
}

?>