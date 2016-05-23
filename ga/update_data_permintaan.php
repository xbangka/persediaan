<?php 
session_start();
# -----------------------------
include("db-config.php");

$SE_UserId = '' ;
if(isset($_SESSION['u']))
{
  $SE_UserId = $_SESSION['u'] ;
}

if(isset($_POST['aksi']) && $_POST['aksi'] == '1'){

	$x = $_POST['x'] ;
	$tahun = $_POST['tahun'] ;
	$bulan = $_POST['bulan'] ;
	$kode = uniqid();
	
	mysqli_query($jazz,"UPDATE permintaan SET approve = '1', kodepm = '$kode' WHERE x = '$x'");
	mysqli_query($jazz,"UPDATE rinci_permintaan SET kodepm = '$kode' WHERE idx = '$x'");
	
	
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
            $thnX =  2014 ;
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
	$sql2 = mysqli_query($jazz,"SELECT * FROM permintaan WHERE LEFT(tgl,7)='$filter_time' AND user_approve='$SE_UserId' ORDER BY tgl DESC");
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
            
                <div class="col1">
                    <?php
					$q2 = mysqli_query($jazz,"SELECT * FROM rinci_permintaan WHERE idx='$data2[x]' ORDER BY x ASC");
					while($dat4 = mysqli_fetch_array($q2)){
						echo $dat4['kodebrg'] . ' - ' . $dat4['namabrg'] . ' (' . $dat4['jml'] . ')<br />' ;
					}
					?>
                </div>
                <div class="col3">
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
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '2'){
	
	$kodebrg = $_POST['kodebrg'] ;
	$jml	 = $_POST['jml'] ;
	
	$q1=mysqli_query($jazz,"SELECT x FROM temp_rinci_permintaan WHERE kodebrg='$kodebrg' AND user_id='$SE_UserId'");
	$ada2 = mysqli_num_rows($q1);
	
	if($ada2==0){
	
		$q2=mysqli_query($jazz,"SELECT brg, sisa FROM barang WHERE kodebrg='$kodebrg'");
		$ada = mysqli_num_rows($q2);
		
		$q3=mysqli_query($jazz,"SELECT x FROM temp_rinci_permintaan WHERE kodepm='' AND user_id='$SE_UserId'");
		$jml_list = mysqli_num_rows($q3);
		
		if($ada==1 && $jml_list <= 4){
			$da2 = mysqli_fetch_array($q2) ;
			$nama = $da2['brg'];
			$sisa = $da2['sisa'];
			$tgl = date('Y-m-d H:i:s');
			
			if($sisa >= $jml){
				$query = mysqli_query($jazz,"INSERT INTO temp_rinci_permintaan 
									  VALUES ('', '', '$SE_UserId', '$tgl', '$kodebrg', '$nama', '$jml')"); 
			}
		}
	}
?>
        <table width="100%" border="1">
          <tbody>
            <tr align="center" style="background:#C7CBFC;">
              <td style="font-size:14px">No.</td>
              <td style="font-size:14px">Kodebrg</td>
              <td style="font-size:14px">Nama Barang</td>
              <td style="font-size:14px">Jml</td>
              <td style="width:20px">&nbsp;</td>
            </tr>
            <?php
            $n = 0 ;
            $q2=mysqli_query($jazz,"SELECT * FROM temp_rinci_permintaan WHERE kodepm='' AND user_id='$SE_UserId' ORDER BY x ASC LIMIT 0,5");
            while($da2 = mysqli_fetch_array($q2)){
                $n += 1 ;
                if($n%2==0){ $clr3 = 'background:#E7E7E7'; }else{ $clr3 = '' ; }
            ?>
            <tr style="font-size:14px;text-align:center;<?php echo $clr3 ; ?>">
              <td><?php echo $n ; ?></td>
              <td><?php echo $da2['kodebrg'] ; ?></td>
              <td style="text-align:left">&nbsp;<?php echo $da2['namabrg'] ; ?></td>
              <td><?php echo $da2['jml'] ; ?></td>
              <td><a href="javascript:;" onclick="hapus(<?php echo $da2['x'] .',\'' . $da2['namabrg'] .'\'' ; ?>)"><img src="../public/images/delete.png" /></a></td>
            </tr>
            <?php
            }
            
			echo '<input type="hidden" id="jml_rec" value="'.$n.'" />' ;
			
            $n = $n + 1 ;
            for( $i= $n ; $i <= 5 ; $i++ ){
                if($i%2==0){ $clr3 = 'background:#E7E7E7'; }else{ $clr3 = '' ; }
            ?>
            <tr style="font-size:14px;text-align:center;<?php echo $clr3 ; ?>">
              <td><?php echo $i ; ?></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
<?php
}elseif(isset($_POST['aksi']) && $_POST['aksi'] == '3'){
	$idx = $_POST['idx'] ;
	mysqli_query($jazz,"DELETE FROM temp_rinci_permintaan WHERE x='$idx' AND user_id='$SE_UserId'");
?>
    <table width="100%" border="1">
      <tbody>
        <tr align="center" style="background:#C7CBFC;">
          <td style="font-size:14px">No.</td>
          <td style="font-size:14px">Kodebrg</td>
          <td style="font-size:14px">Nama Barang</td>
          <td style="font-size:14px">Jml</td>
          <td style="width:20px">&nbsp;</td>
        </tr>
        <?php
        $n = 0 ;
        $q2=mysqli_query($jazz,"SELECT * FROM temp_rinci_permintaan WHERE kodepm='' AND user_id='$SE_UserId' ORDER BY x ASC LIMIT 0,5");
        while($da2 = mysqli_fetch_array($q2)){
            $n += 1 ;
            if($n%2==0){ $clr3 = 'background:#E7E7E7'; }else{ $clr3 = '' ; }
        ?>
        <tr style="font-size:14px;text-align:center;<?php echo $clr3 ; ?>">
          <td><?php echo $n ; ?></td>
          <td><?php echo $da2['kodebrg'] ; ?></td>
          <td style="text-align:left">&nbsp;<?php echo $da2['namabrg'] ; ?></td>
          <td><?php echo $da2['jml'] ; ?></td>
          <td><a href="javascript:;" onclick="hapus(<?php echo $da2['x'] .',\'' . $da2['namabrg'] .'\'' ; ?>)"><img src="../public/images/delete.png" /></a></td>
        </tr>
        <?php
        }
        
		echo '<input type="hidden" id="jml_rec" value="'.$n.'" />' ;
		
        $n = $n + 1 ;
        for( $i= $n ; $i <= 5 ; $i++ ){
            if($i%2==0){ $clr3 = 'background:#E7E7E7'; }else{ $clr3 = '' ; }
        ?>
        <tr style="font-size:14px;text-align:center;<?php echo $clr3 ; ?>">
          <td><?php echo $i ; ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
<?php
}
?>