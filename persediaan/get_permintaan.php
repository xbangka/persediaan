<?php 
include('head.php');


if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

$pesan='';


if(isset($_POST['kirim'])){
	
	if( $_POST['stokbrg'] < $_POST['jml'] ){
		$pesan='<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Maaf, Stok barang tidak mencukupi...!
			    </div>';
	}elseif($_POST['jml'] != '0' && $_POST['jml'] != '' && $_POST['ket'] != ''){
		
		$k = explode('/',$_POST['tgl']);
		$b = $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . date('H:i:s');
		
		$b = $b;
		$c = $_POST['kodebrg'];
		$d = '2';
		$e = $_POST['jml'];
		$f = $_POST['ket'];
		$g = $_POST['kodepm'];
		$h = $_POST['idx_rinci'];
		$x = $_POST['even'];
		
		if($x=='new'){
			
			$sql = mysqli_query($jazz,"SELECT x	FROM mutasi	ORDER BY x DESC LIMIT 0,1");
			$y = mysqli_fetch_array($sql);
			
			if($y[0]==''){ $y[0]= 0; }
			$y 	= $y[0] + 1 ;
			$a 	= sprintf("%012d", $y);
			
			mysqli_query($jazz,"INSERT INTO mutasi VALUES('', '$a', '$b', '$c', '$d', '$f', '$e', '$h')");
			$sql = mysqli_query($jazz,"SELECT sisa, masuk, keluar FROM barang WHERE kodebrg = '$c'");
			$data = mysqli_fetch_array($sql);
			$sisa = $data[0];
			$masuk = $data[1];
			$keluar = $data[2];
			
			
			//////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'INSERT Mutasi No. ' . $a ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			//////////////////
			
		
			$sisa = $sisa - $e ;
			$keluar = $keluar + $e ;
			mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', keluar = '$keluar' WHERE kodebrg = '$c'");
			mysqli_query($jazz,"UPDATE rinci_permintaan SET sudah = '1' WHERE x = '$h'");
			
			$sql = mysqli_query($jazz,"SELECT x FROM rinci_permintaan WHERE kodepm = '$g' AND sudah = '0'");
			$ada = mysqli_num_rows($sql);
			
			if($ada==0){
				mysqli_query($jazz,"UPDATE permintaan SET dilihat = '1' WHERE kodepm = '$g'");
				echo '<script>window.location= "listpermintaan.php";</script>';
				exit();
			}else{
				echo '<script>window.location= "get_permintaan.php?kode='.$g.'";</script>';
				exit();
			}
			
			
		}
		
	
	}else{
		$pesan='<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Maaf, Gagal cin..!
			    </div>';
	}
}




if(!empty($_GET['kode'])){
	
	$sql2 = mysqli_query($jazz,"SELECT * FROM permintaan WHERE kodepm = '$_GET[kode]' AND dilihat = '0'");
	$ada = mysqli_num_rows($sql2);
	
	if($ada==0){ /*exit();*/ }
	
	$data2 = mysqli_fetch_array($sql2);
	
	$event 				= 'new';
	$btn 				= 'Simpan';
	$data['tgl'] 		= date('d/m/Y');
	$data['keterangan'] = 'Permintaan '.$data2['nama']. ' ('. $data2['departemen'] .')';
	
}else{
	exit();
}


$filebarcode = '../ga/barcode/'.strtolower($_GET['kode']).'.png';
?>



