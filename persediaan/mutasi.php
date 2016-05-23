<?php 
include('head.php');


if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

$pesan='';


if(isset($_POST['kirim'])){
	
	if($_POST['stokbrg'] < $_POST['jml'] && $_POST['radio1']=='2'){
		$pesan='<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Maaf, Gagal cin..!
			  </div>';
	}elseif($_POST['jml'] != '0' && $_POST['jml'] != '' && $_POST['ket'] != '' && $_POST['kodebrg'] != ''){
	
		$a = $_POST['nomutasi'];
		$b = $_POST['tgl'];
		$c = $_POST['kodebrg'];
		$d = $_POST['radio1'];
		$e = $_POST['jml'];
		$f = $_POST['ket'];
		$x = $_POST['even'];
		
		$k = explode('/',$b);
		$b = $k[2] . '-' . $k[1] . '-' . $k[0] . ' ' . date('h:i:s') ;
		
		if($x=='new'){
				
			mysqli_query($jazz,"INSERT INTO mutasi VALUES('', '$a', '$b', '$c', '$d', '$f', '$e','-')");
			$sql = mysqli_query($jazz,"SELECT sisa, masuk, keluar FROM barang WHERE kodebrg = '$c'");
			$data = mysqli_fetch_array($sql);
			$sisa = $data[0];
			$masuk = $data[1];
			$keluar = $data[2];
			if($d=='1'){
				$sisa = $sisa + $e;
				$masuk = $masuk + $e ;
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', masuk = '$masuk' WHERE kodebrg = '$c'");
			}else{
				$sisa = $sisa - $e;
				$keluar = $keluar + $e ;
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', keluar = '$keluar' WHERE kodebrg = '$c'");
			}
			
			
			//////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'Insert Mutasi No. ' . $a ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			//////////////////
			
			
			
		}else{
			
			$sql3 = mysqli_query($jazz,"SELECT mutasi, jml FROM mutasi WHERE nomutasi = '$a'");
			$data3 = mysqli_fetch_array($sql3);
			
			mysqli_query($jazz,"UPDATE mutasi SET 
						tgl = '$b',
					 mutasi = '$d', 
				 keterangan = '$f',
						jml = '$e'
						  WHERE 
				   nomutasi = '$a'");
				   
			if($data3['mutasi'] == '1'){
				
				$sql4 = mysqli_query($jazz,"SELECT sisa, masuk FROM barang WHERE kodebrg = '$c'");
				$data4 = mysqli_fetch_array($sql4);
				$sisa = $data4[0] - $data3['jml'];
				$masuk = $data4[1] - $data3['jml'];
				
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', masuk = '$masuk' WHERE kodebrg = '$c'");
				
			}else{
				
				$sql4 = mysqli_query($jazz,"SELECT sisa, keluar FROM barang WHERE kodebrg = '$c'");
				$data4 = mysqli_fetch_array($sql4);
				$sisa = $data4[0] + $data3['jml'];
				$keluar = $data4[1] + $data3['jml'];
				
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', keluar = '$keluar' WHERE kodebrg = '$c'");
				
			}
			
			$sql = mysqli_query($jazz,"SELECT sisa, masuk, keluar FROM barang WHERE kodebrg = '$c'");
			$data = mysqli_fetch_array($sql);
			$sisa = $data[0];
			$masuk = $data[1];
			$keluar = $data[2];
			if($d=='1'){
				$sisa = $sisa + $e;
				$masuk = $masuk + $e ;
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', masuk = '$masuk' WHERE kodebrg = '$c'");
			}else{
				$sisa = $sisa - $e;
				$keluar = $keluar + $e ;
				mysqli_query($jazz,"UPDATE barang SET sisa = '$sisa', keluar = '$keluar' WHERE kodebrg = '$c'");
			}
			
			
			//////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'UPDATE Mutasi No. ' . $a ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			//////////////////
			
			
		}
		echo '<script>window.location= "listmutasi.php";</script>';
		exit();
	
	}else{
		$pesan='<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Maaf, Gagal cin..!
			  </div>';
	}
}




if(empty($_GET['nomutasi'])){
	$sql = mysqli_query($jazz,"SELECT x	FROM mutasi	ORDER BY x DESC LIMIT 0,1");
	$x = mysqli_fetch_array($sql);
	if($x[0] ==''){ $x[0] = 0; }
	$x 					= $x[0] + 1 ;
	$event 				= 'new';
	$btn 				= 'Simpan';
	$data['nomutasi'] 	= sprintf("%012d", $x);;
	$data['tgl'] 		= date('d/m/Y');
	$data['kodebrg'] 	= '';
	$data['keterangan'] = '';
	$data['mutasi'] 	= '2';
	$data['jml'] 		= '0';
}else{
	$nomor = $_GET['nomutasi'] ;
	$sql = mysqli_query($jazz,"SELECT m.*, b.brg, b.sisa FROM mutasi m INNER JOIN barang b ON m.kodebrg = b.kodebrg WHERE nomutasi = '$nomor'");
	$data = mysqli_fetch_array($sql);
	$event = 'edit';
	$btn = 'Update';
	$k = explode('-',substr($data[2],0,10));
	$data['tgl'] = $k[2] . '/' . $k[1] . '/' . $k[0]  ;

}
?>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:900px;top:10px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Pilih Salah Satu Barang</h4>
            </div>
            <div class="modal-body">
                
                <div class="form-group input-group">
                    <input name="txt_brg" type="text" class="form-control" id="txt_brg" autocomplete="off" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                
                <div id="loaded_contents">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align:center">Kode Barang</th>
                                <th style="text-align:center">Nama Barang</th>
                                <th style="text-align:center">Satuan</th>
                                <th style="text-align:center">Harga</th>
                                <th style="text-align:center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $sql2 = mysqli_query($jazz,"SELECT * FROM barang WHERE statusx = '1' ORDER BY brg ASC LIMIT 0,10");
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
                                <td align="right"><?php echo number_format($data2[4], 0, '', '.') ;?></td>
                                <td><?php if($data2[5]=='1') { echo 'Tersedia'; }else{ echo 'Tidak Tersedia'; } ;?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>







<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
        
            <div class="col-md-12 col-sm-12">
        
             <!--  table  --> 
             <div class="panel panel-default">
                <div class="panel-heading">
                   Form Mutasi Barang
                </div>
                <div class="panel-body">
                    <div class="table-responsive" align="center">
                   	  <form method="post" action="">
                		<input name="even" type="hidden" value="<?php echo $event; ?>">
                        <?php echo $pesan ;?>
                        <table border="0">
                            <tbody>
                                <tr style="height:30px">
                                    <td width="120" align="right">Nomor Mutasi</td>
                                    <td width="20" align="center">:</td>
                                    <td width="4">
                                    	<input name="nomutasi" type="text" readonly value="<?php echo $data['nomutasi'] ;?>" style="background-color:#D0F5BE;text-align:center"/>
                                    </td>
                                    <td width="300">
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Tanggal</td>
                                    <td align="center">:</td>
                                    <td colspan="2">
                                    	<input name="tgl" type="text"  value="<?php echo $data['tgl'] ;?>" />
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Kode Barang</td>
                                    <td align="center">:</td>
                                    <td>
                                    
                                    	<input name="kodebrg" type="text" autocomplete="off"
                                        value="<?php echo $data['kodebrg'] ;?>" id="kodebrg" 
										<?php if($event=='edit'){ echo 'readonly style="background-color:#D0F5BE"' ;} ?>/>

                                    </td>
                                    <td> &nbsp; 
                                    	<?php if($event!='edit'){  ?>
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                          Browse...
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Nama Barang</td>
                                    <td align="center">:</td>
                                    <td colspan="2">
                                        <input type="text" readonly value="<?php //echo $data['brg'] ;?>" id="namabrg" style="background-color:#D0F5BE;width:400px"/>
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Sisa Stok</td>
                                    <td align="center">:</td>
                                    <td>
                                    	<input name="stokbrg" type="text" readonly value="<?php //echo $data['sisa'] ;?>" id="stokbrg" style="background-color:#D0F5BE;text-align:right"/>
                                    </td>
                                    <td>&nbsp;<span id="satuan"></span></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right" valign="top">Mutasi</td>
                                    <td align="center" valign="top">:</td>
                                    <td>
                                        <input name="radio1" value="1" type="radio" id="radio1" 
										<?php if($data['mutasi']=='1') {echo 'checked="checked"';} ?>> Masuk <br />
                                        <input name="radio1" value="2" type="radio" id="radio2" 
										<?php if($data['mutasi']=='2') {echo 'checked="checked"';} ?>> Keluar
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Jumlah</td>
                                    <td align="center">:</td>
                                    <td>
                                    	<input name="jml" onKeypress="return isNumber(event)" style="text-align:right"
                                        type="text" value="<?php echo $data['jml'] ;?>" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Keterangan</td>
                                    <td align="center">:</td>
                                    <td colspan="2">
                                    	<input name="ket" style="width:400px" type="text" value="<?php echo $data['keterangan'] ;?>"/>
                                     </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr style="height:30px">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td align="center">
                                    	<input class="btn btn-primary btn-sm" type="submit" name="kirim" value="<?php echo $btn ;?>" />
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /. table  -->
            </div>
            
        </div>     
         <!-- /. ROW  -->           
    </div>
     <!-- /. PAGE INNER  -->
 </div>
 <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->




<script>

function getdatabrg(kd,nama,stok,satuan) {
	$('#kodebrg').val(kd);
	$('#namabrg').val(nama);
	$('#stokbrg').val(stok);
	$('#satuan').html(satuan);
}

$("#txt_brg").keyup(function(){
	txt_brg = $("#txt_brg").val();
	n = txt_brg.length ;
	if(n>=3){
		$.ajax({
			type: "POST",
			url: "act/cari_data_barang.php",
			data: 'aksi=1&brg=' + txt_brg,
			cache: false,
			beforeSend: function()
			{
				$("#loaded_contents").html('Mengambil data...');
			},
			success: function(response)
			{
				$("#loaded_contents").html(response);
				
			}
		});
	}
});

$("#kodebrg").keyup(function(){
	kodebrg = $("#kodebrg").val();
	n = kodebrg.length ;
	if(n>=7){
		$.ajax({
			type: "POST",
			url: "act/cari_data_barang.php",
			data: 'aksi=3&kodebrg=' + kodebrg,
			cache: false,
			beforeSend: function()
			{
				
			},
			success: function(response)
			{
				if(response!='NONE'){
					str = response.split("|");
					$("#namabrg").val(str[0]);
					$("#stokbrg").val(str[2]);
					$("#satuan").html(str[1]);
				}else{
					$("#namabrg").val('');
					$("#stokbrg").val('');
					$("#satuan").html('');
					alert("Kode yang dimaksud tidak ada dalam database");
				}
			}
		});
	}
});
</script>
    
    
<?php 
include('foot.php'); 
?>