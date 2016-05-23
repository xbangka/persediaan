<?php
session_start();
# -----------------------------
include("db-config.php");

$SE_UserId = '' ;
if(isset($_SESSION['u']))
{
	$SE_UserId = $_SESSION['u'] ;
}

$thn_now = date('Y') ;
$bln_now = date('m') ;

if(empty($_GET['bulan'])) {
	$bulan = $bln_now ;
}

if(empty($_GET['tahun'])) {
	$tahun = $thn_now ;
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" type="image/ico" href="../public/images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>General Affair</title>
<link href="../public/style/style.css" rel="stylesheet" type="text/css" />
<link href="../public/style/css-menu/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../public/style/css-menu/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../public/plugins/jquery.js"></script>

<style type="text/css">
* html .images_trans { 
	behavior: url(../public/hack/iepngfix.htc);
}
</style>
<!--[if lt IE 7]>
<script type="text/javascript" src="../public/plugins/jquery.helper.js"></script>
<![endif]-->
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
		<td style="background: url(../public/images/header.png);" height="100"><img src="../public/images/ga.png" /></td>
	</tr>
	<tr>
		<td height="50" style="background:url(../public/images/lines-black.png);" class="container-menu" valign="top" width="95%">
							<div id="halaman-utama">
				<img src="../public/images/house.png" border="0" class="images_trans" align="absmiddle" />&nbsp;&nbsp;&nbsp;<a href="../index.php">Halaman Utama</a>
                
                
                <?php 
	
				if(!empty($SE_UserId)){
				
				?>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="frm_permintaan_brg.php">Form Permintaan Barang</a>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="javascript:;">Catatan Permintaan Barang</a>
                	
					<?php 
                    $sql = mysqli_query($jazz,"SELECT x FROM tabel_departemen WHERE user_approve = '$SE_UserId'");
                    $ada = mysqli_num_rows($sql);
                    if($ada>=1){
                    ?>
                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <a href="frm_konfirmasi_permintaan_brg.php">Persetujuan Permintaan Barang</a>
                    <?php } ?>
                    
                <?php 
				}
				?>
                
                
				</div>
					</td>
	</tr>
	<tr>
		<td align="center">
			
            
            
            
            
            
            
            
            







<link href="../public/style/style.css" rel="stylesheet" type="text/css" />
<link href="../public/style/bootstrap.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../public/plugins/jquery.js"></script>
<script type="text/javascript" src="../public/script/app.js"></script>
<script type="text/javascript">
function mask(str,textbox,loc,delim) {
	var locs 	= loc.split(',');

	for (var i = 0; i <= locs.length; i++) {
		for (var k = 0; k <= str.length; k++) {
	 		if(k == locs[i]) {
	  			if(str.substring(k, k+1) != delim) {
	    			str = str.substring(0,k) + delim + str.substring(k,str.length)
	  			}
	 		}
		}
 	}
	
	textbox.value = str
}
</script>
<body onLoad="startFocus(document.myform.text_tgl_butuh)">
<head>
	<script type="text/javascript" src="../public/script/jquery.min.js"></script>
</head>
<div id="loaded_contents">
<table border="0" cellpadding="0" cellspacing="0" width="798px" style="margin: 0 auto;" align="center" id="form_posting">
	<tr>
		<td width="798" height="30">&nbsp;</td>
	</tr>
	<tr>

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
					echo '<option value="'.$tahunx.'" '.$select_t.'> &nbsp; '.$tahunx.' &nbsp;</option>' ;
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
</div>




<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:350px;top:1px">
        <div class="modal-content">
            <div class="modal-header">
                <form action="../ga/proses_hapus_permintaan_brg.php" method="post">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Konfirmasi Tindakan</h4>
            </div>
            <div class="modal-body">
                
                <div class="form-group input-group">
                    Yakin ingin hapus permintaan <span style="color:#880002" id="brg">ATK0002 <br/>( jakabkdaskbjkabcab )</span>
                    <input type="hidden" name="kode_x" id="kode_x">
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Hapus</button> &nbsp; 
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">

function ganti() {
	txt_bulan = $( "#filter_bulan option:selected" ).val();
	txt_tahun = $( "#filter_tahun option:selected" ).val();
	$.ajax({
		type: "POST",
		url: "../ga/cari_data_barang.php",
		data: 'aksi=2&tahun=' + txt_tahun + '&bulan=' + txt_bulan,
		cache: false,
		beforeSend: function()
		{
		},
		success: function(response)
		{
			$("#loaded_contents").show().fadeIn(1000).html(response);
		}
	});
};


function kode_x(x,tgl) {
	$("#kode_x").val(x);
	$("#brg").html( "Tanggal " + tgl );
}

</script>

<script src="../public/script/bootstrap.min.js"></script>












            
            
            
		</td>
	</tr>
</table>
</body>
</html>