<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
        
            <div class="col-md-12 col-sm-12">
        
             
			<?php
			$n = 0 ;
            $q2 = mysqli_query($jazz,"SELECT * FROM rinci_permintaan WHERE kodepm='$_GET[kode]' ORDER BY sudah ASC");
            while($rs = mysqli_fetch_array($q2)){
                $n += 1 ;
				
				$sql3 = mysqli_query($jazz,"SELECT sisa, satuan FROM barang WHERE kodebrg = '$rs[kodebrg]'");
				$data3 = mysqli_fetch_array($sql3);
				$data['sisa'] 		= $data3['sisa'];
				$data['satuan']		= $data3['satuan'];
            ?>
             
             
             
             <!--  table  --> 
             <div class="panel panel-default">
                <div class="panel-heading">
                   Form Mutasi Barang <span style="float:right;color:#940002"><b><?php echo $n; ?></b></span>
                </div>
                <div class="panel-body">
                    <div class="table-responsive" align="center">
                   	  <form method="post" action="" name="myform<?php echo $n; ?>">
                		<input name="even" type="hidden" value="<?php echo $event; ?>">
                        <input name="kodepm" type="hidden" value="<?php echo $_GET['kode']; ?>">
                        <input name="idx_rinci" type="hidden" value="<?php echo $rs['x']; ?>">
                        <?php echo $pesan ;?>
                        <table border="0">
                            <tbody>
                                <tr style="height:30px">
                                    <td width="120" align="right">&nbsp;</td>
                                    <td width="120" align="right">Nomor Mutasi</td>
                                    <td width="20" align="center">:</td>
                                    <td width="4">
                                    <?php 
									if($rs['sudah'] != '1'){
									?>
                                    	<input name="nomutasi" type="text" readonly value="<?php echo '-';?>" 
                                        style="background-color:#D0F5BE;text-align:center"/>
                                    <?php 
									}else{
										$sql  = mysqli_query($jazz,"SELECT * FROM mutasi WHERE idx_rinci = '$rs[x]'");
										$ds = mysqli_fetch_array($sql);
										echo '<b>' . $ds['nomutasi'] . '</b>';
									}
									?>
                                    </td>
                                    <td width="300">&nbsp;
                                    </td>
                                    <td width="120" rowspan="4" valign="top" align="center">
                                    	<img src="<?php echo $filebarcode ; ?>"/>
                                        <b><?php echo strtoupper($_GET['kode']); ?></b>
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                  <td align="right">&nbsp;</td>
                                    <td align="right">Tanggal</td>
                                    <td align="center">:</td>
                                    <td>
                                    <?php 
									if($rs['sudah'] != '1'){
									?>
                                    	<input name="tgl" type="text" value="<?php echo $data['tgl'] ;?>" />
                                    <?php 
									}else{
										$k = explode('-',substr($ds['tgl'],0,10));
										$l = substr($ds['tgl'],11,5);
										$b = $k[2] . '/' . $k[1] . '/' . $k[0] . ' ' . $l;
										echo '<b>' . $b . '</b>';
									}
									?>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                  <td align="right">&nbsp;</td>
                                    <td align="right">Kode Barang</td>
                                    <td align="center">:</td>
                                    <td>
                                    <?php 
									if($rs['sudah'] != '1'){
									?>
                                    
                                    	<input name="kodebrg" type="text" autocomplete="off" style="background-color:#D0F5BE;"
                                        value="<?php echo $rs['kodebrg'] ;?>" id="kodebrg" readonly />

                                    <?php 
									}else{
										
										echo '<b>' . $ds['kodebrg'] . '</b>';
									}
									?>
                                    </td>
                                    <td>&nbsp;  
                                    	
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                  <td align="right">&nbsp;</td>
                                    <td align="right">Nama Barang</td>
                                    <td align="center">:</td>
                                    <td colspan="2">
                                    <?php 
									if($rs['sudah'] != '1'){
									?>
                                    
                                        <input type="text" readonly value="<?php echo $rs['namabrg'] ;?>" id="namabrg" style="background-color:#D0F5BE;width:400px"/>
                                    <?php 
									}else{
										
										echo '<b>' . $rs['namabrg'] . '</b>';
									}
									?>
                                    </td>
                                </tr>
                                <?php 
								if($rs['sudah'] != '1'){
								?>
                                <tr style="height:30px">
                                  <td align="right">&nbsp;</td>
                                    <td align="right">Sisa Stok</td>
                                    <td align="center">:</td>
                                    <td>
                                    	<input name="stokbrg" type="text" readonly value="<?php echo $data['sisa'] ;?>" id="stokbrg" style="background-color:#D0F5BE;text-align:right"/>
                                    </td>
                                    <td>&nbsp;<span id="satuan"><?php echo $data['satuan']; ?></span></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php 
								}
								?>
                                <tr style="height:30px">
                                  <td align="right" valign="top">&nbsp;</td>
                                    <td align="right" valign="top">Mutasi</td>
                                    <td align="center" valign="top">:</td>
                                    <td valign="top"> Keluar
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="height:30px">
                                  <td align="right">&nbsp;</td>
                                    <td align="right">Jumlah</td>
                                    <td align="center">:</td>
                                    <td>
                                    <?php 
									if($rs['sudah'] != '1'){
									?>
                                    	<input name="jml" style="background-color:#D0F5BE;text-align:right"
                                        type="text" readonly value="<?php echo $rs['jml'] ;?>" />
                                    <?php 
									}else{
										
										echo '<b style="float:right">' . $ds['jml'] . '</b>';
									}
									?>
                                    </td>
                                    <td>&nbsp;<span><?php echo $data['satuan']; ?></span></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="height:30px">
                                  <td align="right">&nbsp;</td>
                                    <td align="right">Keterangan</td>
                                    <td align="center">:</td>
                                    <td colspan="3">
                                    <?php 
									if($rs['sudah'] != '1'){
									?>
                                    	<input name="ket" style="width:400px" type="text" value="<?php echo $data['keterangan'] ;?>"/>
                                     <?php 
									}else{
										
										echo '<b>' . $ds['keterangan'] . '</b>';
									}
									?>
                                     </td>
                                </tr>
                                
                                <?php 
								if($rs['sudah'] != '1'){
								?>
                                <tr>
                                  <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="height:30px">
                                  <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center">
                                    	<input class="btn btn-primary btn-sm" type="submit" name="kirim" value="<?php echo $btn ;?>" />
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php 
								}
								?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /. table  -->
            
            
            
            
            <?php
			}
            ?>
            
            
            
            
            
            
            
            
            </div>
            
        </div>     
         <!-- /. ROW  -->           
    </div>
     <!-- /. PAGE INNER  -->
 </div>
 <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->


    
<?php 
include('foot.php'); 
?>