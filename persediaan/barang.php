<?php 
include('head.php');


if(!isset($_SESSION['id'])){
	echo '<script>window.location= "index.php";</script>';
	exit;
}

$pesan='';

if(isset($_POST['kirim'])){
	$a = $_POST['kode'];
	$b = $_POST['brg'];
	$c = $_POST['satuan'];
	$d = $_POST['harga'];
	$e = $_POST['radio1'];
	$f = $_POST['batas'];
	$x = $_POST['even'];
	
	if ($_POST['radio1'] == '1'){ $e = '1' ; }else{ $e = '0' ; }
	
	if($b!='' && $d!=''){
		
		if($x=='new'){
				
			mysqli_query($jazz,
			"INSERT INTO barang VALUES('', '$a', '$b', '$c', '$d', '$e', '0', '0', '0', '$f')");
			
			//////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'INSERT Barang kode ' . $a . ' ' . $b ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			//////////////////
			
		}else{
			
			mysqli_query($jazz,"UPDATE barang SET 
			brg = '$b',
			satuan = '$c', 
			harga = '$d',
			statusx = '$e',
			batasmin = '$f'
			WHERE kodebrg = '$a'");
			
			//////////////////
			$tgl = date('Y-m-d H:i:s') ;
			$aksi = 'UPDATE Barang kode ' . $a . ' ' . $b ;
			$ip = gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' - ' . $_SERVER['REMOTE_ADDR'];
			mysqli_query($jazz,"INSERT INTO log_aksi VALUES('', '$_SESSION[u]', '$tgl', '$aksi', '$ip')");
			//////////////////
			
		}
		echo '<script>window.location= "listbarang.php";</script>';
		exit();
	}else{
		$pesan='<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					Maaf, Gagal cin..!
			  </div>';
	}
}




if(empty($_GET['kode'])){
	$sql = mysqli_query($jazz,"SELECT RIGHT(kodebrg,4) FROM barang WHERE LEFT(kodebrg,3) = 'ATK' ORDER BY kodebrg DESC LIMIT 0,1");
	$x = mysqli_fetch_array($sql);
	if($x[0] ==''){ $x[0] = 0; }
	$x = floattostr($x[0]) + 1 ;
	$event = 'new';
	$btn = 'Simpan';
	$data[1] = 'ATK' . sprintf("%04d", $x);
	$data[2] = '';
	$data[3] = '';
	$data[4] = '';
	$data[5] = '1';
	$data[6] = '0';
	$data[7] = '0';
	$data[8] = '0';
	$data[9] = '0';
}else{
	$kd = $_GET['kode'] ;
	$sql = mysqli_query($jazz,"SELECT *	FROM barang	WHERE kodebrg = '$kd'");
	$data = mysqli_fetch_array($sql);
	$event = 'edit';
	$btn = 'Update';
}
?>







<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        
        
        <div class="row">
        
            <div class="col-md-12 col-sm-12">
        
             <!--  table  --> 
             <div class="panel panel-default">
                <div class="panel-heading">
                   Form Input Barang
                </div>
                <div class="panel-body">
                    <div class="table-responsive" align="center">
                    	<form method="post" action="">
                		<input name="even" type="hidden" value="<?php echo $event; ?>">
                        <?php echo $pesan ;?>
                        <table border="0">
                            <tbody>
                                <tr style="height:30px">
                                    <td width="120px" align="right">Kode</td>
                                    <td width="20px" align="center">:</td>
                                    <td width="4px">
                                    	<input name="kode" id="kodebrg" type="text" readonly 
                                        style="background-color:#D0F5BE;text-align:center" value="<?php echo $data[1] ;?>" />
                                    </td>
                                    <td width="300px"> &nbsp;  
                                    	<?php if($event!='edit') { ?>
                                        <input type="radio" name="op" class="op1" value="ATK" checked /> ATK &nbsp; 
                                        <input type="radio" name="op" class="op1" value="CTK" /> CTK &nbsp; 
                                        <input type="radio" name="op" class="op1" value="PKR" /> PKR &nbsp; 
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Nama Barang</td>
                                    <td align="center">:</td>
                                    <td colspan="2">
                                    	<input name="brg" type="text" style="width:350px" 
                                    	value="<?php echo $data[2] ;?>" />
                                    </td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Unit</td>
                                    <td align="center">:</td>
                                    <td>
                                    
                                    	<select name="satuan">
                                            <?php 
											$q =mysqli_query($jazz,"SELECT * FROM unite ORDER BY unite ASC");
											while($rs = mysqli_fetch_array($q)){
												if($data[3]==$rs[1]){
													$selected = 'selected' ;
												}else{
													$selected = '' ;
												}
												echo '<option value="'.$rs[1].'" '.$selected.'>'.$rs[1].'</option>' ;
											}
											?>
                                        </select>
                                        
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Harga</td>
                                    <td align="center">:</td>
                                    <td>
                                        <input name="harga" style="text-align:right" onKeypress="return isNumber(event)" 
                                        type="text" value="<?php echo $data[4] ;?>" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Status</td>
                                    <td align="center">:</td>
                                    <td><input type="checkbox" name="radio1" value="1" <?php if($data[5]=='1') {echo 'checked';} ?> /> Tersedia</td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Batas Min. Stok</td>
                                    <td align="center">:</td>
                                    <td>
                                    	<input type="text" name="batas" style="text-align:right" onKeypress="return isNumber(event)" 
                                        value="<?php echo $data[9] ;?>"/>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Masuk</td>
                                    <td align="center">:</td>
                                    <td>
                                    	<input type="text" readonly style="background-color:#D0F5BE;text-align:right"
                                    	value="<?php echo $data[6] ;?>" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Keluar</td>
                                    <td align="center">:</td>
                                    <td>
                                    	<input type="text" readonly style="background-color:#D0F5BE;text-align:right" 
                                         value="<?php echo $data[7] ;?>" />
                                     </td>
                                    <td></td>
                                </tr>
                                <tr style="height:30px">
                                    <td align="right">Sisa</td>
                                    <td align="center">:</td>
                                    <td>
                                    	<input type="text" readonly style="background-color:#D0F5BE;text-align:right" 
                                    	value="<?php echo $data[8] ;?>" />
                                    </td>
                                    <td></td>
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

$(".op1").click(function(){
	txt_op = $(".op1:checked").val();
	$.ajax({
		type: "POST",
		url: "act/buat_kode_barang.php",
		data: 'aksi=1&txt_op=' + txt_op,
		cache: false,
		beforeSend: function()
		{
			$("#kodebrg").val('load...');
		},
		success: function(response)
		{
			$("#kodebrg").val(response);
			
		}
	});
});

</script>
    
    
<?php 
include('foot.php'); 
?>