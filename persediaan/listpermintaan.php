<?php 
include('head.php'); 

if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
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

<link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
            <div class="col-md-12">



                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="javascript:;" data-toggle="tab">Data</a>
                        </li>
                    </ul>
    
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="databrg">
                            <h3 align="center">Daftar Data Permintaan Barang</h3>
                            <div class="panel-body">
                            
                            
                            <table class="table table-striped table-bordered table-hover">
                               <tr>
                               <td align="right">
                            <select name="filter_bulan" id="filter_bulan" class="form-control" style="width:180px;" onChange="ganti();">
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
                            	</td>
                             	<td width="100px">
                            <select name="filter_tahun" id="filter_tahun" class="form-control" style="width:100px;" onChange="ganti();">
                                    
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
                            	</td>
                              </tr>
                            </table>
                            <div class="table-responsive">
        
                            
                            
                            
<div id="loaded_contents">
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
    
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
    
	<tr>
		<td height="50" class="object_label">
            
            <div style="margin:0px 10px 0px 10px"> 
            
            
            
            
            <?php 
			if($data2['dilihat']=='0'){ 
				if($data2['approve']=='0'){ 
					echo '<span style="float:right">
						<a data-toggle="modal" data-target="#myModal"
                        href="javascript:;" title="Delete" onclick="getnopermintaan('.$data2['x'].')">
						<img src="../public/images/delete.png"/></a>
					</span>' ;
				}else{
					$sql23 = mysqli_query($jazz,"SELECT x FROM db_persediaan.rinci_permintaan WHERE idx = '$data2[x]' AND sudah = '1'");
					$ada_tidak = mysqli_num_rows($sql23);
					if($ada_tidak >= 1){
						echo '<span style="float:right">
						<a href="get_permintaan.php?kode='.$data2['kodepm'].'"><img src="../public/images/led.gif"/></a>
						</span>';
					}else{
						echo '<span style="float:right">
						<a href="get_permintaan.php?kode='.$data2['kodepm'].'"><img src="../public/images/led.gif"/></a>
						<br/>
						<a data-toggle="modal" data-target="#myModal"
                        href="javascript:;" title="Delete" onclick="getnopermintaan('.$data2['x'].')">
						<img src="../public/images/delete.png"/></a>
						</span>';
					}
				}
			}else{
				echo '<span style="float:right"><a href="get_permintaan.php?kode='.$data2['kodepm'].'"><img src="../public/images/OK.png"/></a></span>' ;
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
</div>
                                
                                
                              </div>
                             </div>
                        </div>
                    </div>
                </div>

    

            </div>
            
        </div>     
         <!-- /. ROW  -->           
    </div>
     <!-- /. PAGE INNER  -->
 </div>
 <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->










<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:500px;top:10px">
        <div class="modal-content">
            
            <form method="post" action="deletepermintaan.php">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Yakin Ingin Hapus ?</h4>
            </div>
            <div class="modal-body">
                
                <input name="nopermintaan" id="nopermintaan" type="hidden"/>
                Masukan password terlebih dahulu &nbsp;
                <input name="pass" class="text input" type="password" style="text-align:center"/>
                
            </div>
            <div class="modal-footer" style="text-align:center">
                <input type="submit" class="btn btn-primary" value="Hapus" />
                &nbsp; &nbsp; &nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
            
            </form>
            
        </div>
    </div>
</div>











<script type="text/javascript">

function ganti() {
	txt_bulan = $( "#filter_bulan option:selected" ).val();
	txt_tahun = $( "#filter_tahun option:selected" ).val();
	$.ajax({
		type: "POST",
		url: "act/query_data_barang.php",
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


function kode_x(x,kodebrg,namabrg) {
	$("#kode_x").val(x);
	$("#brg").html( kodebrg + "<br/>( " + namabrg + " )" );
}


function getnopermintaan(nopermintaan) {
	$('#nopermintaan').val(nopermintaan);
	$('#myModalLabel').html('Yakin Ingin Hapus permintaan terpilih ?');
}

</script>
    
    
<?php 
include('foot.php'); 
?>